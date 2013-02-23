<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
            'Album\Controller\Song' => 'Album\Controller\SongController',
        ),
    ),
    
	

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
        
            'album' => array(
                'type'    => 'segment',
                'options' => array(
//                    'route'    => '/album[/:action][/:id]',
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'index',
                    ),
                ),
            ),
            
			
			
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'song' => array(
                'type'    => 'segment',
                'options' => array(
                    //'route'    => '/album/song',
                    'route'    => '/album/song[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),                    
                    'defaults' => array(
                        '__NAMESPACE__' => 'Album\Controller',
                        'controller'    => 'Song',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/album/song[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),	
			
			
			
			
			
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
       
    ),
    
	// added for Acl   ###################################
/*
	'controller_plugins' => array(
	    'invokables' => array(
//	       'Myplugin' => 'ZfCommons\Controller\Plugin\Myplugin',
	       'Myplugin' => 'Album\Controller\Plugin\Myplugin',
	     )
	 ),*/

	 
/*
	'controller_plugins' => array(
	    'invokables' => array(
//	       'Myplugin' => 'ZfCommons\Controller\Plugin\Myplugin',
	       'Myplugin' => 'Album\Controller\Plugin\Myplugin',
	     )
	 ),*/

	 
	// end: added for Acl   ###################################	
	
);
