<?php

class Auth
{
    public static function isLoggedIn(){
		Session::init();
        return isset($_SESSION['user']);		
	}   
}

?>