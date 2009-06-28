<?php
define('CONTROLLER_DIR', dirname(__FILE__). '/controller/');
define('MODEL_DIR', dirname(__FILE__). '/model/');
define('VIEW_DIR', dirname(__FILE__). '/view/');
define('CONFIG_DIR', dirname(__FILE__). '/config/');
include CONFIG_DIR . 'core.php';
if(isset($_GET['q'])){
	$req = $_GET['q'];
	$req = explode("/",$req);
	if(!isset($req[2])){
		Core::getRequest($req[0],$req[1]);
	} else {
		Core::getRequest($req[0],$req[1],$req[2]);
	}
}else{
	Core::getRequest('buku','index');
}
