<?php 

session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");

    $current_user_id = $_SESSION['userid'];

    $sql = "SELECT * FROM users WHERE userid = '$current_user_id'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
    // Fetch the user data as an associative array
    $user = mysqli_fetch_assoc($result);
    } else {
    // No user found
    // You may want to redirect the user to an error page or display an error message
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    
</body>
</html>