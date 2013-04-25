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
    }

    public function getConfig()
    {
        $config = include __DIR__ . '/config/module.config.php';

        // Get the cms page routes from a cache file
        if (!empty($config['routeCacheFile'])
            && file_exists($config['routeCacheFile'])) {
            $cachedRoutes = file_get_contents($config['routeCacheFile']);

            $config['router']['routes']['cmsPage']['options']
                ['constraints']['pageRoute'] = $cachedRoutes;
        }

        return $config;
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
                'service.routeCache' => function ($sm) {
                    $routeCacheService = new \Cms\Service\RouteCache;

                    // Inject the page model
                    $pageModel = $sm->get('model.page');
                    $routeCacheService->setPageModel($pageModel);

                    // Grab the cache file from the config and pass it in
                    $config = $sm->get('Config');
                    if (!empty($config['routeCacheFile'])) {
                        $routeCacheService->setCacheFile($config['routeCacheFile']);
                    }

                    return $routeCacheService;
                },
            ),
        );
    }
}
