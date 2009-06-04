<?php

require_once ('./core/view/AbstractView.class.php');


class View extends AbstractView
{

    private $controller;
    private $action;
    private $_param = array();
    private $title = 'My Web';
    private $content = null;
    private $layout = 'default';    
    
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    
    public function __set($attr, $value)
    {
        $this->_param[$attr] = $value;
    }
    public function __get($attr)
    {
        return $this->_param[$attr];
    }
    
    public function render($action)
    {
        if($this->setContent($action)){
            include_once("./app/views/layouts/$this->layout.tpl.php");
        }
        
    }
    
    // Setter & Getter
    
    public function getContent(){
        return $this->content;
    }
    public function setContent($action){
        $this->action = $action;
        $controllerDir = strtolower($this->controller);
        if (file_exists("./app/views/$controllerDir/$this->action.tpl.php")) {
            foreach ($this->_param as $key => $value) 
            {
                $$key = $value;
            }
            ob_start();
            include_once("./app/views/$controllerDir/$this->action.tpl.php");
            $this->content = ob_get_clean();
            return true;
        } else {
            return false;
        }
        
    }
    public function getAction()
    {
        return $this->action;
    }
    public function setAction($action)
    {
        $this->action = $action;
    }
    public function getController()
    {
        return $this->controller;
    }
    public function setController($controller)
    {
        $this->controller = $controller;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

}