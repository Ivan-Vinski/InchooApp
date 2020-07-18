<?php

class ErrorController{
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
		include BP."/classes/view/error.phtml";	
		$content = ob_get_clean();
		echo $content;
	}


}


 ?>
