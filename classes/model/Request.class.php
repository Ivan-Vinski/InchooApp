<?php

/*
 * Class for handling requests
 */
class Request{
  public static function getPathInfo(){
    if (isset($_SERVER["PATH_INFO"])){
		//    This doesn't seem to be happening except with strange URL's:
		//    localhost/inchooApp/index.php/something/
		//    "/something" would be in PATH_INFO variable
		//	  var_dump($_SERVER["PATH_INFO"]);
      return $_SERVER["PATH_INFO"];
    }
    else if (isset($_SERVER["REDIRECT_PATH_INFO"])){
		//		Used when .htdocs rewrite rule is applied
		//		var_dump($_SERVER["REDIRECT_PATH_INFO"]);
      return $_SERVER["REDIRECT_PATH_INFO"];
    }
	//		Used when rewrite rule doesn't apply
    else return "";
  }

  public static function post($key){
  	return (isset($_POST[$key])) ? $_POST[$key] : '';
  }

  public static function get($key){
  	return (isset($_GET[$key])) ? $_GET[$key] : '';
  }

}

 
