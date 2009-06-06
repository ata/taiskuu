<?php
class Gaji extends Model
{
    public function setup()
    {
        $this->attributes = array(
            'karyawan_id'       =>  null,
            'periode_id'        =>  null,
            'gajiPokok'         =>  null,
            'tunjangan_jabatan'  =>  null,
            'tunjangan_keluarga' =>  null,
            'tunjangan_lain'     =>  null,
            'uang_lembur'        =>  null,
            'uang_tranport'      =>  null,
            'uang_makan'         =>  null,
            'bonus'             =>  null,
            'potongan'          =>  null
        );
    }
    public static function m()
    {
        return parent::model(__CLASS__);
    }
}