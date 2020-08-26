<?php

class LoginController extends AbstractSingletonController{
	private $model;
	private $view;
/*
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
 */
	public function getPhotoCount(){
		$this->model = Images::getInstance();
		$photoCount = $this->model->getPhotoCount();
		echo $photoCount;
	}

	public function get(){
		$this->view = new View('loginRegisterLayout');
		$username = Cookies::getCookies('username');
		$password = Cookies::getCookies('password');

		Session::logout();

		$this->view->renderPage('login', ['username' => $username, 'password' => $password]);
	
	}

	public function post(){
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
			$this->view->renderPage('login', $loginFeedback);
		}

	}
}
