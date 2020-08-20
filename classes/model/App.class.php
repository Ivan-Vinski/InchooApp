<?php

final class App{
	private static $dbHandler;
	public static function start(){
		/*
		 * Check if all database tables exist
		 * and create them if they don't.
		 * Use database handler
		 */
		if(self::checkDB()){
			self::callController();
		}
		// TODO:
		// perform redirect
		// i need a page to redirect to
		// request class should provide a page URL
		// from here we only go to 404 or index page

	}

	private static function checkDB(){
		self::$dbHandler = DatabaseHandler::getDBInstance();
		if (self::$dbHandler->dbConnect() && self::$dbHandler->createTables()){
			return true;
		}
		else{
			return false;
		}
		
	}

	public static function callController($page=NULL, $msg=NULL){
		/*
		 * "getPathInfo()" returns "filename.php"
		 * we need "FilenameController"
		 * so we can run "FilenameController->invokeController()"
		 *
		 * If such class doesn't exist, redirect to errorController
		 */

		$pathInfo = Request::getPathInfo();
		$pathInfo = trim($pathInfo, '/');

		$pathParts = explode('/', $pathInfo);

		if (!isset($pathParts[0]) || empty($pathParts[0])){
			$controller = 'IndexController';
		}
		else {
			$controller = ucfirst($pathParts[0]).'Controller';
		}

		if (!isset($pathParts[1]) || empty($pathParts[1])){
			$action = 'invokeController';
		}
		else {
			$action = $pathParts[1];
		}

		if (class_exists($controller) && method_exists($controller, $action)){
			$controllerInstance = $controller::getInstance();
			$controllerInstance->$action();
		}
		else{
			// 404 
		}

	}
}

