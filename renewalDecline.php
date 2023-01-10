<?php
    session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST['id'];

        $upQuery = "UPDATE borrowing_acts SET req_sent = 0 WHERE id = '$id' ";

        $result = mysqli_query($connect, $upQuery);
    }