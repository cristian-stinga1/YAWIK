<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

/** ActionController of Core */
namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Settings\Repository\Settings as SettingsRepository;
//use Settings\Repository\Settings;

/**
 * The Content Controller contains actions for handling static content.
 *
 */
class ContentController extends AbstractActionController
{
    public function indexAction()
    {
        $view = $this->params('view');
        $view = 'content/' . $view;

        $viewModel = new ViewModel();
        $viewModel->setTemplate($view);
        if ($this->request->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }
        return $viewModel;
    }



    /**
     * displays the content of a modal box. This is used e.g. when opening
     * the privacy policies or the terms and conditions in a modal box
     *
     * @example:
     *                 'route' => 'lang/multipost',
     *                          'params' => array(
     *                          'view' => 'jobs-publish-on-yawik'
     *                         )
     *
     */
    public function modalAction()
    {
        $view = $this->params('view');

        $viewModel = new ViewModel();
        $viewModel->setTemplate($view);
        if ($this->request->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        return $viewModel;
    }
}
