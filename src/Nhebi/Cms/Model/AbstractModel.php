<?php

namespace Cms\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractModel
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    protected $repository;


    /**
     * Set the entity manager
     *
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get the entity manager
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Inject the repository
     *
     * @param EntityRepository $repository
     */
    public function setRepository(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the repository for the entity name in $this->entity
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        if (null === $this->repository) {
            $this->repository = $this->getEntityManager()->getRepository($this->entity);
        }

        return $this->repository;
    }
}
