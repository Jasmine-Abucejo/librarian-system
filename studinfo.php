<?php
    session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST['number'];
         $result = mysqli_query($connect, "SELECT stud_num, first_name, last_name, course, year, section, department  FROM student_users WHERE stud_num = '$id'");

  // Fetch the data as an associative array
  $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Return the data as a JSON object
  echo json_encode($data);
        // $selectQuery = "SELECT * FROM student_users WHERE stud_num = '$id'";
        // $result = $connect->query($selectQuery);
        // $row = $result->fetch_assoc();
        // echo json_encode(array("0" => "$row['stud_num']", "1" => "$row['last_name']", "2" => "$row['first_name']", "3" => "$row['course']", "4" => "$row['year']", "5" => "$row['section']", "6" => "$row['department']"));
        //$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //echo json_encode($data);
        //echo $row["Last_name"];
        $connect->close();
    }