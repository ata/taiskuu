<?php
class Post extends Model
{
    public function setup()
    {
        $this->attributes = array(
            'title' => null,
            'body'  => null
        );
    }
    public static function m()
    {
        return parent::model(__CLASS__);
    }
}