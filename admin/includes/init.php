<?php
//initialize

// DIRECTORY_SEPARATOR make separator for windows \ and for mac / 
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

//define site root path 
define('SITE_ROOT', 'F:' . DS . 'xampp' . DS . 'htdocs' . DS . 'gallary');
//define includes path
defined('INCLUDE_PATH') ? null : define('INCLUDE_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');

require_once(INCLUDE_PATH . DS . "functions.php");
require_once(INCLUDE_PATH . DS . "database.php");
require_once(INCLUDE_PATH . DS . "db_object.php");
require_once(INCLUDE_PATH . DS . "user.php");
require_once(INCLUDE_PATH . DS . "photo.php");
require_once(INCLUDE_PATH . DS . "comment.php");
require_once(INCLUDE_PATH . DS . "session.php");
require_once(INCLUDE_PATH . DS . "paginate.php");
