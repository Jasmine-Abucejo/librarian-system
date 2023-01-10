<?php
    session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST['id'];

        $delQuery = "DELETE FROM users  WHERE user_no = $id";
        mysqli_query($connect, $delQuery);

        if ($connect->query($delQuery) === TRUE) {
        echo "Account deleted successfully!";
        } else {
            echo "Error deleting account: " . $connect->error;
        }
        $connect->close();
    }