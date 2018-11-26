<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Movies\Controller\Movies' => 'Movies\Controller\MoviesController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'movies' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/movies[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Movies\Controller\Movies',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'movies' => __DIR__ . '/../view',
        ),
    ),
  );
