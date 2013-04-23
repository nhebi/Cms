<?php

namespace Cms;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(
            MvcEvent::EVENT_DISPATCH_ERROR,
            array($this, 'onDispatchError'),
            100
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/Nhebi/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'abstract_factories' => array(),
            'aliases' => array(),
            'invokables' => array(),
            'services' => array(),
            'factories' => array(
                'model.page' => function ($sm) {
                    $pageModel = new \Cms\Model\Page;
                    $em = $sm->get('doctrine.entitymanager.orm_default');

                    $pageModel->setEntityManager($em);

                    return $pageModel;
                },
            ),
        );
    }

    /**
     * When all other routes fail, attempt to match it to a page
     *
     * @param MvcEvent $event
     */
    public function onDispatchError(MvcEvent $event)
    {
        $event->setControllerClass('\Cms\Controller\PageController');

        //var_dump($event);die;
    }
}
