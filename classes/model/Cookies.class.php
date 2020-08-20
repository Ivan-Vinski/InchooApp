<?php

class Cookies{
	
	public static function setCookies($cookieName, $cookieValue){
		setcookie($cookieName, $cookieValue, time() + (86400 * 30), '/');
	}

	public static function getCookies($cookieName){
		return (isset($_COOKIE[$cookieName])) ? $_COOKIE[$cookieName] : '';
	}

	public static function deleteCookies($cookieName){
		setcookie($cookieName, '', time() - 1, '/');
	}
	


}
