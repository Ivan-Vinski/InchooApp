<?php
class LoginController extends AbstractSingletonController{
	private $model;

	public function invokeController(){
		$this->model = LoginModel::getHomeModelInstance();
		
		if (isset($_GET['count'])){
			$photoCount = $this->model->getPhotoCount();
			echo $photoCount;

		}
		else if (isset($_POST['usernameInput']) && isset($_POST['passwordInput'])){
				$loginReturn = $this->model->login($_POST['usernameInput'], $_POST['passwordInput']);
				View::renderPage('login', ['msg' => $loginReturn, 'usernameVal'=> $_POST['usernameInput']]);
			}
		
		else{
			View::renderPage('login', ['msg' => "", 'usernameVal'=>""]);
		}	
	}
}

 ?>
