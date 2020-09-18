<?php

class DeleteController extends AbstractSingletonController{
	private $model;

	public function post(){
		Session::start();
		$this->model = Users::getInstance();
		$this->model->deleteUser();
		header("Location: http://localhost/inchooApp/");
	}
}
