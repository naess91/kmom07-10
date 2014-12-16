<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
    
    'wrapper' => 'nav',//nav is default, i.e. this line is not needed
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'me'  => [
            'text'  => 'Me',   
            'url'   => '',  
            'title' => 'Min me-sida'
        ],

 
        // This is a menu item
        
        'report' => [
            'text'  =>'Redovisning', 
            'url'   =>'report',  
            'title' => 'Redovisning'
        ],
        
		  'calendar' => [
            'text'  =>'Kalender', 
            'url'   =>'calendar',  
            'title' => 'Kalender'
        ],
        
        // This is a menu item 
                'exempel'  => [
            'text'  => 'Theme',
            'url'   => 'exempel',
            'title' => 'Exempel',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'regioner'  => [
                        'text'  => 'Regioner',
                        'url'   => $this->di->get('url')->createRelative('regioner'),
                        'title' => 'Regioner'
                    ],

                    // This is a menu item of the submenu
                    'font-awesome'  => [
                        'text'  => 'Font-Awesome',
                        'url'   => $this->di->get('url')->asset('font-awesome'),
                        'title' => 'Font-Awesome'
                        
                    ],

                       // This is a menu item of the submenu
                    'Exempel'  => [
                        'text'  => 'Exempel',
                        'url'   => $this->di->get('url')->asset('exempel'),
                        'title' => 'Exempel'
                        
                    ],

                    // This is a menu item of the submenu
                    'typografi'  => [
                        'text'  => 'Typografi',
                        'url'   => $this->di->get('url')->asset('typography'),
                        'title' => 'Url to asset relative to frontcontroller',
                    ],
                ],
            ],
        ],

        // This is a menu item 
                'list'  => [
            'text'  => 'Användare',
            'url'   => 'users/list',
            'title' => 'Lista alla användare',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [
					 // This is a menu item of the submenu
                    'samtliga'  => [
                        'text'  => 'Samtliga',
                        'url'   => 'users/list',
                        'title' => 'Samtliga användare'
                    ],

					
                    // This is a menu item of the submenu
                    'active'  => [
                        'text'  => 'Aktiva',
                        'url'   => 'users/active',
                        'title' => 'Aktiva användare'
                    ],

                    // This is a menu item of the submenu
                    'inactive'  => [
                        'text'  => 'Inaktiva',
                        'url'   => 'users/inactive',
                        'title' => 'Inaktiva användare'
                        
                    ],

                       // This is a menu item of the submenu
                    'trashcan'  => [
                        'text'  => 'Papperskorg',
                        'url'   => 'users/trashcan',
                        'title' => 'Papperskorgen'
                        
                    ],

                    // This is a menu item of the submenu
                    'add'  => [
                        'text'  => 'Lägg till',
                        'url'   => 'users/add',
                        'title' => 'Lägg till',
                    ],

                     'setup'  => [
                        'text'  => 'Nollställ',
                        'url'   => 'users',
                        'title' => 'Nollställ',
                    ],
                ],
            ],
        ],
 		
		 'flash' => [
            'text'  =>'CFlash', 
            'url'   =>'flash',  
            'title' => 'CFlash'
        ],
   
        'source' => [
            'text'  =>'Källkod', 
            'url'   =>'source',  
            'title' => 'Källkod'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];