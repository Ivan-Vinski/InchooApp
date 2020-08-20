<?php

class IndexController extends AbstractSingletonController{
	private $view;
	private $model;
	/*
	 * Get initial arguments from model
	 * like cookies if they are set
	 * and pass them to view for rendering
	 */
	public function invokeController(){
		//$args = $this->model->pageInit();
		$this->view = new View('loginRegisterLayout');
		$username = Cookies::getCookies('username');
		$password = Cookies::getCookies('password');

		Session::logout();

		$this->view->renderPage('index', ['username' => $username, 'password' => $password]);
	}

	/*
	 * Get number of photos in DB from
	 * the model and return it to ajax
	 * script with echo
	 */

	public function getPhotoCount(){
		$this->model = Images::getInstance(); 
		$photoCount = $this->model->getPhotoCount();
		echo $photoCount;	
	}
}
