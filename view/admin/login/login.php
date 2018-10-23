<?php
	
	include_once '../../../vendor/autoload.php';

	use App\Admin\Login\Login;

	$login = new Login();

	$login->set($_POST)->adminLogin();

	/*echo "<pre>";
	var_dump($data);
*/

