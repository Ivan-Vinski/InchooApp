<?php
// Initialize BP variable with base_path
define('BP', __DIR__.'/');

# Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// auto import classes
set_include_path(implode(PATH_SEPARATOR, array(
	BP.'classes/model',
	BP.'classes/controller',
	BP.'classes/view/css'
)));

// autoload classes
spl_autoload_register(function($class){
	$filePathModel = "./classes/model/".$class.".class.php";
	$filePathController = "./classes/controller/".$class.".class.php";
	if (file_exists($filePathModel) || file_exists($filePathController)){
		return require_once $class.".class.php";
	}
});
// initialize application
//
//
App::start();

?>
