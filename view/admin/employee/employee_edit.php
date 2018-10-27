<?php 

echo "<pre>";
var_dump($_POST);

include_once '../../../vendor/autoload.php';

use App\Admin\Employee\Employee;

$employee = new Employee();

$data = $employee->set($_POST)->employee_update();

echo "<pre>";
var_dump($data);

echo json_encode($data);