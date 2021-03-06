<?php

/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

/** ActionController of Core */
namespace Jobs\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Stdlib\Parameters;
use Core\Entity\PermissionsInterface;

/**
 * 
 *
 */
class ImportController extends AbstractActionController {

    /**
     * attaches further Listeners for generating / processing the output
     * @return $this
     */
    public function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $serviceLocator  = $this->getServiceLocator();
        $defaultServices = $serviceLocator->get('DefaultListeners');
        $events          = $this->getEventManager();
        $events->attach($defaultServices);
        return $this;
    }

    /**
     * api-interface for transferring jobs
     * @return JsonModel
     */
    public function saveAction() {

        $services = $this->getServiceLocator();
        $config   = $services->get('Config');
        
        if (False && isset($config['debug']) && isset($config['debug']['import.job']) && $config['debug']['import.job']) {

            // Test
            $this->request->setMethod('post');
            $params = new Parameters(array(
                'applyId' => '71022',
                'company' => 'Holsten 4',
                'companyId' => '1745',
                'contactEmail' => 'stephanie.roghmans@kraft-von-wantoch_test.de',
                'title' => 'Fuhrparkleiter/-in',
                'location' => 'Bundesland, Bayern, DE',
                'link' => 'http://anzeigen.jobsintown.de/job/1/79161.html',
                'datePublishStart' => '2013-11-15',
                'status' => 'aktiv',
                'reference' => '2130010128',
                'atsEnabled' => '1',
                'logoRef' => 'http://anzeigen.jobsintown.de/companies/logo/image-id/3263',
                'publisher' => 'http://anzeigen.jobsintown.de/feedbackJobPublish/' . '2130010128',
                'imageUrl' => 'http://th07.deviantart.net/fs71/PRE/i/2014/230/5/8/a_battle_with_the_elements_by_lordljcornellphotos-d7vns0p.jpg',
            ));
            $this->getRequest()->setPost($params);
        }        

        $params          = $this->params();
        $p               = $params->fromPost();
        $user            = $services->get('AuthenticationService')->getUser();
        $repositories    = $services->get('repositories');
        $repositoriesJob = $repositories->get('Jobs/Job');
        $log             = $services->get('Core/Log');
        //if (isset($user)) {
        //    $services->get('Core/Log')->info('Jobs/manage/saveJob ' . $user->login);
        //}
        $result = array('token' => session_id(), 'isSaved' => False, 'message' => '');
        if (isset($user) && !empty($user->login)) {
            $formElementManager = $services->get('FormElementManager');
            $form               = $formElementManager->get('Jobs/Import');
            $id                 = $params->fromPost('id'); // determine Job from Database
            $entity             = Null;

            if (empty($id)) {
                $applyId = $params->fromPost('applyId');
                if (empty($applyId)) {
                    // new Job (propably this branch is never used since all Jobs should have an apply-Id)
                    $entity = $repositoriesJob->create();
                } else {
                    $entity = $repositoriesJob->findOneBy(array("applyId" => (string) $applyId));
                    if (!isset($entity)) {
                        // new Job (the more likely branch)
                        $entity =$repositoriesJob->create(array("applyId" => (string) $applyId));
                    }
                }
            } else {
                $repositoriesJob->find($id);
            }
            //$services->get('repositories')->get('Jobs/Job')->store($entity);

            $form->bind($entity);
            if ($this->request->isPost()) {
                $loginSuffix                   = '';
                $event                         = $this->getEvent();
                $loginSuffixResponseCollection = $this->getEventManager()->trigger('login.getSuffix', $event);
                if (!$loginSuffixResponseCollection->isEmpty()) {
                    $loginSuffix = $loginSuffixResponseCollection->last();
                }
                $params                        = $this->getRequest()->getPost();
                $params->datePublishStart      = \Datetime::createFromFormat("Y-m-d",$params->datePublishStart);
                $result['post']                = $_POST;
                $form->setData($params);
                if ($form->isValid()) {
                    $entity->setUser($user);
                    $group = $user->getGroup($entity->getCompany());
                    if ($group) {
                        $entity->getPermissions()->grant($group, PermissionsInterface::PERMISSION_VIEW);
                    }
                    $result['isSaved'] = true;
                    $log->info('Jobs/manage/saveJob [user: ' . $user->login . ']:' . var_export($p, True));
                    
                    if (!empty($params->companyId)) {
                        $companyId                = $params->companyId . $loginSuffix;
                        $repOrganization          = $repositories->get('Organizations/Organization');
                        $hydratorManager          = $services->get('hydratorManager');
                        $hydrator                 = $hydratorManager->get('Hydrator/Organization');
                        $entityOrganizationFromDB = $repOrganization->findbyRef($companyId);
                        $permissions              = $entityOrganizationFromDB->getPermissions();
                        $data = array(
                            'externsalId'      => $params->companyId,
                            'organizationName' => $params->company,
                            'image'            => $params->logoRef
                        );
                        $permissions->grant($user, PermissionsInterface::PERMISSION_CHANGE);
                        $entityOrganization = $hydrator->hydrate($data, $entityOrganizationFromDB);
                        $repositories->store($entityOrganization);
                        $entity->setOrganization($entityOrganization);
                    }
                    else {
                        $result['message'] = '';
                    }
                    $repositoriesJob->store($entity);
                } else {
                    $log->info('Jobs/manage/saveJob [error: ' . $form->getMessages() . ']:' . var_export($p, True));
                    $result['valid Error'] = $form->getMessages();
                }
            }
        } else {
            $log->info('Jobs/manage/saveJob [error: session lost]:' . var_export($p, True));
            $result['message'] = 'session_id is lost';
        }
        //$services->get('Core/Log')->info('Jobs/manage/saveJob result:' . PHP_EOL . var_export($p, True));
        return new JsonModel($result);
    }

}

