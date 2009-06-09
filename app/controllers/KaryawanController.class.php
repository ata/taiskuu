<?php

class KaryawanController extends ApplicationController
{
    public function __construct()
    {
        parent::__construct();
        $this->menu = array(
            array('label'=>'Daftar Karyawan','url'=>'karyawan/index'),
            array('label'=>'Tambah Karyawan','url'=>'karyawan/add')
        );
    }
    public function index()
    {
        $this->listKaryawan = Karyawan::m()->all();
        
    }
    public function detail()
    {
        $this->karyawan = Karyawan::m()->find($this->params['id']);
    }
    public function add()
    {
        $form = new FormModel(new Karyawan(),'karyawan/save');
        $this->form = $form;
    }
    public function edit()
    {
        $karyawan = Karyawan::m()->find($this->params['id']);
        $form = new FormModel($karyawan,'karyawan/save',FormModel::EDIT);
        $this->form = $form;
    }
    public function save()
    {
        $karyawan = new Karyawan($_POST['Karyawan']);
        $karyawan->save();
        $this->redirect('karyawan/index');
    }
    
    public function delete()
    {
        Karyawan::m()->delete($this->params['id']);
        $this->redirect('karyawan/index');
    }
}