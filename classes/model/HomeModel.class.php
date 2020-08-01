<?php

class HomeModel{
	private static $instance;
	private $dbHandler;

	

	private  function __construct(){}

	public static function getHomeModelInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function getPhotoCount(){
		$count = (DatabaseHandler::getDBInstance())->getPhotoCount(); 
		return $count;
	}

	public function login($username, $password){
		/* check login data
		 * db handler makes requests to database
		 * get feedback, handle redirect	
		 */
		if(empty($username) || empty($password)){
			return "<script>
					toastr.options={
						'closeButton':true,
						'positionClass': 'toast-top-center'
					}
					toastr['error']('Fill in all the fields', 'Login')
					 </script>";
		}	

		$this->dbHandler = DatabaseHandler::getDBInstance();
		
		$username = $this->cleanData($username);
		$password = $this->cleanData($password);
	
		if (empty($this->dbHandler->getUsername($username))){
			// User with give username not found
			return "<script>
					toastr.options={
						'closeButton':true,
						'positionClass': 'toast-top-center'
					}
					toastr['error']('Username not found', 'Login')
					 </script>";
		}

		$hashedPass = hash("sha512", $password);
		$dbPass = $this->dbHandler->getPassword($username);

		if ($hashedPass != $dbPass){
			// Passwords doesn't match
			return "<script>
					toastr.options={
						'closeButton':true,
						'positionClass': 'toast-top-center'
					}
					toastr['error']('Invalid password', 'Login')
					 </script>";
		}
		// LOGIN SUCCESS, REDIRECT TO USERS PAGE
		// for now redirecting to error
		header("Location: error");
	}
	
	public function cleanData($data){
		$data = htmlspecialchars($data);
		$data = str_replace("/", "", $data);	
		$data = str_replace("\\", "", $data);	
		return $data;
	}

}

?>
