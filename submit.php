<?php
    session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST['id'];

        $updateQuery = "UPDATE borrowing_acts SET returned = '1' WHERE id = $id";
        mysqli_query($connect, $updateQuery);

        if ($connect->query($updateQuery) === TRUE) {
        echo "Value inserted successfully!";
        } else {
            echo "Error inserting value: " . $connect->error;
        }
        $connect->close();
    }

