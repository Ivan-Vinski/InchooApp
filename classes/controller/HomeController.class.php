<?php

class HomeController extends AbstractSingletonController{

	private $model;
	private $view;

	public function get(){
		Session::start();

		if (!Session::isLoggedIn()){
			header("Location: http://localhost/inchooApp/");
			return;
		}

		$this->model = Images::getInstance(); 
		$images = $this->model->getImages();

		$this->view = new View('homeLayout');
		$this->view->renderPage('home', array('photoCount' => $this->model->getPhotoCount(), 'images' => $images));
	}

	public function post(){
		Session::start();
		$this->model = Images::getInstance();
		$deleteFeedback = $this->model->deleteImage();
		header("Location: http://localhost/inchooApp/home");
	}

}
