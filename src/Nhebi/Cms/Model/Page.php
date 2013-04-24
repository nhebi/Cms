<?php

namespace Cms\Model;

use Cms\Entity\Page as PageEntity;
use Cms\Model\AbstractModel;
use Zend\Debug\Debug;

/**
 * Class Page
 *
 * This model should present a nice API to the controllers and other models.
 * The fact that Doctrine is used for persistence should be seen as an
 * implementation detail. Other classes shouldn't know or care about that.
 *
 * @package Cms\Model
 */
class Page extends AbstractModel
{
    protected $entity = 'Cms\Entity\Page';

    public function findOneByRoute($route)
    {
        return $this->getRepository()->findOneBy(array('route' => $route));
    }

    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Find all pages, ordered by title
     */
    public function findAll()
    {
        return $this->getRepository()->findBy(array(), array('title' => 'ASC'));
    }

    public function getPublishedRoutes()
    {
        $routes = array();
        foreach ($this->findAllByStatus('published') as $page) {
            $routes[] = $page->getRoute();
        }

        return $routes;
    }

    public function findAllByStatus($status = 'published')
    {
        return $this->getRepository()->findBy(array('status' => $status));
    }

    public function save(PageEntity $page)
    {
        $now = new \DateTime('now');

        // Created
        if (!$page->getCreated()) {
            $page->setCreated($now);
        }

        // The updated datetime
        $page->setUpdated($now);

        $this->getEntityManager()->persist($page);
        $this->getEntityManager()->flush();
    }

    public function delete(PageEntity $page)
    {
        $this->getEntityManager()->remove($page);
        $this->getEntityManager()->flush();
    }
}
