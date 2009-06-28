<?php
include CONFIG_DIR . 'connect.php';
class Pengunjung{
	private $db = null;

	public function __construct(){
		$this->db = Connection::getInstance();
	}
	
	public function findAll(){
		$st = $this->db->prepare("select * from pengunjung");
		$st->execute();
		return $st->fetchAll(PDO::FETCH_ASSOC);
	}
	public function findById($id){
		$st = $this->db->prepare("select * from pengunjung where id = :id");
		$st->bindParam('id',$id);
		$st->execute();
		return $st->fetch(PDO::FETCH_ASSOC);
		
	}
	public function delete($id){
		$st = $this->db->prepare("delete from pengunjung where id = :id");
		$st->bindParam('id',$id);
		$st->execute();
	}
	public function update($pengunjung){
		$st = $this->db->prepare("update pengunjung set nama = :nama , email = :email , situs = :situs where id = :id ");
		$st->bindParam('id',$pengunjung['id']);
		$st->bindParam('nama',$pengunjung['nama']);
		$st->bindParam('email',$pengunjung['email']);
		$st->bindParam('situs',$pengunjung['situs']);
		$st->execute();
	}
	public function save($pengunjung){
		$st = $this->db->prepare("insert into pengunjung(nama, email, situs) values(:nama, :email, :situs)");
		$st->bindParam('nama',$pengunjung['nama']);
		$st->bindParam('email',$pengunjung['email']);
		$st->bindParam('situs',$pengunjung['situs']);
		$st->execute();
	}
}