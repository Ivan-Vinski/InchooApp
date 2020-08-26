<?php

class HomeController extends AbstractSingletonController{

	private $imgModel;
	private $view;

	public function get(){
		Session::start();

		if (!Session::isLoggedIn()){
			header("Location: http://localhost/inchooApp/");
			return;
		}

		$this->imgModel = Images::getInstance();
		$this->view = new View('homeLayout');
		$this->view->renderPage('home', array('photoCount' => $this->imgModel->photoCount, 'images' => $this->imgModel->images));
	}

	public function post(){
    	Session::start();

 	   /*
    	/ Check if image is actually posted
    	
    	if (!Request::post('uploadImage')){
      		header("Location: http://localhost/inchooApp/home/");
      		return;
    	}
		*/
    	$this->imgModel = Images::getInstance();

   	 	$uploadFeedback = $this->imgModel->uploadImage();

   		$uploadFeedback['photoCount'] = $this->imgModel->photoCount;
    	$uploadFeedback['images'] = $this->imgModel->images;
    	$uploadFeedback['msgTitle'] = 'Image upload';
    	$this->view = new View("homeLayout");
    	$this->view->renderPage("home", $uploadFeedback);

  	}

}
