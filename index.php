<?php

error_reporting(E_ALL);

require_once("config.php");
require_once("log.php");
require_once(CONTROLLER_FOLDER.SLASH."ApiController.php");

$apiCtrl = new ApiController();

// Pase input parameters
if(!$apiCtrl->parse()){
	$apiCtrl->redirectError();
} 

if(!$apiCtrl->run()){
	$apiCtrl->redirectError();
} 


?>