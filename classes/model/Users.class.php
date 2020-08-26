<?php

class Users {
	private static $instance;
	private $users;
	private $dbHandler;

	private function __construct(){}

	public static function getInstance(){
		if (!isset($instance)){
			self::$instance = new self;
		}
		return self::$instance;

	}
	public function login(){
		/* check login data
		 * db handler makes requests to database
		 * get feedback, handle redirect
		 */
		$username = Request::post('usernameInput');
		$password = Request::post('passwordInput');
		$rememberMe = Request::post('rememberMeInput');
		$this->dbHandler = DatabaseHandler::getDBInstance();

		if(empty($username) || empty($password)){
//			View::renderPage('index',['msg' => 'Fill in all the fields', 'username' => '']);
			return array('msg' => "Fill in all the fields", 'username' => $username);
		}

		if (empty($this->dbHandler->getUsername($username))){
			// User with give username not found
			return array('msg' => 'Username not found', 'username' => $username);
		}

		$hashedPass = hash("sha512", $password);
		$dbPass = $this->dbHandler->getPassword($username);

		if ($hashedPass != $dbPass){
			// Passwords doesn't match
			return array('msg' => 'Invalid password', 'username' => $username);
		}

		if ($rememberMe){
			Cookies::setCookies('username', $username);
			Cookies::setCookies('password', $password);
		}
		else{
			Cookies::deleteCookies('username');
			Cookies::deleteCookies('password');
		}
		// LOGIN SUCCESS, REDIRECT TO HOME PAGE

		$_SESSION['username'] = $username;
		$_SESSION['id_user'] = $this->dbHandler->getUserId($username);
//	$_SESSION['user_id'] = $dbHandler->getUserId($username);

		return NULL;
	}



	public function registerUser(){
		$this->dbHandler = DatabaseHandler::getDBInstance();
		$username = Request::post('usernameInput');
		$email = Request::post('emailInput');
		$password = Request::post('passwordInput');
		$passwordRepeat = Request::post('passwordRepeatInput');

		if (empty($username) || empty($password) || empty($passwordRepeat) || empty($email)){
			//$this->sendFeedback('Fill in all the fields');
			return array('msg' => 'Fill in all the fields', 'username' => $username, 'email' => $email);

		}

		if (!empty($this->dbHandler->getUsername($username))){
			// account with given username exists
			return array('msg' => 'Username already in use', 'email' => $email);
		}

		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			// invalid email adress
			return array('msg' => 'Invalid e-mail adress', 'username' => $username);

		}

		else if (!empty($this->dbHandler->getEmail($email))){
			// account with given email exists
			return array('msg' => 'E-mail already in use', 'username' => $username);
		}

		else if (!preg_match("/.{8,}/", $password)){
			// password must be at least 8 characters long
			return array('msg' => 'Password must contain more than 8 characters', 'username' => $username, 'email' => $email);
		}

		else if (!preg_match("/\d/", $password)){
			// password must contain at least one number
			return array('msg' => 'Password must contain numbers', 'username' => $username, 'email' => $email);
		}

		else if (!preg_match("/[a-z]/", $password)){
			// password must contain lower case
			return array('msg' => 'Password must contain lower case letters', 'username' => $username, 'email' => $email);
		}

		else if (!preg_match("/[A-Z]/", $password)){
			// password must contain upper case letters
			return array('msg' => 'Password must contain upper case letters', 'username' => $username, 'email' => $email);
		}

		else if ($password !== $passwordRepeat){
			// passwords dont match
			return array('msg' => "Password don\'t match", 'username' => $username, 'email' => $email);
		}

		else{
			$hashedPassword = hash("sha512", $password);
			$this->dbHandler->addUser($username, $email, $hashedPassword);
			return NULL;
		}

	}
}
