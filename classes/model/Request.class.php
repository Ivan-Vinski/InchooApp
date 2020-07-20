<?php

/**
 * Class for handling requests
 * Singleton
 */
class Request
{

  private static $instances = [];


  private function __construct() {}

  public static function getRequestInstance()
  {
    $cls = static::class;
    if (!isset(self::$instances[$cls])) self::$instances[$cls] = new static;
    return self::$instances[$cls];
  }

  public static function getPathInfo()
  {
    // phpinfo();
    if (isset($_SERVER["PATH_INFO"])){
		//    This doesn't seem to be happening except with strange URL's:
		//    localhost/inchooApp/index.php/something/
		//    /something would be in PATH_INFO variable
		//	  var_dump($_SERVER["PATH_INFO"]);
      return $_SERVER["PATH_INFO"];
    }
    else if (isset($_SERVER["REDIRECT_PATH_INFO"])){
		//		Used when .htdocs rewrite rule is applied
		//		var_dump($_SERVER["REDIRECT_PATH_INFO"]);
      return $_SERVER["REDIRECT_PATH_INFO"];
    }
	//		Used when rewrite rule doesn't apply
    else return "home";
  }

}

 ?>
