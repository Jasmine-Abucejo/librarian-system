<?php
    session_start();
    include_once("db_connect.php");
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Redirect the user to the login page
    header('Location: login.php');
    exit;
    }
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="dashStyle.css">
</head>
<body>
    <div class="sidebar">
            <h3>Quick Links</h3>
            <br><hr><br>
            <div class="qlinks"><a href="dashboard.php">Dashboard</a></div>
            <div class="qlinks"><a href="current.php">Currently Borrowed</a></div>
            <div class="qlinks"><a href="violators.php">Violators List</a></div>
        </div>
    <div id="header">
            <img src="logo.png" alt="" id="logo">
            <h2 id="banner">Book Borrowing System!</h2>
    </div>
    <div class="whole">
    <h1>Registered Students</h1>
    <?php
         $tbData = "SELECT * FROM student_users ORDER BY department ASC, last_name ASC";
         $result = $connect->query($tbData);
     
         echo "<div id='dataTbl'><table cellspacing='20'>";
         echo "<tr>
                <th>Student Number</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Course</th>
               <th>Year</th>
               <th>Section</th>
               <th>Department</th>
               </tr>";
     
         while ($row = $result->fetch_assoc()) {
             echo "<tr>";
             echo "<td>" . $row["stud_num"] . "</td>";
             echo "<td>" . $row["first_name"] . "</td>";
             echo "<td>" . $row["last_name"] . "</td>";
             echo "<td>" . $row["course"] . "</td>";
             echo "<td>" . $row["year"] . "</td>";
             echo "<td>" . $row["section"] . "</td>";
             echo "<td>" . $row["department"] . "</td>";
             echo "</tr>";
         }
         
         echo "</table></div>";
         $connect->close();

    ?>
    </div>
</body>
</html>