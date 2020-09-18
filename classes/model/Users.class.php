<?php

class Users {
	private static $instance;
	private $dbHandler;

	private function __construct(){
		$this->dbHandler = DatabaseHandler::getDBInstance();
	}

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
		$userMatch = $this->dbHandler->getUser($username);
		if(empty($username) || empty($password)){
			return array('msg' => "Fill in all the fields", 'username' => $username);
		}

		if (!$userMatch){
			// Username not found
			return array('msg' => 'Username not found', 'username' => $username);
		}

		if (hash("sha512", $password) != $userMatch[3]){
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
		$_SESSION['id_user'] = $userMatch[0];

		return NULL;
	}



	public function registerUser(){
		$username = Request::post('usernameInput');
		$email = Request::post('emailInput');
		$password = Request::post('passwordInput');
		$passwordRepeat = Request::post('passwordRepeatInput');
		$usernameMatch = $this->dbHandler->getUser($username);
		$emailMatch = $this->dbHandler->getUserByEmail($email);

		if (empty($username) || empty($password) || empty($passwordRepeat) || empty($email)){
			//$this->sendFeedback('Fill in all the fields');
			return array('msg' => 'Fill in all the fields', 'username' => $username, 'email' => $email);

		}

		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			// invalid email adress
			return array('msg' => 'Invalid e-mail adress', 'username' => $username);
		}

		else if ($usernameMatch){
			return array('msg' => 'Username already in use', 'email' => $email);	
		}

		else if ($emailMatch){
			return array('msg' => 'E-mail already in use', 'username' => $username);
		}
		
		if ($passValidation = $this->validatePassword($password, $passwordRepeat)){
			return array('msg' => $passValidation, 'username' => $username, 'email' => $email); 
		}

		$hashedPassword = hash("sha512", $password);
		$this->dbHandler->insertUser($username, $email, $hashedPassword);
		return NULL;

	}

	public function deleteUser(){
		$id_user = Session::getLoggedInUserId();
		$username = Session::getLoggedInUsername();
		$this->dbHandler->deleteUser($id_user);
		array_map('unlink', array_filter((array) glob(BP.'images/'.$username.'/*')));
		rmdir(BP.'images/'.$username);
	}

	public function changePassword(){
		$id_user = Session::getLoggedInUserId();
		$newPassword = Request::post('newPasswordInput');
		$newPasswordRepeat = Request::post('newPasswordInputRepeat');

		if (empty($newPassword) || empty($newPasswordRepeat)){
			return array('msg' =>  'Fill in the fields',  'msgType' => 'error', 'msgTitle' => 'Password');
		}

		if ($passValidation = $this->validatePassword($newPassword, $newPasswordRepeat)){
			return array('msg' => $passValidation, 'msgTitle'  =>  'Password', 'msgType' => 'error');
		}

		$this->dbHandler->updatePassword($id_user, hash("sha512", $newPassword));
		return array('msg' => 'Changed succesfuly', 'msgTitle' => 'Password', 'msgType' => 'success');

	}

	private function validatePassword($password, $passwordRepeat){
		if (!preg_match("/.{8,}/", $password)){
			// password must be at least 8 characters long
			return 'Password must contain more than 8 characters';
		}

		else if (!preg_match("/\d/", $password)){
			// password must contain at least one number
			return 'Password must contain numbers';
		}

		else if (!preg_match("/[a-z]/", $password)){
			// password must contain lower case
			return 'Password must contain lower case letters';
		}

		else if (!preg_match("/[A-Z]/", $password)){
			// password must contain upper case letters
			return 'Password must contain upper case letters';
		}

		else if ($password !== $passwordRepeat){
			// passwords dont match
			return "Passwords don\'t match";
		}
	}

}


