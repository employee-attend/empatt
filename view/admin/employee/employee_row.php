<?php 
	
	include_once '../../../vendor/autoload.php';

	use App\Admin\Employee\Employee;

	$employee = new Employee();
	$id = $_POST['id'];

	$data = $employee->edit_employee($id);
	echo json_encode($data);
	







	//*/
/*echo "<pre>";
var_dump($_POST);

	include '../includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, employees.id as empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}*/



