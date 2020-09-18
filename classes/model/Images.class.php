<?php
//

class Images{
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

	public function getPhotoCount(){
		return $this->dbHandler->getPhotoCount();
	}

	public function getImages(){
		$images = $this->dbHandler->getImages();
		return $images;
	}


	public function uploadImage(){
		$user_id = Session::getLoggedInUserId();
		$username = Session::getLoggedInUsername();
		$imageTitle = Request::post('titleInput');
		$file = $_FILES['imageInput'];
		$filename = $file['name'];
		$imageLocation = $username."/".$filename;

		if (!isset($file['name']) || empty($file['name'])){
			return array('msg' => 'Select image to upload.', 'msgType' => 'error');
		}

		/*
		 * Check if file has forbiden characters
		 */

		if (preg_match("/[\s\']/", $filename)){
			return array('msg' => 'File contains forbidden characters', 'msgType' => 'error', 'imageTitle' => $imageTitle);
		}

		/*
		 * Check if file is a valid image
		 */
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$fileType = $finfo->file($file['tmp_name']);
		if (false === array_search($fileType, array('image/jpg', 'image/jpeg', 'image/png'))){
			return array('msg' => 'Use the following image formats: jpg, jpeg, png.', 'msgType' => 'error', 'imageTitle' => $imageTitle);
		}

		/*
		 * Check if user's directory exists, create if not
		 */
		$dir = BP."images/".$username;
		if (!is_dir($dir)){
			mkdir($dir);
		}
		/*
		 * Check if file with such name exists in user's directory
		 */
		$filepath = $dir."/".$filename;
		if (file_exists($filepath)){
			return array('msg' => 'File already exists', 'msgType' => 'error', 'imageTitle' => $imageTitle);
		}

		/* 
		 * Check file size
		 */
		$filesize = filesize($file['tmp_name']);
		if ($filesize > 5000000){
			return array('msg' => 'File is too large', 'msgType' => 'error', 'imageTitle' => $imageTitle);
		}

		// Move uploaded file to it's new home directory
		move_uploaded_file($file['tmp_name'], $filepath);

		// Add image to the database
		$this->dbHandler->insertImage($imageTitle, $imageLocation, $user_id);
		//$id_image = $this->dbHandler->getImageId($imageLocation);
		$this->photoCount++;

		// Upload finished with success
		return array('msg' => 'Succesful', 'msgType' => 'success');
	}

	public function deleteImage(){
		$id_image = Request::post('inputDelete');

		// Delete from database
		$this->dbHandler->deleteImage($id_image);
		foreach($this->images as $image){
			if ($image->id_image == $id_image){
				// Delete from filesystem
				unlink(BP."images/".$image->imageLocation);
				// Delete from array of images
			}
		}
	}
}


