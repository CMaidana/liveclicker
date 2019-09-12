<?php

define("TIMEZONE","America/Montevideo");
define("SLASH",DIRECTORY_SEPARATOR);

define("BASE_PATH",$_SERVER['DOCUMENT_ROOT']? $_SERVER['DOCUMENT_ROOT'].SLASH.'liveclicker' : 'C:/xampp/htdocs/liveclicker');


define("CONTROLLER_FOLDER","controller");
define("CONTROLLER_SUFIX","Controller");

define("WRITE_LOG",true);
define('LOG_FOLDER','logs');
define("LOGS",LOG_FOLDER.SLASH."log.log");
// 

define("USER_DATA","db/user.json");

?>