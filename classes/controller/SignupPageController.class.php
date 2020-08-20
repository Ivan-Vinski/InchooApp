<?php

class SignupPageController extends AbstractSingletonController{
	private $view;

	public function invokeController(){
		$this->view = new View('loginRegisterLayout');
		$this->view->renderPage('signup');
	
	}
}
