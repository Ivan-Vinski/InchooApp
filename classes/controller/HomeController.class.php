<?php
class HomeController extends AbstractSingletonController{
	/*
	private static $instances = [];
	
	private function __construct(){}

	public static function getControllerInstance(){
		$cls = static::class;
		if (!isset(self::$instances[$cls])){
			self::$instances[$cls] = new static;
		}
		return self::$instances[$cls];
	}
 */


	private $model;
	public function invokeController(){
		$this->model = HomeModel::getHomeModelInstance();
		if (isset($_GET['count'])){
			$photoCount = $this->model->getPhotoCount();
			echo $photoCount;

		}
		else if (isset($_POST['usernameInput']) && isset($_POST['passwordInput'])){
				$loginMsg = $this->model->login($_POST['usernameInput'], $_POST['passwordInput']);
				self::renderPage(['loginMsg' => $loginMsg, 'usernameVal'=> $_POST['usernameInput']]);
			}
		
		else{

			self::renderPage(['loginMsg' => "", 'usernameVal'=>""]);
		}	
	}


	private function renderPage($args = []){
		ob_start();
		extract($args);
		include BP."/classes/view/home.phtml";
		$content = ob_get_clean();
		echo $content;
	}

}

 ?>
