<?php

class AjaxRequestController extends AbstractSingletonController{

	public function renderPage($photoCount=NULL){

		echo "<h id='photoCount'>".$photoCount."</h>";	
	}

}



?>
