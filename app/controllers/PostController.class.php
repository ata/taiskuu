<?php
class PostController extends Controller
{
    protected $models = array('Karyawan','JamLembur');
    public function index()
    {
        $k = Karyawan::m()->find(1);
        var_dump($k->listPresensi[0]);
        $jl = JamLembur::m()->find(1);
        var_dump($jl->karyawan);
        
    }
    public function create()
    {
        
    }
    public function edit($id)
    {
        
    }
    public function save()
    {
        
    }
    
}