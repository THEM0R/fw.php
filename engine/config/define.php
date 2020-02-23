<?php

// define
define('REQUEST', 'http');
define('URI', rtrim($_SERVER['QUERY_STRING'], '/'));
define('DOMEN', REQUEST . '://' . $_SERVER['HTTP_HOST']);
define('THEME', 'default');

// dir

// dir
define('DIR',     dirname( dirname(__DIR__) ) );
define('FW',      DIR.'/engine');
define('ENGINE',  FW );
define('CORE',    FW.'core/' );
define('APP',     dirname(DIR).'/app' );
define('ADMIN',   ENGINE.'/admin' );
define('LIB',     FW.'/libs/' );
define('CONF',    FW.'/config/' );
define('CONF_DB', FW.'/config/db/' );
define('UPLOAD',  FW.'/upload/' );
define('CONTENT', dirname(DIR).'/public/' );
define('SCRIPT',  '/public/script/' );
define('SCRIPT_LIB',  '/public/script/libs/' );
define('SCRIPT_JS',  '/public/script/js' );
define('VENDOR',  DIR.'/' );

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
