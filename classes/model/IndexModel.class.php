<?php

class IndexModel{
	private $dbHandler;
	
	public  function __construct(){}

	public static function getPhotoCount(){
		$count = (DatabaseHandler::getDBInstance())->getPhotoCount(); 
		return $count;
	}

	public function login(){
		/* check login data
		 * db handler makes requests to database
		 * get feedback, handle redirect	
		 */
		$username = Request::post('usernameInput');
		$password = Request::post('passwordInput');


		if(empty($username) || empty($password)){
			View::renderPage('index',['msg' => 'Fill in all the fields', 'usernameVal' => '']); 
			return;
		}	

		$this->dbHandler = DatabaseHandler::getDBInstance();

		if (empty($this->dbHandler->getUsername($username))){
			// User with give username not found
			View::renderPage('index',['msg' => 'Username not found', 'usernameVal' => $username]); 
			return;

		}

		$hashedPass = hash("sha512", $password);
		$dbPass = $this->dbHandler->getPassword($username);

		if ($hashedPass != $dbPass){
			// Passwords doesn't match
			View::renderPage('index',['msg' => 'Invalid password', 'usernameVal' => $username]);
			return;
		}
		// LOGIN SUCCESS, REDIRECT TO USERS PAGE
		// for now redirecting to error
		header("Location: error");
	}

}

?>
