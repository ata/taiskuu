<?php
class Gaji extends Model
{
    public function setup()
    {
        $this->attributes = array(
            'karyawan_id'       =>  null,
            'periode_id'        =>  null,
            'gajiPokok'         =>  null,
            'tunjanganJabatan'  =>  null,
            'tunjanganKeluarga' =>  null,
            'tunjanganLain'     =>  null,
            'uangLembur'        =>  null,
            'uangTranport'      =>  null,
            'uangMakan'         =>  null,
            'bonus'             =>  null,
            'potongan'          =>  null
        );
    }
    public static function m()
    {
        return parent::model(__CLASS__);
    }
}