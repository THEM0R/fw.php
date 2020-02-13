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
Router::get('(get:get)', 'Main','main');
