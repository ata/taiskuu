<?php
class PostController extends Controller
{
    protected $models = array('Karyawan','JamLembur');
    public function index()
    {
        $this->nama = "Hello World";
        $this->karyawan   = Karyawan::m()->all();
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