<?php
class IndexController{
	private $model;

	public function __construct(){
		$this->model = new IndexModel();
	}

	public function invokeController(){
		if (isset($_GET['count'])){
			$photoCount = $this->model->getPhotoCount();
			echo $photoCount;

		}
		else{
			View::renderPage('index', ['msg' => "", 'usernameVal'=>""]);
		}	
	}

	public function login(){
		$this->model->login();
	}
}

 ?>
