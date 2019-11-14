<?php
use engine\Router;
/* view */
Router::add('(category:str)/(url:all)', 'view:index','view');
Router::add('(category:str)/(url:all)/(action:str)', 'View');

/* category */
Router::add('(category:str)', 'category','category');
Router::add('(category:str)/page/(page:int)', 'category');



/* index */
Router::get('', 'Main','main');
