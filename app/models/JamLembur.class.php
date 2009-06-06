<?php
class JamLembur extends Model
{
    public function setup()
    {
        $this->attributes = array(
            'hari'              =>  null,
            'jumlah_jam'         =>  null,
            'karyawan_id'       =>  null,
            'periode_id'        =>  null,
            'tanggal'           =>  null
        );
        $this->relations = array(
            'karyawan'  => array (
                'model'         =>  'Karyawan',
                'foreign_key'   =>  'karyawan_id',
                'type'          =>  Model::BELONGS_TO
            ),
            'periode'  => array (
                'model'         =>  'Periode',
                'foreign_key'   =>  'periode_id',
                'type'          =>  Model::BELONGS_TO
            )
        );
    }
    public static function m()
    {
        return parent::model(__CLASS__);
    }
}