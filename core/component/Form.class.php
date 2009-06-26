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
            if(array_key_exists('value',$attributes) && $value == $attributes['value']) {
                $checked = "checked=\"checked\"";
            }
            $radio .= "<input $checked type=\"radio\" name=\"$nm\" value=\"$value\" id=\"$name$value\"/>";
            $radio .= "<label class=\"label-for-radio\" for=\"$name$value\">$labelfor</label><br/>";
        }
        $field = "<tr><th>$label</th><td>$radio</td></tr>";
        array_push($this->fields,$field);
        return $this;
    }
    
    public function checkbox($name, $attributes = array())
    {
        $label = str_replace('_',' ',$name);
        $nm = $this->name . "[$name]";
        $checked = "";
        if(array_key_exists('value',$attributes) && $attributes['value'] == "1") {
            $checked = "checked=\"checked\"";
        }
        
        $checkbox = "<input $checked type=\"checkbox\" name=\"$nm\" value=\"1\" id=\"$name\"/>";
        $checkbox .= "<label class=\"label-for-radio\" for=\"$name\">$label</label><br/>";
        
        $field = "<tr><th>&nbsp;</th><td>$checkbox</td></tr>";
        array_push($this->fields,$field);
        return $this;
    }
    
    public function dateChoice($name, $attributes = array()){
        $label = str_replace('_',' ',$name);
        $name = $this->name . "[$name]";
        
        $month = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );
        
        $selected_y = 1990;
        $selected_m = 1;
        $selected_d = 1;
        if(array_key_exists('value',$attributes)){
            $date = explode("-",$attributes['value']);
            $selected_y = $date[0];
            $selected_m = $date[1];
            $selected_d  = $date[2];
        }
        
        $y_name = $name . "[y]";
        $y = "<select name=\"$y_name\">";
        $y .= $selected_y;
        for($i= 1940; $i <= 2010; $i++){
            if($i == $selected_y ) {
                $y .= "<option selected=\"selected\" value=\"$i\">$i</option>";
            } else {
                $y .= "<option value=\"$i\">$i</option>";
            }
        }
        $y .= "</select>";
        
        
        $m_name = $name . "[m]";
        $m = "<select name=\"$m_name\">";
        $m .= $selected_m;
        foreach($month as $key => $value){
            if($key == $selected_m) {
                $m .= "<option selected=\"selected\" value=\"$key\">$value</option>";
            } else {
                $m .= "<option value=\"$key\">$value</option>";
            }
        }
        $m .= "</select>";
        
        $d_name = $name . "[d]";
        $d = "<select name=\"$d_name\">";
        $d .= $selected_d;
        for($i= 1; $i <= 31; $i++){
            if ($i == $selected_d) {
                $d .= "<option selected=\"selected\" value=\"$i\">$i</option>";
            } else {
                $d .= "<option value=\"$i\">$i</option>";
            }
        }
        $d .= "</select>";
        $field = "<tr><th>$label</th><td>$y $m $d</td></tr>";
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

    public function input($label = null, $attributes = array(),$after="")
    {
        $attrstring = $this->generateAttrs($attributes);
        if($label == null) {
            $field = "<input $attrstring />";
        } else {
            $field = "<tr><th>$label</th><td><input $attrstring />$after</td></tr>";
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