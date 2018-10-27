<?php 

/*echo "<pre>";
var_dump($_POST);
var_dump($_FILES);*/
//die();

include_once '../../../vendor/autoload.php';

use App\Admin\Employee\Employee;
use App\Helper;

$employee = new Employee();
$helper   = new Helper();


if(!empty($_FILES['photo'])){
	$_POST['image'] = $helper->image_upload();
}

$_POST['employee_id'] = '181004';

$employee->set($_POST)->insert_employee();

/*echo "<pre>";
var_dump($data);*/


