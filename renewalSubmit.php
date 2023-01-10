<?php
    session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST['id'];
        $new_rDate = $_POST['ndate'];
        $new_rDate = mysqli_real_escape_string($connect, $new_rDate);
       
        $upQuery = "UPDATE borrowing_acts SET return_date= '$new_rDate', req_sent = 0 WHERE id = '$id' ";

        $result = mysqli_query($connect, $upQuery);
  
    }