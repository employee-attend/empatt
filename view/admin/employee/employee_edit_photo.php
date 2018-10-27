<?php 


echo "<pre>";
var_dump($_POST);
var_dump($_FILES);
die();

include_once '../../../vendor/autoload.php';

use App\Admin\Employee\Employee;
use App\Helper;

$employee = new Employee();
$helper   = new Helper();

if(!empty($_FILES['photo'])){
	$_POST['image'] = $helper->image_upload();
}

$data = $employee->set($_POST);


echo "<pre>";
var_dump($data);