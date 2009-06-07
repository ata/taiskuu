<?php
class Form
{
    protected $name;
    protected $fields = array();
    public function __construct($name,$url)
    {
        $this->name = $name;
        $action = Html::url($url);
        $field = "<table class=\"form $name\"><form action=\"$action\" method=\"post\"><tbody>";
        array_push($this->fields,$field);
        return  $field;
    }
    public function text($name, $attributes = array())
    {
        $label = str_replace('_',' ',$name);
        $name = $this->name . "[$name]";
        $attributes = array_merge($attributes,array('name' => $name,'type'=> 'text'));
        return $this->input($label,$attributes);
    }
    
    public function textarea($name, $attributes = array())
    {
        $label = str_replace('_',' ',$name);
        $name = $this->name . "[$name]";
        $attributes = array_merge($attributes,array('name' => $name));
        $value = "";
        if(array_key_exists('value',$attributes)) {
            $value = $attributes['value'];
        }
        $attrstring = $this->generateAttrs($attributes);
        $field = "<tr><th>$label</th><td><textarea $attrstring>$value</textarea></td></tr>";
        array_push($this->fields,$field);
        return $this;
        
    }
    
    public function hidden($name, $attributes = array())
    {
        $name = $this->name . "[$name]";
        $attributes = array_merge($attributes,array('name' => $name,'type'=> 'hidden'));
        return $this->input(null,$attributes);
    }
    public function radio($name, $options, $attributes = array())
    {
        $label = str_replace('_',' ',$name);
        $nm = $this->name . "[$name]";
        $checked = "";
        $radio = "";
        foreach($options as $value => $labelfor) {
            if(array_key_exists('value',$attributes) && $value = $attributes['value']) {
                $checked = "checked=\"checked\"";
            }
            $radio .= "<input $checked type=\"radio\" name=\"$nm\" value=\"$value\" id=\"$name$value\"/>";
            $radio .= "<label class=\"label-for-radio\" for=\"$name$value\">$labelfor</label><br/>";
        }
        $field = "<tr><th>$label</th><td>$radio</td></tr>";
        array_push($this->fields,$field);
        return $this;
        
    }
    public function password($name, $attributes = array())
    {
        $label = str_replace('_',' ',$name);
        $name = $this->name . "[$name]";
        $attributes = array_merge($attributes,array('name' => $name,'type'=> 'password'));
        return $this->input($label,$attributes);
    }
    public function select($name, $options, $attributes = array())
    {
        $label = str_replace('_',' ',$name);
        $name = $this->name . "[$name]";
        $select = "<select name=\"$name\">";
        
        foreach($options as $value => $labelfor) {
            if(array_key_exists('value',$attributes) && $value == $attributes['value']) {
                $select .= "<option selected=\"selected\" value=\"$value\">$labelfor</option>";
            } else {
                $select .= "<option value=\"$value\">$labelfor</option>";
            }
        }
        $select .= "</select>";
        $field = "<tr><th>$label</th><td>$select</td></tr>";
        array_push($this->fields,$field);
        return $this;
    }
    public function date($name, $attributes = array())
    {
        $label = str_replace('_',' ',$name);
        $name = $this->name . "[$name]";
        $attributes = array_merge($attributes,array('name' => $name,
                                                    'type'=> 'text',
                                                    'class'=>'w8em format-y-m-d divider-dash'));
        return $this->input($label,$attributes);
    }

    public function input($label = null, $attributes = array())
    {
        $attrstring = $this->generateAttrs($attributes);
        if($label == null) {
            $field = "<input $attrstring />";
        } else {
            $field = "<tr><th>$label</th><td><input $attrstring /></td></tr>";
        }
        
        array_push($this->fields,$field);
        return $this;
    }
    public function end($value)
    {
        $field = "</tbody><tfoot><tr><td> </td><td><input type=\"submit\" value=\"$value\"/></td></tr></tfoot></table>";
        array_push($this->fields,$field);
        return $this;
    }
    
    private function generateAttrs($attrs = array())
    {
        $str = "";
        foreach($attrs as $key => $value) {
            $str .= "$key=\"$value\" ";
        }
        return $str;
    }
    
    public function __toString()
    {
        return join("\n",$this->fields);
    }
}