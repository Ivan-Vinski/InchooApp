<?php

class DatabaseHandler{

	private static $instance;
	private $dbConn;
	private function __construct(){}

	public static function getDBInstance(){
		if (!isset($instance)){
			$instance = new self;
		}
		return $instance;
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
/*
	public function getDbConn(){
		if (isset($dbConn)){
			return $dbConn;
		}
		
		// test this and make it better
		 
		else{
			return NULL;
		}
	}

 */
	
	public function getPhotoCount(){
		$sql = "SELECT COUNT(*) FROM users u INNER JOIN images i ON u.id_user=i.user_id";
		
		$stmnt_count = $this->dbConn->prepare($sql);
		$stmnt_count->execute();		

		$count = $stmnt_count->fetch();
		return $count[0];
	}
	
}


?>
