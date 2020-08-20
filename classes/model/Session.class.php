<?php

class Session{
	private function __construct(){}
	public static function start(){
		session_start();
	}

	public static function logout(){
		session_start();
		session_unset();
		session_destroy();
	}

	public static function isLoggedIn(){
		if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
			return false;
		}	
		else return true;
	}

	public static function getLoggedInUsername(){
		return $_SESSION['username'];	
	}

}
