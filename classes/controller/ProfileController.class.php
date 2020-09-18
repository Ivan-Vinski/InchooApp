<?php

class ProfileController extends AbstractSingletonController{

	private $model;
	private $view;


	public function get(){
		Session::start();

		if (!Session::isLoggedIn()){
			header("Location: http://localhost/inchooApp/");
			return;
		}

		$this->view = new View('homeLayout');
		$this->view->renderPage('profile');
	
	}

	public function post(){
		Session::start();
		$this->model = Users::getInstance();

		$updateFeedback = $this->model->changePassword();	
		$this->view = new View('homeLayout');
		$this->view->renderPage('profile', $updateFeedback);

	}

}
