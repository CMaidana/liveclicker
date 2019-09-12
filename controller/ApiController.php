<?php


class ApiController{
	
	protected $ctrlName;
	protected $ctrl;
	protected $action;
	protected $args;

	protected $responseFormat = "json";

	function __construct(){

	}

	/**
	*	parse
	*	Process the $_GET param to redirect to any api function 	
	*	{endpoint}/{function}/{function params}
	* 	@return Bool 	true 	if the parameters are enough and controller was loaded
	*					false  	in the opposite case
	*/
	function parse(){
		writeLog(__METHOD__." ".json_encode($_GET)." ".file_get_contents('php://input'));
		if(isset($_GET['url'])){
			$params = explode("/", $_GET['url']);

			if(count($params) >= 2){
				$this->ctrlName 	= array_shift($params);
				$this->action 		= array_shift($params);
				//$this->args 		= $params;
				$this->args 		= $this->parsePost();
				if($this->loadController()){
					return true;
				}else{
					return false;
				}
			}else{
				$this->ctrlName 	= "user";
				$this->action 		= "index";
				$this->args  		= array();
				$this->loadController();
				//return false;
			}
		}else{
			$this->ctrlName 	= "user";
			$this->action 		= "index";
			$this->args  		= array();
			$this->loadController();
		}
	}

	/**
	*	loadController
	*	Loads controller from self param ctrlName
	*	@return Bool : 	true 	if controller exists
	*					false 	if controller not exists
	*/
	function loadController(){
		$controller = ucfirst($this->ctrlName)."Controller";
		$filename 	= CONTROLLER_FOLDER.SLASH.$controller.".php";
		if(!is_file($filename) ){
			return false;
		}
		require_once($filename);

		$this->ctrl = new $controller();
		return true; 
	}

	/**
	*	run 
	*	executes action in the loaded controller		
	*	@return Bool :  true if action was correctly executed
	*					false if any error occurs
	*/
	function run(){
		if(method_exists($this->ctrl, $this->action)){
			$action = $this->action;
			$ctrl 	= $this->ctrl;
			$ctrl->$action($this->args);
			return true;
		}else{
			return false;
		}
	}

	/**
	*	response
	*	Print response value to the specified format
	*	@param data 	(Array) Data to print
	*	@param format 	(String)(Optional) (JSON|CSV|LITERAL)	
	*/
	function response($data){
		// Only JSON implemented for the moment
		switch ($this->responseFormat) {	
			case 'json':
				echo json_encode($data);
				# code...
				break;
			case 'data':
				return $data;
		}
	}

	/**
	*	redirectError
	*	Redirects to error page 
	*/
	function redirectError(){		
		header("Location: ".BASE_PATH."/error.html");
	}

	/**
	*	parsePost
	*	@return Array : Post parameters
	*/
	public function parsePost(){
		$params = array();
		$post 	= json_decode(file_get_contents('php://input'),true);
		if(!$post) 
			return $params;
		foreach ($post as $key => $value) {
			$params[$key] = $value;
		}
		return $params;
	}

	public function setResponseFormat($responseFormat){
		$this->responseFormat = $responseFormat;
	}
}

?>