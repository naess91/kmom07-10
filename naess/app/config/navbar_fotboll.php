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
        'home'  => [
            'text'  => 'Hem',   
            'url'   => '',  
            'title' => 'Hem'
        ],

 
        // This is a menu item
        
        'questions' => [
            'text'  =>'Frågor', 
            'url'   =>'questions',  
            'title' => 'Frågor'
        ],
        
		  'tags' => [
            'text'  =>'Taggar', 
            'url'   =>'tags',  
            'title' => 'Taggar'
        ],
        
       
        // This is a menu item 
                'users'  => [
            'text'  => 'Användare',
            'url'   => 'users/list',
            'title' => 'Lista alla användare',

       
           

        
        ],
 
   
        'add' => [
            'text'  =>'Ställ fråga', 
            'url'   =>'questions/add',  
            'title' => 'Ställ fråga',
			'class' => 'addquestion',
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