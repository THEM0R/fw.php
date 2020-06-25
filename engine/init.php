<?php

// autoload
require_once __DIR__ . '/../vendor/autoload.php';
// ini
ini_set('date.timezone', 'Europe/Kiev');
ini_set('display_errors', 'on');
ini_set('serialize_precision', 'on');
// init
error_reporting(-1);
session_start();

// define
define('RELEASE',0);
require_once __DIR__ . '/config/define.php';
require_once __DIR__ . '/config/ini/language.php';

// Debug
// https://packagist.org/packages/symfony/debug
use Symfony\Component\Debug\Debug;
Debug::enable();
// Debug




