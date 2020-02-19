<?php
use engine\Router;

$Router = new Router();

//Router->post('(post:all)/(old:all)', 'Main:test');



/* category */
$Router->get('(category:str)', 'category',false,'category');
$Router->get('(category:all)/(page:int)', 'category', false,'category_page');

/* view */
$Router->get('(category:all)/(url:str)', 'main:view');
$Router->get('(category:all)/(url:all)/(cn:str)', 'main:views');


//$Router->get('request/(url:get)', 'request')->name('request');

$Router->get('request/(url:get)', 'request', function (){
    return 'sadad';
});




//Router->get("?([a-zA-Z0-9-_=?%&]*)", 'Main','main');
$Router->get('', 'Main','main')->name('home');
//$Router->post('(url:get)/ar', 'Main','main')->name('home');


/* index */
//Router->get('(url:all)', 'Main:get','main');
//Router->get('?(get:get)?', 'Main','main');
//Router->get('', 'Main','main');



//pr4(Router->getRoutes());


//
//Router->get('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', 'Main','main');
//Router->get('^(?<controller>[a-z-]+)/?(?<action>[a-z-]+)?$', 'Main','main');
//Router->get('^film/(?P<url>[a-z-]+)$', 'Main','main');
//Router->get('^film/(?P<url>[a-z-]+)/online$', 'Main','main');
