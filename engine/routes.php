<?php
use engine\Router;

Router::post('(post:all)/(url:all)', 'Main:test');

/* view */
Router::get('(category:str)/(url:all)', 'view:index','view');
Router::get('(category:str)/(url:all)/(action:str)', 'View');

/* category */
Router::get('(category:str)', 'category','category');
Router::get('(category:str)/page/(page:int)', 'category');



/* index */
Router::get('', 'Main','main');
