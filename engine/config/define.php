<?php

// define


// dir

// dir
define('DIR',     dirname( dirname(__DIR__) ) );
define('FW',      DIR.'/engine');
define('ENGINE',  FW );
define('CORE',    FW.'core/' );
define('APP',     DIR.'/app' );
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

