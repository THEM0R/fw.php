<?php

define('URI',$_SERVER['REQUEST_URI']);

//echo URI;

require_once __DIR__ . '/../vendor/autoload.php';

use engine\Router;

Router::run();