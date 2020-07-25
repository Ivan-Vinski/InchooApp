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

	public function renderPage(){
		ob_start();
		include BP."/classes/view/home.phtml";
		$content = ob_get_clean();
		echo $content;
	}
	 */
	public static function login(){
		

		/*
		 * Send login information to App
		 * App needs to contact database handler
		 * and retrieve data from database.
		 * App sends the data back to appropriate
		 * Controller which calls respective View
		 * to display the page.
		 */
	}
}

 ?>
