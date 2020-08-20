<?php

class LoginController extends AbstractSingletonController{
	private $model;
	private $view;

	public function invokeController(){
		Session::start();

		$this->model = Users::getInstance();
		$loginFeedback = $this->model->login();

		if (!$loginFeedback){
			// Login is succesful
			Header("Location: http://localhost/inchooApp/home/");
//			$this->view = new View('homeLayout');
//			$this->view->renderPage('home');
		}
		else {
			$loginFeedback['msgTitle'] = 'Login';
			$loginFeedback['msgType'] = 'error';
			$this->view = new View('loginRegisterLayout');
			$this->view->renderPage('index', $loginFeedback);
		}


	}
}
