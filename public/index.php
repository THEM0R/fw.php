<?php
// init
require_once __DIR__ . '/../engine/init.php';


$Router = new core\Router();
require_once __DIR__ . '/../engine/routes.php';
$Router->Run();