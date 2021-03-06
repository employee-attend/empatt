<?php

namespace App\Admin\Empattend;

if(!isset($_SESSION)){
	session_start();
}

use App\Connection;
use PDO;
use PDOException;

class Empattend extends Connection
{
	public function set($data = array()){
		if(array_key_exists('employee', $data)){
			$this->employee = $data['employee'];
		}
		if(array_key_exists('status', $data)){
			$this->status = $data['status'];
		}

		return $this;
	}

	public function attendEmployee(){
		try {

		$output = array('error'=>false);


		$employee = $this->employee;;
		$status   = $this->status;

		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		//$query = $conn->query($sql);
		$query = $this->con->prepare($sql);
		$query = $query->execute();

		if($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];

			$date_now = date('Y-m-d');

			if($status == 'in'){
				$sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
				$query = $this->con->prepare($sql);
				$query = $query->execute();
				if($query->rowCount() > 0){
					$output['error'] = true;
					$output['message'] = 'You have timed in for today';
				}
				else{
					//updates
					$sched = $row['schedule_id'];
					$lognow = date('H:i:s');
					$sql = "SELECT * FROM schedules WHERE id = '$sched'";
					//$squery = $conn->query($sql);
					//$srow = $squery->fetch_assoc();

					$query = $this->con->prepare($sql);
					$srow = $query->execute();

					$logstatus = ($lognow > $srow['time_in']) ? 0 : 1;
					//
					$sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', NOW(), '$logstatus')";

					$query = $this->con->prepare($sql);
					$stmt = $query->execute();

					if($stmt){
						$output['message'] = 'Time in: '.$row['firstname'].' '.$row['lastname'];
					}
					else{
						$output['error'] = true;
						$output['message'] = $conn->error;
					}
				}
			}
			else{
				$sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
				//$query = $conn->query($sql);
				$query = $this->con->prepare($sql);
				$query = $query->execute();
				if($query->rowCount() < 1){
					$output['error'] = true;
					$output['message'] = 'Cannot Timeout. No time in.';
				}
				else{
					$row = $query->fetch(PDO::FETCH_ASSOC);
					if($row['time_out'] != '00:00:00'){
						$output['error'] = true;
						$output['message'] = 'You have timed out for today';
					}
					else{
						
						$sql = "UPDATE attendance SET time_out = NOW() WHERE id = '".$row['uid']."'";
						$query = $this->con->prepare($sql);
						$stmt = $query->execute();
						if($stmt){
							$output['message'] = 'Time out: '.$row['firstname'].' '.$row['lastname'];

							$sql = "SELECT * FROM attendance WHERE id = '".$row['uid']."'";
							//$query = $conn->query($sql);
							//$urow = $query->fetch_assoc();
							$query = $this->con->prepare($sql);
							$query = $query->execute();
							$urow = $query->fetch(PDO::FETCH_ASSOC);

							$time_in = $urow['time_in'];
							$time_out = $urow['time_out'];

							$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
							//$query = $conn->query($sql);
							//$srow = $query->fetch_assoc();
							$query = $this->con->prepare($sql);
							$query = $query->execute();
							$srow = $query->fetch(PDO::FETCH_ASSOC);

							if($srow['time_in'] > $urow['time_in']){
								$time_in = $srow['time_in'];
							}

							if($srow['time_out'] < $urow['time_in']){
								$time_out = $srow['time_out'];
							}

							$time_in = new DateTime($time_in);
							$time_out = new DateTime($time_out);
							$interval = $time_in->diff($time_out);
							$hrs = $interval->format('%h');
							$mins = $interval->format('%i');
							$mins = $mins/60;
							$int = $hrs + $mins;
							if($int > 4){
								$int = $int - 1;
							}

							$sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '".$row['uid']."'";
							//$conn->query($sql);
							$query = $this->con->prepare($sql);
							$query = $query->execute();
						}
						else{
							$output['error'] = true;
							$output['message'] = "hi, not found..."; //$conn->error;
						}
					}
					
				}
			}
		}
		else{
			$output['error'] = true;
			$output['message'] = 'Employee ID not found';
		}
		
	
	return $output;

			
		} catch (PDOException $e) {
			echo "Error: ".$e->getMessage()."<br>";
			die();
		}
	}


}