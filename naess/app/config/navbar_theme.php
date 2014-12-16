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
            'url'   => 'index.php',  
            'title' => 'Min me-sida'
        ],


         'exempel'  => [
            'text'  => 'Exempel',   
            'url'   => 'theme.php',  
            'title' => 'Exempel'
        ],

 
        
        
		  'typography' => [
            'text'  =>'Typografi', 
            'url'   =>'theme.php/typography',  
            'title' => 'Typografi'
        ],
        
        // This is a menu item 
        'regioner'  => [ 
            'text'  => 'Regioner',    
            'url'   => 'theme.php/regioner',   
            'title' => 'Regioner' 
        ],
   
        'font-awesome' => [
            'text'  =>'Font-awesome', 
            'url'   =>'theme.php/font-awesome',  
            'title' => 'Font-awesome'
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