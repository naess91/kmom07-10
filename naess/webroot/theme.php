<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->addStylesheet('css/comment.css'); 

$app->router->add('', function() use ($app) {
    
  
    $app->theme->setTitle('Exempel');
     $app->theme->addStyleSheet('css/naess-grid/wrap-footer.css');
    $content = $app->fileContent->get('main-ex.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $sidebar = $app->fileContent->get('sidebar-ex.html'); 
    $triptych1 = $app->fileContent->get('triptych-ex.md');
    $triptych1 = $app->textFilter->doFilter($triptych1, 'shortcode, markdown');
    $triptych2 = $app->fileContent->get('triptych-ex.md');
    $triptych2 = $app->textFilter->doFilter($triptych1, 'shortcode, markdown');
    $triptych3 = $app->fileContent->get('triptych-ex.md');
    $triptych3 = $app->textFilter->doFilter($triptych1, 'shortcode, markdown');
    $footercol4 = $app->fileContent->get('font-ex.html');
    $footercol3 = $app->fileContent->get('footercol-ex.html');
    
    $app->views->addString('', 'flash') 
                        ->addString('<img src="img/Bob_belcher.png" alt="Bob" width = "200" height = "330">', 'featured-1')
                        ->addString('<img src="img/Hank_Hill.png" alt="Hank" width = "200" height = "330">', 'featured-2')
                        ->addString('<img src="img/Peter_Griffin.png" alt="Peter" width = "200" height = "330">', 'featured-3')
                        ->addString($content, 'main')
                        ->addString($sidebar, 'sidebar')
                        ->addString($triptych1, 'triptych-1')
                        ->addString($triptych2, 'triptych-2')
                        ->addString($triptych3, 'triptych-3')
                        ->addString('<h2>Rubrik</h2><p>Lorem ipsum</p>', 'footer-col-1')
                        ->addString('<h2>Rubrik</h2><p>Lorem ipsum </p>', 'footer-col-2')
                        ->addString($footercol3, 'footer-col-3')
                        ->addString($footercol4, 'footer-col-4');
    
}); 

// Using this when not specifying a file  
$app->router->add('regioner', function() use ($app) {  

    $app->theme->setTitle("Regioner");  
    $app->theme->addStyleSheet('css/naess-grid/regioner.css'); 
    $app->views->addString('flash', 'flash')  
               ->addString('featured-1', 'featured-1')  
               ->addString('featured-2', 'featured-2')  
               ->addString('featured-3', 'featured-3')  
               ->addString('main', 'main')  
               ->addString('sidebar', 'sidebar')  
               ->addString('triptych-1', 'triptych-1')  
               ->addString('triptych-2', 'triptych-2')  
               ->addString('triptych-3', 'triptych-3')  
               ->addString('footer-col-1', 'footer-col-1')  
               ->addString('footer-col-2', 'footer-col-2')  
               ->addString('footer-col-3', 'footer-col-3')  
               ->addString('footer-col-4', 'footer-col-4');  
});  

$app->router->add('typography', function() use ($app) {  

    $app->theme->setTitle("Typografi");  

    $content = $app->fileContent->get('typography.html');  

    $app->views->add('grid/simple_page',   
            ['content' => $content]);   

    $app->views->add('grid/sidebar',   
            ['content' => $content],  
            'sidebar');   

});  

$app->router->add('font-awesome', function() use ($app) {  

    $app->theme->setTitle("Font awesome");  

    $main = $app->fileContent->get('font_awesome_main.html');  
    $sidebar = $app->fileContent->get('font_awesome_sidebar.html');  

    $app->views->add('grid/simple_page',   
            ['content' => $main]);   

    $app->views->add('grid/sidebar',   
            ['content' => $sidebar],  
            'sidebar');   

});  

 
// Render the response using theme engine.
$app->router->handle();  
$app->theme->render();  

?>

