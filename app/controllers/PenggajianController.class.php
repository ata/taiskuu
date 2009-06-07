<?php
class PenggajianController extends ApplicationController
{
    protected $models = array('Gaji','Periode','Karyawan','Setting');
    public function __construct()
    {
        parent::__construct();
        $this->menu = array(
            array('label'=>'Gaji periode ini','url'=>'penggajian'),
            array('label'=>'Jam Lembur','url'=>'penggajian/jam_lembur'),
            array('label'=>'Periode', 'url'=>'penggajian/periode')
        );
    }
    public function index()
    {
        if(isset($this->params['periode'])) {
            $this->periode = Periode::m()->find($this->params['periode']);
        } else {
            $this->periode = Periode::m()->last('periode');
        }
        $this->listPeriode = Periode::m()->all();
    }
    public function detail()
    {
        $this->gaji = Gaji::m()->find($this->params['id']);
    }
    public function add()
    {
        
        $form = new Form('gaji','penggajian/save');
        $form->hidden('periode_id',array('value' => $this->params['periode']))
            ->select('karyawan_id',Karyawan::m()->select('nama_lengkap'))
            ->text('jumlah_kehadiran')
            ->text('jumlah_sakit')
            ->text('jumlah_izin')
            ->text('jumlah_jam_lembur_biasa')
            ->text('jumlah_jam_lembur_libur')
            ->text('jumlah_jam_lembur_minggu')
            ->text('bonus')
            ->end('add');
        $this->form = $form;
        $this->periode = Periode::m()->find($this->params['periode']);
    }
    public function save()
    {
        $setting = Setting::m()->first();
        //gaji = gajipokok / 172  
        $gaji =  new Gaji($_POST['gaji']);
        
        $karyawan = $gaji->karyawan;
        $gaji->fromArray($karyawan->attributes);
        $gaji_perjam = $gaji->gaji_pokok / 172;
        $gaji->uang_lembur = $gaji->jumlah_jam_lembur_biasa * $setting->upah_lembur_hari_biasa * $gaji_perjam;
        $gaji->uang_lembur += $gaji->jumlah_jam_lembur_libur * $setting->upah_lembur_hari_libur * $gaji_perjam;
        $gaji->uang_lembur += $gaji->jumlah_jam_lembur_minggu * $setting->upah_lembur_hari_minggu * $gaji_perjam;
        $gaji->uang_transport = $karyawan->transport_per_hari * $gaji->jumlah_kehadiran;
        $gaji->uang_makan = $setting->uang_makan_harian * $gaji->jumlah_kehadiran;
        $gaji->potongan  = $gaji->jumlah_sakit * $setting->potongan_per_ketidakhadiran_sakit * $gaji_perjam;
        $gaji->potongan  += $gaji->jumlah_izin * $setting->potongan_per_ketidakhadiran_izin * $gaji_perjam;
        $gaji->total_gaji = $gaji->gaji_pokok
                        + $gaji->tunjangan_jabatan
                        + $gaji->tunjangan_keluarga
                        + $gaji->tunjangan_lain
                        + $gaji->uang_lembur
                        + $gaji->uang_transport
                        + $gaji->uang_makan
                        + $gaji->bonus
                        - $gaji->potongan;
        
        //var_dump($gaji);
        $gaji->save();
        
        $this->redirect('penggajian/index',array('periode'=>$gaji->periode_id));
    }
    public function delete()
    {
        Gaji::m()->delete($this->params['id']);
        $this->redirect('penggajian/index',array('periode'=>$this->params['periode']));
    }
    
}