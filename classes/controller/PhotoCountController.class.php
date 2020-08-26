<?php


class PhotoCountController extends AbstractSingletonController{

	private $model;
	public function get(){
		$this->model = Images::getInstance();
		$photoCount = $this->model->getPhotoCount();
		echo $photoCount;	
	}

}
