<?php 


class User{
	
	protected $id;
	protected $username;
	protected $password;
	protected $firstname;
	protected $lastname;

	protected $imageOptions;

	function __construct($obj=NULL){
		if($obj)
			foreach ($obj as $key => $value) {
				if(property_exists(__CLASS__, $key))
					$this->$key = $value;
			}
	}
	function __destruct(){}
	
	
	public function toArray($api = false){
		$ret = array();
		foreach (get_object_vars($this) as $key => $value) {
			if(!$api || $key != "password")
				$ret [$key] = $value;
		}
		return $ret;
	}

	public function getId(){
		return $this->id;
	}

	public function getUsername(){
		return $this->username;
	}

	public function getPassword(){
		return $this->password;
	}

	public function getFirstname(){
		return $this->firstname;
	}

	public function getLastname(){
		return $this->lastname;
	}

	public function getImageOptions(){
		return $this->imageOptions;
	}

	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}
	public function setLastname($lastname){
		$this->lastname = $lastname;
	}
	public function setUsername($username){
		$this->username = $username;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setImageOptions($imageOptions){
		$this->imageOptions = $imageOptions;
	}


	public function getEditableFieldList(){
		return array("firstname","lastname","imageOptions");
	}


	/**
	* 	login
	*	As there will be only one user in the system the login function will return true to the correct combination of username and password
	*	@param username
	*	@param password 
	*	@return Bool true if login is correct and session loaded with current user
	*				 false if login is not correct
	*/
    public function login($username,$password){

    	$loginStatus = $username == $this->username && $this->_h($password) == $this->password;
    	
    	writeLog("Login attempt: ".$username.":".$this->_h($password));
        if (!$loginStatus) {
            writeLog('LOGIN FAILED');
            return false;
        }
        writeLog('LOGIN SUCCESSFULL');
        Session::init();        
        Session::set('user_log',true);
        Session::set('user',$this->toArray());
        return true;
    }


    /**
	*	logout
	*	Logout function, destruct current session
    */
    public function logout(){
    	writeLog(__METHOD__);
        Session::destroy();
    }

    /**
    *	_h
    *	Hash function for password
    */
    public function _h($password){
    	return hash('sha256',md5($password."livecliker"));
    }
}

?>