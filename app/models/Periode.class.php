<?php
class Periode extends Model
{
    public function setup()
    {
        
        $this->relations = array(
            'listPresensi'  => array (
                'model'         =>  'Presensi',
                'foreign_key'   =>  'presensi_id',
                'type'          =>  Model::HAS_MANY
            ),
            'listGaji'  => array (
                'model'         =>  'Periode',
                'foreign_key'   =>  'periode_id',
                'type'          =>  Model::HAS_MANY
            ),
            'listJamLembur'  => array (
                'model'         =>  'JamLembur',
                'foreign_key'   =>  'periode_id',
                'type'          =>  Model::HAS_MANY
            )
        );
    }
    public static function m()
    {
        return parent::model(__CLASS__);
    }
}