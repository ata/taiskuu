<?php
class Karyawan extends Model
{
    public function setup()
    {
        $this->attributes = array(
            'nik'                =>  null,
            'nama_lengkap'       =>  null,
            'tempat_lahir'       =>  null,
            'tanggal_lahir'     =>  null,
            'golongan'           =>  null,
            'gaji_pokok'         =>  null,
            'tunjangan_jabatan'  =>  null,
            'tunjangan_keluarga' =>  null,
            'tunjangan_lain'     =>  null,
            'transport_per_hari' =>  null,
        );
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