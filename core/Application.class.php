<?php


require_once ('./core/controller/Controller.class.php');
require_once ('./core/model/Model.class.php');
require_once ('./core/view/View.class.php');

class Application
{
    public static function run()
    {
        $controller = null;
        $action = 'index';
        $params = null;
        
        if (isset($_GET['c'])) {
            $req = $_GET['c'];
            $req = explode("/",$req);
            if (count($req) == 1){
                $controller = $req[0];
            } else if (count($req) == 2){
                $controller = $req[0];
                $action = $req[1];
            }
        } else {
            $config = include('./app/config/main.php');
            $controller = $config['defaultController'];
        }
        self::setRequest($controller,$action);
    }
    private static function setRequest($pcontroller, $paction){
        $params = $_GET;
        unset($params['c']);
        $className = ucfirst($pcontroller) .'Controller';
        if(file_exists("./app/controllers/ApplicationController.class.php")) {
            include_once("./app/controllers/ApplicationController.class.php");
        }
        include_once("./app/controllers/$className.class.php");
        $controller =  new $className();
        $controller->setParams($params);
        $controller->$paction();
        $controller->getView()->render($paction);
    }
    public static function import($classpath){
        
    }
}