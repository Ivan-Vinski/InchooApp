<?php

class RegisterController extends AbstractSingletonController{
	private $model;
	
	public function invokeController(){
		$this->model = RegisterModel::getRegisterModelInstance();

		if (isset($_POST['usernameInput']) && isset($_POST['emailInput']) && isset($_POST['passwordInput']) && isset($_POST['passwordRepeatInput'])){
			$msg = $this->model->register($_POST['usernameInput'], $_POST['emailInput'], $_POST['passwordInput'], $_POST['passwordRepeatInput']);
			View::renderPage('register', ['msg' => $msg,
								'username' => $_POST['usernameInput'],
								'email' => $_POST['emailInput'],								
								'password' => $_POST['passwordInput'],
								'passwordRepeat' => $_POST['passwordRepeatInput']
								]);
			

		} 
		else{
			View::renderPage('register',['msg' => "",
								'username' => "",
								'email' => "",
								'password' => "",
								'passwordRepeat' => ""
							]);
		}
			
	}
}
?>
