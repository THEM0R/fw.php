<?php
require_once __DIR__ . '/../engine/function.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../engine/routes.php';
require_once __DIR__ . '/../engine/config/define.php';

new \engine\Router();
engine\Router::Run();