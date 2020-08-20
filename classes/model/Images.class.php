<?php


class Images{

	private $dbHandler;
	private static $instance;

	private $title;
	private $location;
	private $owner;

	private function __construct(){
		$this->dbHandler = DatabaseHandler::getDBInstance();
	}

	public static function getInstance(){
		if (!isset($instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function getPhotoCount(){
		$count = $this->dbHandler->getPhotoCount();
		return $count;
	}

	public function getImagesOwners(){
		$owners = $this->dbHandler->getImagesOwners();
		return $owners;
	}

	public function getImagesTitles(){
		$titles = $this->dbHandler->getImagesTitles();
		return $titles;
	}

	public function getImagesLocations(){
		$locations = $this->dbHandler->getImagesLocations();
		return $locations;

	}

	public function uploadImage(){
		$target = "images/";


		if (!isset($_FILES['imageInput']['name']) || empty($_FILES['imageInput']['name'])){
			return array('msg' => 'Please, select image to upload.', 'msgType' => 'error');
		}

		/*
		/ Check if file is a valid image
		*/
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$fileType = $finfo->file($_FILES['imageInput']['tmp_name']);
		if (false === array_search($fileType, array('image/jpg', 'image/jpeg', 'image/png'))){
			// false format
			return array('msg' => 'Please, use the following image formats: jpg, jpeg, png.', 'msgType' => 'error');
		}

		// check if file already exists


		return array('msg' => 'Upload succesful', 'msgType' => 'success');

		// check file size
	}
}
