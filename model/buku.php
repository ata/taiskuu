<?php
include CONFIG_DIR . 'connect.php';
class Buku{
	private $db = null;

	public function __construct(){
		$this->db = Connection::getInstance();
	}
	
	public function findAll(){
		$st = $this->db->prepare("select * from buku");
		$st->execute();
		return $st->fetchAll(PDO::FETCH_ASSOC);
	}
	public function findById($id){
		$st = $this->db->prepare("select * from buku where id = :id");
		$st->bindParam('id',$id);
		$st->execute();
		return $st->fetch(PDO::FETCH_ASSOC);
		
	}
	public function delete($id){
		$st = $this->db->prepare("delete from buku where id = :id");
		$st->bindParam('id',$id);
		$st->execute();
	}
	public function update($buku){
		$st = $this->db->prepare("update buku set judul = :judul , pengarang = :pengarang where id = :id ");
		$st->bindParam('id',$buku['id']);
		$st->bindParam('judul',$buku['judul']);
		$st->bindParam('pengarang',$buku['pengarang']);
		$st->execute();
	}
	public function save($buku){
		$st = $this->db->prepare("insert into buku(judul, pengarang) values(:judul, :pengarang)");
		$st->bindParam('judul',$buku['judul']);
		$st->bindParam('pengarang',$buku['pengarang']);
		$st->execute();
	}
}