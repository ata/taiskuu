<?php
class Core{
	public static function getRequest($controller, $action = 'index', $param = null){
		include CONTROLLER_DIR . $controller . '_controller.php';
		$className = ucfirst($controller) .'Controller';
		$con =  new $className();
		if($param == null){
			$con->$action();
		} else {
			$con->$action($param);
		}
	}
	public static function url($url){
		return $_SERVER['SCRIPT_NAME'] .'?q='. $url;
	}
	public static function redirect($url){
		header('Location:'. Core::url($url));
	}
}
