<?php

class SignupController extends AbstractSingletonController{
	private $model;
	private $view;

	public function get(){
		$this->view = new View('loginRegisterLayout');
		$this->view->renderPage('signup');
	
	}

	public function post(){
		$this->model = Users::getInstance();
		$args = $this->model->registerUser();
		if (!$args){
//			$this->view = new View('loginRegisterLayout');
//			$this->view->renderPage('login');
			header("Location: http://localhost/inchooApp/login/");
		}
		else {
			$args['msgTitle'] = 'Signup';
			$args['msgType'] = 'error';
			$this->view = new View('loginRegisterLayout');
			$this->view->renderPage('signup', $args);
		}
	}
}
