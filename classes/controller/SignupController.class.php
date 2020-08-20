<?php

class SignupController extends AbstractSingletonController{
	private $model;
	private $view;

	public function invokeController(){
		$this->model = Users::getInstance();
		$args = $this->model->registerUser();
		if (!$args){
			$this->view = new View('loginRegisterLayout');
			$this->view->renderPage('index');
		}
		else {
			$args['msgTitle'] = 'Signup';
			$args['msgType'] = 'error';
			$this->view = new View('loginRegisterLayout');
			$this->view->renderPage('signup', $args);
		}
	}
}
