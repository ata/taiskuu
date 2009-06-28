<?php
include MODEL_DIR . 'buku.php';
class BukuController{
	private $buku = null;
	public function __construct(){
		$this->buku = new Buku();
	}
	public function index(){
		include VIEW_DIR .'layout/header.php';
		$bukuList = $this->buku->findAll();
		include VIEW_DIR .'buku/index.php';
		include VIEW_DIR .'layout/footer.php';
	}
	public function delete($id = null){
		$this->buku->delete($id);
		Core::redirect('buku/index');
	}
	public function new_buku(){
		include VIEW_DIR .'layout/header.php';
		include VIEW_DIR .'buku/new_buku.php';
		include VIEW_DIR .'layout/footer.php';
	}
	public function edit($id = null){
		$buku = $this->buku->findById($id);
		include VIEW_DIR .'layout/header.php';
		include VIEW_DIR .'buku/edit.php';
		include VIEW_DIR .'layout/footer.php';
	}
	public function add(){
		$this->buku->save($_POST);
		Core::redirect('buku/index');
	}
	public function update(){
		$this->buku->update($_POST);
		Core::redirect('buku/index');
	}
	
}