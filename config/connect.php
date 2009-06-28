<?php
class Connection{
	public static function getInstance(){
		return new PDO("mysql:host=localhost;dbname=perpus",'root','rahasia');
	} 
}
