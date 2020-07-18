<?php
// Initialize BP variable with base_path
define('BP', __DIR__.'/');

# Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// auto import classes
set_include_path(implode(PATH_SEPARATOR, array(
	BP.'classes/model',
	BP.'classes/controller'
)));

// autoload classes
spl_autoload_register(function($class){
	// var_dump($class);
	//$classPath = strtr($class, '\\', DIRECTORY_SEPARATOR) . '.class.php';
	//var_dump($classPath);
	//return include $classPath;
	return include $class.'.class.php';
});

// initialize application
App::start();

?>
