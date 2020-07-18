<?php
final class App{


	public static function start(){
		$request = Request::getRequestInstance();
		$path = $request->getPathInfo();

		$controller = $path."Controller";


		if (class_exists($controller)){
			$controllerInstance = $controller::getControllerInstance();
			$controllerInstance->renderPage();
		}


	// TODO:
		// perform redirect
		// i need a page to redirect to
		// request class should provide a page URL
		// from here we only go to 404 or index page

	}

}





?>
