<?php
final class App{


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
		$dbHandler = DatabaseHandler::getDBInstance();
		if ($dbHandler->dbConnect()){
			// Connection succesfull
			echo "<script>alert('Connection succesful');</script>";
			if ($dbHandler->createTables()){
				echo "<script>alert('Create tables created');</script>";
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
		
		
		/*
		 * CONTINUE CHECKING THE DATABASE
		 * check if all tables exist
		 * create them if they do not
		 */
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
			if (class_exists($controller)){
				($controller::getControllerInstance())->renderPage();
			}
			else{
				(ErrorController::getControllerInstance())->renderPage("404: file not found");
			}
		}
	}

}
?>
