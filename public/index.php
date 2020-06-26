<?php
// init
require_once __DIR__ . '/../engine/init.php';
$Router = new router\Router();
require_once ADMIN_DIR . '/routes.php';

// functions
require_once MODULE_DIR . '/function.php';
require_once BASE_DIR . '/routes.php';

$Router->Run();