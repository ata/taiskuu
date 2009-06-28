<?php
include MODEL_DIR . 'pengunjung.php';
class PengunjungController{
	private $pengunjung = null;
	public function __construct(){
		$this->pengunjung = new Pengunjung();
	}
	public function index(){
		$listPengunjung = $this->pengunjung->findAll();
		include VIEW_DIR .'layout/header.php';
		include VIEW_DIR .'pengunjung/index.php';
		include VIEW_DIR .'layout/footer.php';
	}
	public function add(){
		$this->pengunjung->save($_POST);
		Core::redirect('pengunjung/index');
	}
	public function delete($id = null){
		$this->pengunjung->delete($id);
		Core::redirect('pengunjung/index');
	}
	
}