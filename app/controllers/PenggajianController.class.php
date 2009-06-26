<?php
class PenggajianController extends ApplicationController
{
    protected $models = array('Gaji','Periode','Karyawan','Setting');
    public function __construct()
    {
        parent::__construct();
        $this->menu = array(
            array('label'=>'Gaji','url'=>'penggajian'),
            array('label'=>'Setting','url'=>'penggajian/setting'),
        );
    }
    
    
    public function index()
    {
        
        //$this->listPeriode = Periode::m()->all("start desc");
        $paginate = new Paginate(new Periode(),Html::url('penggajian/index'));
        $paginate->setQuery("from Periode order by start desc");
        $this->paginate = $paginate;
        
    }
    
    
    public function gaji()
    {
        $p = $this->params['periode_id'];
        $this->periode = Periode::m()->find($p);
        //$this->listGaji = Gaji::m()->findQuery("from Gaji where periode_id = $p",
        //                                       array($this->params['periode_id']));
        $paginate = new Paginate(new Gaji(),Html::url('penggajian/gaji',array('periode_id' => $this->params['periode_id'])));
        $paginate->setQuery("from Gaji where periode_id = $p");
        $this->paginate = $paginate;
    }
    public function detail()
    {
        $this->gaji = Gaji::m()->find($this->params['id']);
    }
    public function proses()
    {
        
        $gaji = Gaji::m()->find($this->params['id']);
        $form = new Form('gaji','penggajian/save');
        $form ->hidden('id',array('value' => $gaji->id))
            ->hidden('periode_id',array('value' => $gaji->periode_id))
            ->hidden('karyawan_id',array('value' => $gaji->karyawan_id))
            ->text('jumlah_kehadiran',array('value' => $gaji->jumlah_kehadiran))
            ->text('jumlah_sakit',array('value' => $gaji->jumlah_sakit))
            ->text('jumlah_izin',array('value' => $gaji->jumlah_izin))
            ->text('jumlah_jam_lembur_biasa',array('value' => $gaji->jumlah_jam_lembur_biasa))
            ->text('jumlah_jam_lembur_libur',array('value' => $gaji->jumlah_jam_lembur_libur))
            ->text('jumlah_jam_lembur_minggu',array('value' => $gaji->jumlah_jam_lembur_minggu))
            ->text('potongan',array('value' => $gaji->potongan))
            ->text('bonus',array('value' => $gaji->bonus))
            ->end('Submit');
        $this->form = $form;
        $this->periode = Periode::m()->find($this->params['periode']);
    }
    public function save()
    {
        $setting = Setting::m()->first();
        //gaji = gajipokok / 172  
        $gaji =  new Gaji($_POST['gaji']);
        $karyawan = $gaji->karyawan;
       // var_dump($karyawan);
        $gaji->fromArray($karyawan->attributes);
        $gaji_perjam = $gaji->gaji_pokok / 172;
        $gaji->uang_lembur = $gaji->jumlah_jam_lembur_biasa * $setting->upah_lembur_hari_biasa * $gaji_perjam;
        $gaji->uang_lembur += $gaji->jumlah_jam_lembur_libur * $setting->upah_lembur_hari_libur * $gaji_perjam;
        $gaji->uang_lembur += $gaji->jumlah_jam_lembur_minggu * $setting->upah_lembur_hari_minggu * $gaji_perjam;
        $gaji->uang_transport = $karyawan->transport_per_hari * $gaji->jumlah_kehadiran;
        $gaji->uang_makan = $setting->uang_makan_harian * $gaji->jumlah_kehadiran;
        //$gaji->potongan  = $gaji->jumlah_sakit * $setting->potongan_per_ketidakhadiran_sakit * $gaji_perjam;
        //$gaji->potongan  += $gaji->jumlah_izin * $setting->potongan_per_ketidakhadiran_izin * $gaji_perjam;
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
        
        $this->redirect('penggajian/gaji',array('periode_id'=>$gaji->periode_id));
    }
    public function delete()
    {
        Gaji::m()->delete($this->params['id']);
        $this->redirect('penggajian/index',array('periode'=>$this->params['periode']));
    }
    public function setting()
    {
        $this->message = "";
        if(isset($_POST['Setting'])) {
            $setting = new Setting($_POST['Setting']);
            $setting->save();
            $this->message = "Setting telah di simpan";
        }
        $this->form = new FormModel(Setting::m()->first(),'penggajian/setting',FormModel::EDIT);
    }
    
    public function periode_add()
    {
        //$this->form = new FormModel(new Periode(),'penggajian/periode_save');
        $form = new Form('Periode','penggajian/periode_save');
        $this->form = $form->date("start")->date("end")->end('Add');
        
    }
    public function periode_edit()
    {
        $this->form = new FormModel(Periode::m()->find($this->params['id']),
                                    'penggajian/periode_save',
                                    FormModel::EDIT
                                    );
    }
    public function periode_save()
    {
        
        $periode = new Periode($_POST['Periode']);
        
        if(!isset($_POST['Periode']['id'])){
            $periode->query("update Periode set aktif = 0");
            $periode->aktif = 1;
        }
        $periode->save();
        
        if(!isset($_POST['Periode']['id'])){
            $listKaryawan = Karyawan::m()->findQuery("from Karyawan where aktif = 1");
            foreach($listKaryawan as $k){
                $gaji = new Gaji();
                $gaji->periode_id = $periode->id;
                $gaji->karyawan_id = $k->id;
                $gaji->fromArray($k->attributes);
                $gaji->save();
            }
        }
        
        $this->redirect('penggajian');
    }
    public function periode_delete()
    {
        Periode::m()->delete($this->params['id']);
        Gaji::m()->query("delete from Gaji where periode_id = ?",array($this->params['id']));
        $this->redirect('penggajian');
    }
    
}