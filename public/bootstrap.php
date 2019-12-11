<?php

// ini
ini_set( 'date.timezone', 'Europe/Kiev' );
ini_set('display_errors','on');
ini_set('serialize_precision','on');
error_reporting(-1 );
session_start();
// define
define('REQUEST', 'http');

define('URI',rtrim($_SERVER['QUERY_STRING'], '/'));
define('DOMEN', REQUEST.'://' . $_SERVER['HTTP_HOST']);

define('THEME', 'default');

define('LANGUAGES', [
    1 => 'ua',
    2 => 'ru'
]);

define('LANGUAGE', LANGUAGES[2]);





//echo URI;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../engine/function.php';
require_once __DIR__ . '/../engine/routes.php';

engine\Router::Run(URI);