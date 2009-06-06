<?php
require_once ('./core/controller/AbstractController.class.php');
require_once ('./core/view/View.class.php');
require_once ('./core/view/helpers/Html.class.php');
require_once ('./core/model/Model.class.php');
require_once ('./core/component/Session.class.php');
require_once ('./core/component/Form.class.php');

class Controller extends AbstractController
{
    protected $name = null;
    protected $view = null;
    protected $models = null;
    protected $session = null;
    protected $params = null;
    
    public function __construct()
    {
        $this->name = str_replace('Controller','', get_class($this));
        $this->view = new View($this->name);
        $this->loadModels();
        
    }
    
    public function __set($attr, $value){
        $this->getView()->$attr = $value;
    }
    
    public function __get($attr){
        return $this->models[$attr];
    }
    
    public function redirect($param)
    {
        header('Location:'. Html::url($param));
    }
    
    protected function loadModels(){
        if($this->models == null)
        {
            if(require_once("./app/models/$this->name.class.php")){
                
            }
        }
        else if(is_array($this->models))
        {
            foreach($this->models as $model)
            {
                if(require_once("./app/models/$model.class.php")){
                    
                }
            }
        }
        
    }
    
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getView()
    {
        return $this->view;
    }
    public function setView($view)
    {
        $this->view = $view;
    }
    public function setParams($params)
    {
        $this->params = $params;
    }

}
