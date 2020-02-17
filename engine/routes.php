<?php
use engine\Router;

Router::post('(post:all)/(old:all)', 'Main:test');

Router::get('request/(url:get)', 'request');

/* view */
Router::get('(category:all)/(url:all)', 'view:index','view');
Router::get('(category:all)/(url:all)/(action:str)', 'View');

/* category */
Router::get('(category:all)', 'category','category');
Router::get('(category:all)/page/(page:int)', 'category');



/* index */
//Router::get('(get:get)', 'Main:get','main');
//Router::get('?(get:get)?', 'Main','main');
Router::get('', 'Main','main');


//
//Router::get('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', 'Main','main');
//Router::get('^(?<controller>[a-z-]+)/?(?<action>[a-z-]+)?$', 'Main','main');
//Router::get('^film/(?P<url>[a-z-]+)$', 'Main','main');
//Router::get('^film/(?P<url>[a-z-]+)/online$', 'Main','main');
