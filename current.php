<?php
    session_start();
    include_once("db_connect.php");
    include_once("php_functions.php");
    $userdata = check_login($connect);

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
    <title>Currently Borrowed</title>
    <link rel="stylesheet" href="dashStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
<div class="sidebar">
        <h3>Quick Links</h3>
        <br><hr><br>
        <div class="qlinks"><a href="dashboard.php">Dashboard</a></div>
        <div class="qlinks"><a href="studList.php">Student List</a></div>
        <div class="qlinks"><a href="violators.php">Violators List</a></div>
        <div class="qlinks"><a href="renewal.php">Renewal Request</a></div>
         <?php 
            $adminChck = "Admin";
            if ($userdata['position'] == $adminChck){
                echo '<div class="qlinks"><a id="userAccs" href="#">User Accounts</a></div>
                        <div class="subdivs" id="stud"><a id= "studentaccounts" href="studAccs.php">Student Accounts</a></div>
                        <div class="subdivs" id="lib"><a id="libaccounts" href="libAccs.php">Librarian Accounts</a></div>';
            }
        ?>
        <button type="button" id="logout" onclick="location.href='logout.php'">Logout</button>
    </div>
    <div id="header">
           <img src="logo.png" alt="" id="logo">
            <h2 id="banner">Book Borrowing System!</h2>
    </div>
    <div class="whole">
    <h1>Currently Borrowed Books</h1>
    <?php
         $tbData = "SELECT * FROM borrowing_acts  WHERE status = 0 && lost = 0;";
         $result = $connect->query($tbData);
     
         echo "<div id='dataTbl'><table id='table'>";
         echo "<thead><tr>
               <th>Student Number</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Book Title</th>
               <th>Date Borrowed</th>
               <th>Return Date</th>
               <th>Returned</th>
               <th>Damaged/Lost</th>
               </thead></tr>";
     
         while ($row = $result->fetch_assoc()) {
            $current_date = date('Y-m-d');
            if ($row["return_date"] == $current_date || $row["return_date"] < $current_date ) {
            $color = "red";
            $weight = "bold";
            } else {
                $color = "green";
                $weight = 'normal';
            }
             echo "<tr id=" . $row["id"].">";
             echo "<td style='color: $color; font-weight: $weight;'>" . $row["stud_num"] . "</td>";
             echo "<td style='color: $color; font-weight: $weight;'>" . $row["b_first_name"] . "</td>";
             echo "<td style='color: $color; font-weight: $weight;'>" . $row["b_last_name"] . "</td>";
             echo "<td style='color: $color; font-weight: $weight;'>" . $row["book_title"] . "</td>";
             echo "<td style='color: $color; font-weight: $weight;'>" . $row["date_borrowed"] . "</td>";
             echo "<td style='color: $color; font-weight: $weight;'>" . $row["return_date"] . "</td>";
             echo "<td >
             <input type='checkbox' name='status' value=".$row['id']." class='checkboxValue'>
             <button class='rButton' name='submit'  id=".$row['id'].">Submit</button>
            </td>";
            echo "<td>
             <input type='checkbox' name='lost' value=".$row['id']." class='checkboxValue'>
             <button class='lButton' name='submit2'  id=".$row['id'].">Submit</button>
            </td>";
             echo "</tr>";


         }
         
         echo "</table></div>";
        
         $connect->close();
         
    ?>
    </div>
<script>
    
    $("#table").find("td .rButton").each(function(){
        $(this).click(function(){
            checkB=$(this).siblings("input").first();
            //console.log(checkB.val())
            if(checkB.is(":checked")){
                $.ajax({
                    method: "POST",
                    url: "submit.php",
                    data: {
                        id: checkB.val()
                    },
                    success: function(){
                        window.location.reload();
                    }

                })
            }
            
            
        })
        
    })

    $("#table").find("td .lButton").each(function(){
        $(this).click(function(){
            checkL=$(this).siblings("input").first();
            //console.log(checkL.val())
            if(checkL.is(":checked")){
                $.ajax({
                    method: "POST",
                    url: "submitLost.php",
                    data: {
                        id: checkL.val()
                    },
                    success: function(){
                        window.location.reload();
                    }

                })
            }
            
            
        })
        
    })
</script>
<script src="script.js"></script>
</body>
</html>