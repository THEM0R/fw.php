<?php

// ini
ini_set('date.timezone', 'Europe/Kiev');
ini_set('display_errors', 'on');
ini_set('serialize_precision', 'on');
error_reporting(-1);
session_start();
// define
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


//pr($_SERVER['HTTP_ACCEPT_LANGUAGE']);


if (isset($_SERVER['HTTP_REFERER'])) {
  define('HTTP_REFERER', $_SERVER['HTTP_REFERER']);
} else {
  define('HTTP_REFERER', 0);
}

define('HTTP_ACCEPT_LANGUAGE', $_SERVER['HTTP_ACCEPT_LANGUAGE']);