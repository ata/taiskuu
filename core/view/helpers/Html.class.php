<?php
class Html{
    public static function url($url,$params = null)
    {
        return $_SERVER['SCRIPT_NAME'] .'?c='. $url;
        if(is_array($params) && $params != null) {
            
        }
    }
    public static function redirect($url)
    {
        header('Location:'. Core::url($url));
    }
    public static function media($url)
    {
        $scriptname =  $_SERVER['SCRIPT_NAME'];
        $path = str_replace(basename($scriptname), '', $scriptname);
        return $path . 'media/'. $url;
    }
}