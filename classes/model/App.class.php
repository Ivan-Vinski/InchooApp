<?php

final class App{
	private static $dbHandler;
	public static $imgModel;
	public static function start(){
		/*
		 * Check if all database tables exist
		 * and create them if they don't.
		 * Use database handler
		 */
		if(self::checkDB()){
			self::$imgModel = Images::getInstance();
//			var_dump(self::$imgModel);
			self::callController();
		}
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

		$requestMethod = Request::getMethod();
		$pathInfo = Request::getPathInfo();
		$pathInfo = trim($pathInfo, '/');

		$pathParts = explode('/', $pathInfo);

		if (!isset($pathParts[0]) || empty($pathParts[0])){
			$controller = 'LoginController';
		}
		else {
			$controller = ucfirst($pathParts[0]).'Controller';
		}

		$action = strtolower($requestMethod);
		if (class_exists($controller) && method_exists($controller, $action) && !isset($pathParts[1])){
			$controllerInstance = $controller::getInstance();
			$controllerInstance->$action();
		}
		else{
			echo "404";
		}

	}
}

