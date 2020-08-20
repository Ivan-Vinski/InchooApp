<?php

class DatabaseHandler{

	private static $instance;
	private $dbConn;
	private function __construct(){}

	public static function getDBInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}


	public function dbConnect(){
		try{
			$this->dbConn = new PDO('mysql:host=localhost;dbname=inchooAppDB', 'root', ''); 
			return true;
		}	
		catch (PDOException $e){
			return false;
		}
	}	

	public function createTables(){
		$sql_create_users = 'CREATE TABLE IF NOT EXISTS users
			(
				id_user INT NOT NULL AUTO_INCREMENT,
				username VARCHAR(20) NOT NULL,
				email VARCHAR(20) NOT NULL,
				password TEXT NOT NULL,
				PRIMARY KEY(id_user),
				CONSTRAINT unique_id_user UNIQUE(id_user)
			)';
		try{
			$stmnt_users = $this->dbConn->prepare($sql_create_users);
			$stmnt_users->execute();
		}
		catch (PDOException $e){
			return false;	
		}
		$sql_create_images = 'CREATE TABLE IF NOT EXISTS images
			(
				id_image INT NOT NULL AUTO_INCREMENT,
				title VARCHAR(20) NOT NULL,
				location VARCHAR(50) NOT NULL,
				user_id INT NOT NULL,
				PRIMARY KEY(id_image),
				CONSTRAINT unique_id_image UNIQUE(id_image),
				CONSTRAINT unique_location UNIQUE(location),
				FOREIGN KEY(user_id) REFERENCES users(id_user) ON DELETE CASCADE
			)';
		try{
			$stmnt_images = $this->dbConn->prepare($sql_create_images);
			$stmnt_images->execute();
			return true;
		}
		catch (PDOException $e){
			return false;	
		}
	}

	private function prepareAndExecute($sql, $args = []){
		$statement = $this->dbConn->prepare($sql);
		$statement->execute($args);
		$result = $statement->fetchAll();
		return $result;
		
	
	}

	public function getPhotoCount(){
		$sql = "SELECT COUNT(*) FROM users u INNER JOIN images i ON u.id_user=i.user_id";
		$count = $this->prepareAndExecute($sql);
		return $count[0][0];
		
	}

	public function getUsername($username){
		$sql = "SELECT username FROM users WHERE username LIKE ?";
		$dbUsername = $this->prepareAndExecute($sql, array($username));	
		return (empty($dbUsername)) ? '' : $dbUsername[0][0];
	}

	public function getPassword($username){
		$sql = "SELECT password FROM users WHERE username LIKE ?"; 
		$password = $this->prepareAndExecute($sql, array($username)); 
		return (empty($password)) ? "" : $password[0][0];

	}

	public function getEmail($email){
		$sql = "SELECT email FROM users WHERE email LIKE ?";
		$email = $this->prepareAndExecute($sql, array($email));
		return (empty($email)) ? "" : $email[0][0];
	}

	public function addUser($username, $email, $password){
		$sql = "INSERT INTO users VALUES (default, ?, ?, ?)";
		$stmnt = $this->prepareAndExecute($sql, array($username, $email, $password));
	}

	public function getImagesLocations(){
		$sql = "SELECT location FROM images";
		$stmnt = $this->prepareAndExecute($sql);
		return $stmnt;
	}

	public function getImagesTitles(){
		$sql = "SELECT title FROM images";
		$stmnt = $this->prepareAndExecute($sql);
		return $stmnt;
	}

	public function getImagesOwners(){
		$sql = "SELECT u.username FROM images i INNER JOIN users u ON i.user_id=u.id_user";
		$stmnt = $this->prepareAndExecute($sql);
		return $stmnt;
	}

	
}
