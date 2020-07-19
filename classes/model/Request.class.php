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
 //     echo "A";
//	  var_dump($_SERVER["PATH_INFO"]);
      return $_SERVER["PATH_INFO"];
    }
    else if (isset($_SERVER["REDIRECT_PATH_INFO"])){
//		echo "B";
//		var_dump($_SERVER["REDIRECT_PATH_INFO"]);
      return $_SERVER["REDIRECT_PATH_INFO"];

    }
    else return "Home";
  }

}



 ?>
