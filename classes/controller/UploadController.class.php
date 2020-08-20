<?php

class UploadController extends AbstractSingletonController{

  private $imgModel;

  public function invokeController(){
    Session::start();

    /*
    / Check if image is actually posted
    */
    if (!Request::post('uploadImage')){
      header("Location: http://localhost/inchooApp/home/");
      return;
    }

    $this->imgModel = Images::getInstance();
    if ($uploadFeedback = $this->imgModel->uploadImage()){
      	$uploadFeedback['photoCount'] = $this->imgModel->getPhotoCount();
        $uploadFeedback['imagesLocations'] = $this->imgModel->getImagesLocations();
        $uploadFeedback['imagesOwners'] = $this->imgModel->getImagesOwners();
        $uploadFeedback['imagesTitles'] = $this->imgModel->getImagesTitles();
        $uploadFeedback['msgTitle'] = 'Image upload';

        $this->view = new View("homeLayout");
        $this->view->renderPage("home", $uploadFeedback);
    }

  }

}
