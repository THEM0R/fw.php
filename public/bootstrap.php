<?php

define('URI',$_SERVER['REQUEST_URI']);

//echo URI;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../engine/function.php';

engine\Router::Run(URI);