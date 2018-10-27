<?php 

namespace App;

if(!isset($_SESSION)){
	session_start();
}

use PDO;
use PDOException;

class Helper extends connection
{
	public function image_upload(){
		try {

			$image = $_FILES['photo']['name'];
			$tmp_name = $_FILES['photo']['tmp_name'];
			$img_size = $_FILES['photo']['size'];

			$name = substr(md5(time()), '0', '10');
			$data = explode('.', $image);
			$image = $name.'.'.end($data);

			//permitted image file extension
			$permitted = array('jpg', 'jpeg', 'png');
			$data2 = explode('.', $image);
			$file_ext_name = strtolower(end($data2));

			// image size and file extension validation required here....

			$moving_file = '../uploads/employee/'.$image;
			move_uploaded_file($tmp_name, $moving_file);

			return $image;
			
		} catch (PDOException $e) {
			echo "Error: ".$e->getMessage()."<br>";
			die();
		}
	}
}