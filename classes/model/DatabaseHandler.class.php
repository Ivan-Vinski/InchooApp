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
				email VARCHAR(30) NOT NULL,
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
				title VARCHAR(50) NOT NULL,
				location VARCHAR(100) NOT NULL,
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

	public function getUsers(){
		$sql = "SELECT * FROM users";
		$users = $this->prepareAndExecute($sql);
		return $users;
	}

	public function getUser($username){
		$sql = "SELECT * FROM users WHERE username = ?";
		$user = $this->prepareAndExecute($sql, array($username));
		return (empty($user)) ? NULL : $user[0];	
	}

	public function getUserByEmail($email){
		$sql = "SELECT username FROM users WHERE email LIKE ?";
		$username = $this->prepareAndExecute($sql, array($email));
		return $username;
	}
/*
	public function getUserId($username){
		$sql = "SELECT id_user FROM users WHERE username LIKE ?";
		$id_user = $this->prepareAndExecute($sql, array($username));
		return (empty($id_user)) ? '' : $id_user[0][0];
	}
 */
	public function insertUser($username, $email, $password){
		$sql = "INSERT INTO users VALUES (default, ?, ?, ?)";
		$stmnt = $this->prepareAndExecute($sql, array($username, $email, $password));
	}

	public function deleteUser($id_user){
		$sql = "DELETE FROM users WHERE id_user LIKE ?";
		$this->prepareAndExecute($sql, array($id_user));
	}

	public function updatePassword($id_user, $newPassword){
		$sql = "UPDATE users u SET u.password = ? WHERE u.id_user = ?"; 
		$this->prepareAndExecute($sql, array($newPassword, $id_user));
	}

	public function getImages(){
 
		$sql = "SELECT i.id_image, i.title, i.location, i.user_id, u.username FROM images i join users u on u.id_user=i.user_id";
		$images = $this->prepareAndExecute($sql);
		return $images;
	}
/*
	public function getImageId($filepath){
		$sql = "SELECT id_image FROM images WHERE location LIKE ?";
		$id_image = $this->prepareAndExecute($sql, array($filepath));
		return $id_image[0][0];
	}
 */
	public function insertImage($imageTitle, $filepath, $user_id){
		$sql = "INSERT INTO images VALUES (default, ?, ?, ?)";
		$stmnt = $this->prepareAndExecute($sql, array($imageTitle, $filepath, $user_id));
	}

	public function deleteImage($id_image){
		$sql = "DELETE FROM images WHERE id_image = ?";
		$stmnt = $this->prepareAndExecute($sql, array($id_image));
	}

}
