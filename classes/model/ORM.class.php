<?php

class ORM{


	public static function getImages(){
		$dbHandler = DatabaseHandler::getDBInstance();
		$images = $dbHandler->getImages();
		$imagesArray = [];
		foreach($images as $image){
			array_push($imagesArray, new Image($image[0], $image[1], $image[2], $image[3], $image[4]));
		}
		return $imagesArray;

	}

	public static function uploadImage($imageTitle, $filepath, $user_id){
		$dbHandler = DatabaseHandler::getDBInstance();
		$dbHandler->insertImage($imageTitle, $filepath, $user_id);
		$id_image = $dbHandler->getImageId($filepath);
		return $id_image;
	}

	public static function getUsers(){
		$dbHandler = DatabaseHandler::getDBInstance();

	}

}

/*

class Image{

  private $image_id;
  private $imageTitle;
  private $imageLocation;
  private $user_id;

  public function __construct($id, $title, $location, $user_id){
    $this->image_id = $id;
    $this->imageTitle = $title;
    $this->imageLocation = $location;
    $this->user_id = $user_id;
  }

	public function __get($property){
		if (property_exists($this, $property)){
			return $this->$property;
		}
	}

	public function __set($property, $value){
		if (property_exists($this, $property)){
			$this->$property = $value;
		}
	}

}
 */
class User{
	private $id_user;
	private $username;
	private $email;
	private $password;

	public function __construct($id, $username, $email, $password){
		$this->$id_user = $id;
		$this->$username = $username;
		$this->$email = $email;
		$this->$password = $password;
	}
	public function __get($property){
		if (property_exists($this, $property)){
			return $this->$property;
		}
	}

	public function __set($property, $value){
		if (property_exists($this, $property)){
			$this->$property = $value;
		}
	}


}
