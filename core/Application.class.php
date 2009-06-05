<?php

//contanta    
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)));

require_once ('./core/controller/Controller.class.php');
require_once ('./core/model/Model.class.php');
require_once ('./core/view/View.class.php');


class Application
{
    public static function run()
    {
        if(isset($_GET['page'])){
            $req = $_GET['page'];
            $req = explode("/",$req);
            
            if(count($req) == 1){
                self::getRequest($req[0]);
            }else if(count($req) == 2){
                self::getRequest($req[0],$req[1]);
            }else{
                self::getRequest($req[0],$req[1],$req[2]);
            }
        }else{
            $config = include('./app/config/main.php');
            self::getRequest($config['defaultController']);
        }
    }
    private static function getRequest($pcontroller, $paction = 'index', $param = null){
        
        $className = ucfirst($pcontroller) .'Controller';
        include_once("app/controllers/$className.class.php");
        
        $controller =  new $className();
        
        if($param == null){
            $controller->$paction();
        } else {
            $controller->$paction($param);
        }
        $controller->getView()->render($paction);
    }
    public static function import($classpath){
        
    }
}