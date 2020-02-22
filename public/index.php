<?php
require_once __DIR__ . '/../engine/function.php';
// function
require_once __DIR__ . '/../vendor/autoload.php';
// init
require_once __DIR__ . '/../engine/init.php';

require_once __DIR__ . '/../engine/config/define.php';

// Debug
// https://packagist.org/packages/symfony/debug
use Symfony\Component\Debug\Debug;
Debug::enable();
// Debug

$Router = new \engine\Router();
require_once __DIR__ . '/../engine/routes.php';
$Router->Run();