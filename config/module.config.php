<?php

namespace Cms;

return array(
    /*'router' => array(
        'routes' => array(
            'cmsPage' => array(
                'type' => 'segment',
                'priority' => 1,
                'options' => array(
                    'route' => '/:pageRoute',
                    'constraints' => array(
                        'pageRoute' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'pages',
                        'action' => 'view'
                    )
                )
            ),
        )
    ),*/
    'controllers' => array(
        'invokables' => array(
            'pages' => 'Cms\Controller\PageController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cms' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Nhebi/Cms/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Cms\Entity' => 'my_annotation_driver'
                )
            )
        ),
    ),
);
