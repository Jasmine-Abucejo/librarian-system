<?php 
session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");

	//$user_data = check_login($connect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <link rel="stylesheet" href="loginStyle.css">
</head>
<body>
<div class="form">
    <h1>Book Borrowing System!</h1>
    <h3>Track book borrowers easier and faster</h3><br><br>
    <a href="login.php">Login</a>
</div>
</body>
</html>