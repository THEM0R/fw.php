<?php
// define
define('RELEASE', 0);
// dir
define('WWW_DIR', dirname(__DIR__));
// APP
define('APP_DIR', WWW_DIR . '/app');
define('ADMIN_DIR', APP_DIR . '/admin');
define('BASE_DIR', APP_DIR . '/base');
// ENGINE
define('ENGINE_DIR', WWW_DIR . '/engine');
// PUBLIC
define('PUBLIC_DIR', WWW_DIR . '/public');
// VENDOR
define('VENDOR_DIR', WWW_DIR . '/vendor');
// dump
require_once __DIR__ . '/dump.php';
// autoload
require_once VENDOR_DIR . '/autoload.php';
// ini
ini_set('date.timezone', 'Europe/Kiev');
ini_set('display_errors', 'on');
ini_set('serialize_precision', 'on');
// init
error_reporting(-1);
session_start();


pr1(APP_DIR);


require_once __DIR__ . '/config/define.php';
require_once __DIR__ . '/config/ini/language.php';

// Debug
// https://packagist.org/packages/symfony/debug
use Symfony\Component\Debug\Debug;

Debug::enable();
// Debug




