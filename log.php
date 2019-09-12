<?php 

/**
*	writeLog
* 	Log format : [ DATE - IP - USER_ID - MESSAGE ]
*/
function writeLog($str)
{	
	if(!WRITE_LOG)
		return;

	if(date_default_timezone_get()!=TIMEZONE)
        date_default_timezone_set(TIMEZONE);
    $arch = fopen(LOGS,"a+");
    $us = isset($_SESSION['user']) ? $_SESSION['user'] : 'GUEST' ;
    $us = is_array($us)? $us['username'] : $us;
	fwrite($arch, "[".date(DATE_RFC2822)." - ".(isset($_SERVER["REMOTE_ADDR"])? $_SERVER['REMOTE_ADDR'] : "").' - '.$us.' - '.$str."]\n");
	fclose($arch); 
}

?>