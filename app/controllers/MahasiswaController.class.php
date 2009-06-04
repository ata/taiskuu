<?php



class MahasiswaController extends Controller
{
    function index()
    {
        $ata = new Mahasiswa();
        $ata->nama = 'Ahmad Tanwir';
        $ata->nim = '0608587';
        $ata->save();
    }
}
