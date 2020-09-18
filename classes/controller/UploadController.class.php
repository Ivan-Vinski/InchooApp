<?php

class UploadController extends AbstractSingletonController{

	private $model;
	private $view;

	public function get(){
		Session::start();

		if (!Session::isLoggedIn()){
			header("Location: http://localhost/inchooApp/");
			return;
		}

		$this->view = new View('homeLayout');
		$this->view->renderPage('upload');
	}



	public function post(){
    	Session::start();

    	$this->model = Images::getInstance();

   	 	$uploadFeedback = $this->model->uploadImage();

    	$uploadFeedback['msgTitle'] = 'Upload';
    	$this->view = new View("homeLayout");
    	$this->view->renderPage("upload", $uploadFeedback);

  	}
}
