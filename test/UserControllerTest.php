<?php
require_once("config.php");
require_once("log.php");
require_once("models/Session.php");
require_once("controller/ApiController.php");
require_once("controller/UserController.php");


class UserControllerTest{

	protected $ctrl;

	function __construct(){
		Session::init();
		$this->ctrl = new UserController();
		$this->ctrl->setResponseFormat("data");
	}
	public function testLogin(){
		$params = array(
			"username" => "admin",
			"password" => "liveclicker"
		); 
		$result = $this->ctrl->login($params);
		assert(is_array($result) && $result["success"]);
	}
	public function testLoginFail(){
		$result = $this->ctrl->login("admin","incorrectPassword");
		assert(is_array($result) && $result["success"] == false);
	}

	public function testLogout(){
		$result = $this->ctrl->logout();
		assert(is_array($result) && $result["success"] && !Auth::isLoggedIn());
	}

	public function testUpdate(){
		$params = array(
			"firstname" => "name_modified",
			"lastname"  => "test_modification"
 		);
		$result = $this->ctrl->update($params);
		assert(is_array($result) && $result["success"] && $result["response"]["firstname"] == $params["firstname"] && $result["response"]["lastname"] == $params["lastname"]);
	}

	public function restoreDefaultValues(){
		$params = array(
			"firstname" => "Christian",
			"lastname"  => "Maidana"
		);
		$result = $this->ctrl->update($params);
	}

	public function testGetImageOptions(){
		$result = $this->ctrl->imageOptions();
		assert(is_array($result) && $result["success"]);
	}

	public function testGetImageOptionsWhenNotLoggedIn(){
		$result = $this->ctrl->imageOptions();
		assert(is_array($result) && !$result["success"]);
	}

	public function testUpdateWhenNotLoggedIn(){
		$params = array(
			"firstname" => "name_modified",
			"lastname"  => "test_modification"
 		);
		$result = $this->ctrl->update($params);

		assert(is_array($result) && !$result["success"]);
	}

	public function methodToTest(){
		return array(
			"testGetImageOptionsWhenNotLoggedIn",
			"testUpdateWhenNotLoggedIn",
			"testLoginFail",
			"testLogin",
			"testUpdate",
			"restoreDefaultValues",
			"testGetImageOptions",
			"testLogout"
		);
	}
}

$testInstance = new UserControllerTest();
trace("UserController unit test begin...");
foreach ($testInstance->methodToTest() as $method) {
	trace("Testing method ".$method." ...");
	if(method_exists($testInstance, $method)){
		$testInstance->$method();
	}
}

trace("UserController unit test end...");

function trace($msg){
 	echo $msg.PHP_EOL;
}


?>