<?php
  
  if(!isset($_SESSION)){
    session_start();
  }
   ?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>Employee Attendance System</title>
    <base href="http://localhost/empatt/">
  	<!-- Tell the browser to be responsive to screen width -->
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<!-- Bootstrap 3.3.7 -->
  	<link rel="stylesheet" href="assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
  	<!-- Font Awesome -->
  	<link rel="stylesheet" href="assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="assets/admin/dist/css/AdminLTE.min.css">
  	

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- jQuery 3 -->
    <script src="assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- <script src="view/admin/empattend/attend.js" ></script> -->


  	<style type="text/css">
  		.mt20{
  			margin-top:20px;
  		}
  		.result{
  			font-size:20px;
  		}
      .bold{
        font-weight: bold;
      }
  	</style>
</head>