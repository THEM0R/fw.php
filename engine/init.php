<?php
// ini
ini_set('date.timezone', 'Europe/Kiev');
ini_set('display_errors', 'on');
ini_set('serialize_precision', 'on');
// init
error_reporting(-1);
session_start();
// http
define('REQUEST', 'http');
define('URI', rtrim($_SERVER['QUERY_STRING'], '/'));
define('DOMEN', REQUEST . '://' . $_SERVER['HTTP_HOST']);
define('THEME', 'default');

// LANGUAGE
define('SL', 1); // SEVERAL_LANGUAGES -- РІЗНІ МОВИ
define('LANGUAGES', [
    1 => 'ua',
    2 => 'ru'
]);
if ($_SERVER) {
  if ($_SERVER['HTTP_ACCEPT_LANGUAGE']) {
    $HAL = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if ($HAL === 'uk') {
      define('LANGUAGE', LANGUAGES[1]);
    } else {
      define('LANGUAGE', LANGUAGES[2]);
    }
  }
}
// LANGUAGE

//pr($_SERVER['HTTP_ACCEPT_LANGUAGE']);
if (isset($_SERVER['HTTP_REFERER'])) {
  define('HTTP_REFERER', $_SERVER['HTTP_REFERER']);
} else {
  define('HTTP_REFERER', 0);
}
define('HTTP_ACCEPT_LANGUAGE', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

// view
define('RELEASE', 0);
// directories
define('WWW_DIR', dirname(__DIR__));
// APP
define('APP_DIR', WWW_DIR . '/app');
define('ADMIN_DIR', APP_DIR . '/admin');
define('BASE_DIR', APP_DIR . '/base');
// ENGINE
define('ENGINE_DIR', WWW_DIR . '/engine');
define('MODULE_DIR', ENGINE_DIR . '/module');
define('ROUTER_DIR', ENGINE_DIR . '/router');
define('MVC_DIR', ENGINE_DIR . '/mvc');
// PUBLIC
define('PUBLIC_DIR', WWW_DIR . '/public');
// VENDOR
define('VENDOR_DIR', WWW_DIR . '/vendor');
// dump
require_once __DIR__ . '/dump.php';
// autoload
require_once VENDOR_DIR . '/autoload.php';

//require_once __DIR__ . '/config/ini/language.php';

// Debug
// https://packagist.org/packages/symfony/debug
use Symfony\Component\Debug\Debug;

Debug::enable();
// Debug

// twig
//Twig_Autolader::register();
//$loader = new Twig_Loader_Filesystem('templates');
// twig




