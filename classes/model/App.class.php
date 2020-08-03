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
		if (self::$dbHandler->dbConnect()){
			// Connection succesfull
			if (self::$dbHandler->createTables()){
				return true;	
			}
			else {
				self::callController("ErrorController", "could not create tables");
				return false;
			}
		}
		else{
			// Connection failed, go to 404
			self::callController("ErrorController", "could not connect to database");
			return false;
		}
		
	}

	public static function callController($page=NULL, $msg=NULL){
		/*
		 * "getPathInfo()" returns "filename.php"
		 * we need "FilenameController"
		 * so we can run "FilenameController->renderPage()"
		 *
		 * If such class doesn't exist, redirect to errorController
		 */
		if (isset($page) || isset($msg)){
			$controller = $page::getControllerInstance();
			$controller->invokeController($msg);
			return;
		}
		
		else{
			$controller = (trim(ucfirst(Request::getPathInfo()), ".php"))."Controller";
			if (class_exists($controller)){
				($controller::getControllerInstance())->invokeController();
			}
			else{
				(ErrorController::getControllerInstance())->invokeController("404: file not found");
			}
		}
	}
}

