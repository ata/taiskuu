<?php


class Mahasiswa extends Model
{
    public function setup()
    {
        $this->attributes = array(
            'nim' => null,
            'nama' => null
        );
    }
    public static function model()
    {
        return parent::model(__CLASS__);
    }

}
