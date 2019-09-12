<?php

require_once("controller/ApiController.php");
require_once("models/Session.php");
require_once("models/Auth.php");
require_once("models/User.php");

class UserController extends ApiController{

	protected $user;

	function __construct(){
		Session::init();
		$file = file_get_contents(USER_DATA);
		$this->user = new User(json_decode($file));
	}

	public function getUser(){
		return $this->user;
	}

	public function get($params){
		$response = array("success" => false,"response" => array());
		if(Auth::isLoggedIn()){
			$response["success"] 	= true;
			$response["response"] 	= $this->user->toArray(true);
		}
		return $this->response($response);
	}


	public function login($params){
		$response = array("success" => null,"response" => array());
		if(Auth::isLoggedIn()){
			$response["success"] 	= true;
			$response["response"] 	= $this->user->toArray(true);
		}

		if(isset($params["username"]) && isset($params["password"])){
			if($this->user->login($params["username"],$params["password"])){
				$response["success"] 	= true;
				$response["response"] 	= $this->user->toArray(true);
			}else{
				$response["success"] 	= false;
			}
		}else{
			$response["success"] 	= false;
		}
		return $this->response($response);
	}

	public function logout(){
		$this->user->logout();
		return $this->response(array("success" => true,"response" => array()));
	}

	public function update($params){
		if(!Auth::isLoggedIn())
			return $this->response($this->notLoggedInMessage());

		foreach ($this->user->getEditableFieldList() as $fieldname) {
			if(isset($params[$fieldname])){
				$setter = "set".ucfirst($fieldname);
				if(method_exists($this->user,$setter)){
					$this->user->$setter($params[$fieldname]);
				}
			}
		}
		$this->save();
		return $this->response(array("success" => true,"response" => $this->user->toArray(true)));
	}

	private function save(){
		$f = fopen(USER_DATA, "w+");
		fwrite($f, json_encode($this->user->toArray()));
		fclose($f);
	}

	private function notLoggedInMessage(){
		return array(
			"success" => false,
			"response" => array(
				"message" => "Not logged in")
		);
	}


	public function index(){
		if(!Auth::isLoggedIn()){
			$this->redirectLogin();
		}else{
			$this->redirectHome();
		}
	}

	
	public function imageOptions(){
		if(!Auth::isLoggedIn())
			return $this->response($this->notLoggedInMessage());

		return $this->response(array("success" => true,"response" => $this->user->getImageOptions()));

	}

	public function redirectLogin(){
		header("Location: login.html");
	}

	public function redirectHome(){
		header("Location: home.html");
	}
}

?>