<?php

class HomeController extends AbstractSingletonController{

	private $imgModel;
	private $view;

	public function invokeController(){
		Session::start();

			if (!Session::isLoggedIn()){
				header("Location: http://localhost/inchooApp/");
				return;
			}

		$this->imgModel = Images::getInstance();

		$photoCount = $this->imgModel->getPhotoCount();
		$imagesLocations = $this->imgModel->getImagesLocations();
		$imagesOwners = $this->imgModel->getImagesOwners();
		$imagesTitles = $this->imgModel->getImagesTitles();

		$args = array('photoCount' => $photoCount,
					  'imagesLocations' => $imagesLocations,
					  'imagesOwners' => $imagesOwners,
					  'imagesTitles' => $imagesTitles);

		$this->view = new View('homeLayout');
		$this->view->renderPage('home', $args);
	}

}
