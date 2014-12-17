<?php
require __DIR__.'/config_with_app.php'; 

$di  = new \Anax\DI\CDIFactoryDefault();
$di->set('form', '\Mos\HTMLForm\CForm');

 $di->set('CommentController', function() use ($di) {
        $controller = new \Anax\Comments\CommentController();
        $controller->setDI($di);
        return $controller;
    });

 $di->set('PostController', function() use ($di) {
        $controller = new \Anax\Post\PostController();
        $controller->setDI($di);
        return $controller;
    });

 $di->set('UsersController', function() use ($di) {
        $controller = new \Anax\Users\UsersController();
        $controller->setDI($di);
        return $controller;
    });

    $di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->set('QuestionsController', function() use ($di) {
    $controller = new Anax\Questions\QuestionsController();
    $controller->setDI($di);
    return $controller;
});









$app = new \Anax\Kernel\CAnax($di);

$app->theme->configure(ANAX_APP_PATH . 'config/fotboll-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_fotboll.php');
$app->headernav->configure(ANAX_APP_PATH . 'config/navbar.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


 
$app->router->add('', function() use ($app) {
	$app->theme->setTitle("Startsida");
	
	$content = $app->fileContent->get('me.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
			
			$app->dispatcher->forward([
	        'controller' => 'questions',
	        'action' => 'totalQuestions',
	   		 ]);
			
			
			$app->dispatcher->forward([
	        'controller' => 'questions',
	        'action' => 'latest',
	   		 ]);
			 
		
			$app->dispatcher->forward([
			        'controller' => 'questions',
			        'action' => 'mostused',
			    ]);
		
			$app->dispatcher->forward([
			        'controller' => 'questions',
			        'action' => 'activity',
			    ]);
			$app->dispatcher->forward([
			        'controller' => 'questions',
			        'action' => 'activeUsers',
			    ]);	
});
 


$app->router->add('questions', function() use ($app) {
	$app->theme->setTitle("Frågor");
	
	
	$app->dispatcher->forward([
	        'controller' => 'questions',
	        'action' => 'list',
	    ]);
});

$app->router->add('tags', function() use ($app) {
	$app->session();
 	$app->theme->setTitle("Tags");
	
	$app->dispatcher->forward([
	        'controller' => 'questions',
	        'action' => 'listTags',
	    ]);
	
});





$app->router->add('profile', function() use ($app) {
 	$app->theme->setTitle("Min profil");
	if($app->session->get('user')){
		$app->dispatcher->forward([
		        'controller' => 'users',
		        'action' => 'status',
		    ]);
	}
	else {
		$app->dispatcher->forward([
		        'controller' => 'users',
		        'action' => 'login',
		    ]);
	}
	
});

$app->router->add('about', function() use ($app) {
	$app->session();
 	$app->theme->setTitle("Om sidan");
	
	$content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('default/about', [
        'content' => $content, 
        'byline' => $byline,
    ]);
    
	
});

 
$app->router->add('source', function() use ($app) {
 
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Source");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
 
});

$app->router->add('users', function() use ($app) {
 
 

    
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list'
    ]);
    

});



 

$app->router->handle();
$app->theme->render();


?>