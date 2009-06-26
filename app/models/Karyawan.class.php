<?php
class Karyawan extends Model
{
    public function setup()
    {
        $this->attributes['tanggal_lahir']['type'] = "DATE2";
        $this->attributes['aktif']['type'] = "BOOL";
        $this->relations = array(
            'listPresensi'  => array (
                'model'         =>  'Presensi',
                'foreign_key'   =>  'karyawan_id',
                'type'          =>  Model::HAS_MANY
            ),
            'listGaji'  => array (
                'model'         =>  'Gaji',
                'foreign_key'   =>  'karyawan_id',
                'type'          =>  Model::HAS_MANY
            ),
            'listJamLembur'  => array (
                'model'         =>  'JamLembur',
                'foreign_key'   =>  'karyawan_id',
                'type'          =>  Model::HAS_MANY
            )
        );
    }
    public static function m($className = __CLASS__)
    {
        
        return parent::model($className);
    }
}