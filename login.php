<?php 

session_start();

	include_once("db_connect.php");
	include_once("php_functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['id'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from users where userid = '$user_name' limit 1";
			$result = mysqli_query($connect, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password && $user_data['position'] === 'Librarian')
					{

						$_SESSION['userid'] = $user_data['userid'];
						$_SESSION['logged_in'] = true;
						header("Location: dashboard.php");
						die;
					}
				}
			}
			
			echo "<div class='errorMsg'><h3>Wrong User ID or Password!</h3></div>";
			header('refresh:2');
		}else
		{
			echo "<div class='errorMsg'><h3>Wrong User ID or Password!</h3></div>";
			header('refresh:2');
		}
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginStyle.css">
</head>
<body>

    
        <img 
        class="bg"
        src="https://i.guim.co.uk/img/media/d305370075686a053b46f5c0e6384e32b3c00f97/0_50_5231_3138/master/5231.jpg?width=1200&quality=85&auto=format&fit=max&s=dfc589d3712148263b1dd1cb02707e91" alt="">
        <div id="header">
            <h2>Book Borrowing System!</h2>
        </div>
        <div class="form">
            <form method="post">
                <label for="userId">User ID: </label>
                <input type="text" name="id" id="userId" required="">
                <label for="pword">Password: </label>
                <input type="password" name="password" id="pword" required="">
                <input type="submit" name="login" id="loginbtn" value="Login">
            </form>
        </div>
    
  
</body>
</html>