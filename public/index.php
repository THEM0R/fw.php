<?php
require_once __DIR__ . '/../engine/function.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../engine/routes.php';
require_once __DIR__ . '/../engine/config/define.php';



$app = new \engine\Test();

$app->test1()
    ->test2()
    ->test3();

exit;
$Router = new \engine\Router();
$Router->Run();