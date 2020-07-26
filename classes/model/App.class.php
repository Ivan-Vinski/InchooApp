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
			self::loadPage();
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
				self::loadPage("ErrorController", "could not create tables");
				return false;
			}
		}
		else{
			// Connection failed, go to 404
			self::loadPage("ErrorController", "could not connect to database");
			return false;
		}
		
	}

	private static function loadPage($page=NULL, $msg=NULL){
		/*
		 * "getPathInfo()" returns "filename.php"
		 * we need "FilenameController"
		 * so we can run "FilenameController->renderPage()"
		 *
		 * If such class doesn't exist, redirect to errorController
		 */
		if (isset($page)){
			$controller = $page::getControllerInstance();
			$controller->renderPage($msg);
			return;
		}
		
		else{
			$controller = (trim(ucfirst((Request::getRequestInstance())->getPathInfo()), ".php"))."Controller";
			if ($controller == "AjaxRequestController"){
				($controller::getControllerInstance())->renderPage(self::getPhotoCount());
			}
			else if (class_exists($controller)){
				($controller::getControllerInstance())->renderPage();
			}
			else{
				(ErrorController::getControllerInstance())->renderPage("404: file not found");
			}
		}
	}
	
	public static function getPhotoCount(){
		$count = self::$dbHandler->getPhotoCount(); 
		return $count;
	}
}
?>
