<?php
class FormModel extends Form
{
    const ADD = 0;
    const EDIT = 1;
    protected $type = 0;
    protected $model = null;
    
    public function __construct($model, $url, $type = FormModel::ADD)
    {
        parent::__construct(get_class($model),$url);
        $this->model = $model;
        $this->type = $type;
        $this->generateForm();
    }
    private function generateForm()
    {
        foreach($this->model->getAttributes() as $key => $value)
        {
            if($this->type == FormModel::EDIT && $key == 'id') {
                $this->hidden('id',array('value'=>$value['value']));
            } else if($key != 'id') {
                switch($value['type']) {
                    case 'DATE':
                        $this->date($key,array('value' => $value['value']));
                        break;
                    case 'BLOB':
                        $this->textarea($key,array('value' => $value['value']));
                        break;
                    default:
                        $this->text($key,array('value'=>$value['value']));
                }
            }
        }
        if($this->type == FormModel::ADD) {
            $this->end("Add");
        } else {
            $this->end("Update");
        }
    }

}