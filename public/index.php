<?php
require_once __DIR__ . '/../engine/function.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../engine/routes.php';
require_once __DIR__ . '/../engine/config/define.php';

//pr1($_SERVER);
//pr3($_SERVER['QUERY_STRING']);
//
//pr3(engine\Router::getUrl());


engine\Router::Run();


//$url = trim($_SERVER['REQUEST_URI'], '/');
//
//echo $url;
//
//if (preg_match($pattern, $url, $matches)) {
//
//}

