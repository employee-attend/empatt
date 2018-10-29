<?php 

namespace App\Admin\Schedule;

if(!isset($_SESSION)){
	session_start();
}

use App\Connection;
use PDO;
use PDOException;

class Schedule extends Connection
{
	public function show_schedule(){
		try {

			$stmt = $this->con->prepare("select * from schedules ");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		} catch (PDOException $e) {
			echo "Error: ".$e->getMessage()."<br>";
			die();
		}
	}
}