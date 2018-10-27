<?php 

namespace App;
use PDO;
use PDOException;

class Connection{

	protected $con;
	private $user = 'root';
	private $pass = '';

	public function __construct(){
		try {

			$this->con = new PDO('mysql:host=localhost;dbname=employee_attend;charset=utf8', $this->user, $this->pass);
			
		} catch (PDOException $e) {
			echo "Error: ".$e->getMessage()."<br>";
			die();
		}
	}
}