<?php
use engine\Router;

Router::post('(post:all)/(old:all)(url:all)', 'Main:test');

Router::get('request/(url:get)', 'request');

/* view */
Router::get('(category:str)/(url:all)', 'view:index','view');
Router::get('(category:str)/(url:all)/(action:str)', 'View');

/* category */
Router::get('(category:str)', 'category','category');
Router::get('(category:str)/page/(page:int)', 'category');



/* index */
//Router::get('(get:get)', 'Main:get','main');
//Router::get('?(get:get)?', 'Main','main');
Router::get('', 'Main','main');
