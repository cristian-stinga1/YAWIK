<?php
/**
 * YAWIK
 *
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   GPLv3
 */

namespace Organizations\Repository;

use Core\Repository\AbstractRepository;

class Organization extends AbstractRepository
{
    /**
     * Gets a cursor to a set of organizations
     * 
     * @param array $params
     */
    public function getPaginatorCursor($params)
    {
        return $this->getPaginationQueryBuilder($params)
                    ->getQuery()
                    ->execute();
    }

    /**
     * Gets a query builder to search for organizations
     *
     * @param array $params
     * @return mixed
     */
    protected function getPaginationQueryBuilder($params)
    {
        $filter = $this->getService('filterManager')->get('Organizations/PaginationQuery');
        $qb = $filter->filter($params, $this->createQueryBuilder());
        
        return $qb;
    }
    
    /**
     * Find a organizations by an name
     * 
     * @param String $name
     * @param boolean $create
     * @return array
     */
    public function findByName($name, $create = true) {
        $query = $this->dm->createQueryBuilder('Organizations\Entity\OrganizationName')->hydrate(false)->field('name')->equals($name)->select("_id");
        $result = $query->getQuery()->execute()->toArray(false);
        if (empty($result) && $create) {
            $repositoryNames = $this->dm->getRepository('Organizations\Entity\OrganizationName');
            $entityName = $repositoryNames->create();
            $entityName->setName($name);
            $entity = $this->create();
            $entity->setOrganizationName($entityName);
            $this->store($entity);
            $organizations = array($entity);
        }
        else {
            $idName = $result[0]['_id'];
            $organizations = $this->findBy(array('organizationName' => $idName));
        }
        return $organizations;
    }
    
    public function findbyRef($ref, $create = true) {
        $entity = $this->findOneBy(array('externalId' => $ref));
        if (empty($entity)) {
            $entity = $this->create();
            $entity->setExternalId($ref);
        }
        return $entity;
    }

    public function create(array $data=null) {
        $entity = parent::create($data);
        $entity->isDraft(True);
        return $entity;
    }

    /**
     * @param string $query
     * @param int    $userId
     * @return array
     */
    public function getTypeAheadResults($query, $userId)
    {
        $organizationNames = array();

        $organizationNameQb = $this->getDocumentManager()->createQueryBuilder('Organizations\Entity\OrganizationName');
        $organizationNameQb->hydrate(false)
            ->select(array('id', 'name'))
            ->field('name')->equals(new \MongoRegex('/' . $query . '/i'))
            ->sort('name')
            ->limit(5);

        $organizationNameResults = $organizationNameQb->getQuery()->execute();

        foreach($organizationNameResults as $id => $item) {
            $organizationNames[$id] = $item;
        }

        $organizations = array();

        $qb = $this->createQueryBuilder();
        $qb->hydrate(false)
            ->select(array('contact.city', 'contact.street', 'contact.houseNumber', 'organizationName'))
            ->field('permissions.view')->equals($userId)
            ->field('organizationName')->in(array_keys($organizationNames))
            ->limit(5);

        $result = $qb->getQuery()->execute();

        foreach($result as $id => $item) {
            $organizations[$id] = $item;
            $organizationNameId = (string)$organizations[$id]['organizationName'];
            $organizations[$id]['organizationName'] = $organizationNames[$organizationNameId];
        }

        return $organizations;
    }
}