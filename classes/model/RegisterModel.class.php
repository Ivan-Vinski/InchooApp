<?php

class RegisterModel{


	private static $instance;
	private $dbHandler;

	private function __construct(){}

	public static function getRegisterModelInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}


	public function register($username,$email, $password, $passwordRepeat){
		$this->dbHandler = DatabaseHandler::getDBInstance();
	
		if (empty($username) || empty($password) || empty($passwordRepeat) || empty($email)){
			return "Fill in all the fields";
		}

		if (!empty($this->dbHandler->getUsername($username))){
			// account with given username exists
			return "Username already in use";
		}

		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			// invalid email adress
			return "Invalid e-mail adress";

		}

		else if (!empty($this->dbHandler->getEmail($email))){
			// account with given email exists
			return "E-mail already in use";
		}

		else if (!preg_match("/.{8,}/", $password)){
			// password must be at least 8 characters long
			return "Password must contain at least 8 characters";
		}

		else if (!preg_match("/\d/", $password)){
			// password must contain at least one number
			return "Password must contain at least one number";
		}

		else if (!preg_match("/[a-z]/", $password)){
			// password must contain lower case
			return "Password must contain at least one lower case letter";
		}

		else if (!preg_match("/[A-Z]/", $password)){
			// password must contain upper case letters
			return "Password must contain at least one upper case letter";
		}

		else if ($password !== $passwordRepeat){
			// passwords dont match
			return "Passwords don\'t match";
		}

		else{
			$hashedPassword = hash("sha512", $password);
			$this->dbHandler->addUser($username, $email, $hashedPassword);	
			Header("Location:home");
		}
	
	}

}
?>
