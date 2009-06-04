<?php
class Karyawan extends Model
{
    public function setup()
    {
        $this->attributes = array(
            'nik'               =>  null,
            'namaLengkap'       =>  null,
            'tempatLahir'       =>  null,
            'tanggalLahir'      =>  null,
            'golongan'          =>  null,
            'gajiPokok'         =>  null,
            'tunjanganJabatan'  =>  null,
            'tunjanganKeluarga' =>  null,
            'tunjanganLain'     =>  null,
            'transportPerHari'  =>  null,
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
    public static function m()
    {
        return parent::model(__CLASS__);
    }
}