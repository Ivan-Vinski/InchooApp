<?php

abstract class AbstractSingletonController{

/*
 * Array of instances.
 * Each element is singleton instance of a a class.
 * 
*/
	private static $instances = [];
	
// Not using constructor in a singleton pattern.
	private function __construct(){}


// Making sure single instance is created
	public static function getControllerInstance(){
		$cls = static::class;
		if (!isset(self::$instances[$cls])){
			self::$instances[$cls] = new static;
		}
		return self::$instances[$cls];
	}
/*
 * Given the instructions from Model
 * get the front end from View and
 * display it on a page.
 *
 */
 	public function renderPage(){
		$pageName = strtolower(str_replace("Controller", "", static::class));

		ob_start();
		include BP."classes/view/".$pageName.".phtml";
		$content = ob_get_clean();
		echo $content;
	}
}

 ?>
