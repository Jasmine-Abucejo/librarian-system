<?php
    session_start();
    include_once("db_connect.php");
    include_once("php_functions.php");
    copy_record($connect);
    $userdata = check_login($connect);
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
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
        <title>User Accounts</title>
        <link rel="stylesheet" href="dashStyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="sidebar">
        <h3>Quick Links</h3>
        <br><hr><br>
        <div class="qlinks"><a href="dashboard.php">Dashboard</a></div>
        <div class="qlinks"><a href="current.php">Currently Borrowed</a></div>
        <div class="qlinks"><a href="studList.php">Student List</a></div>
        <div class="qlinks"><a href="violators.php">Violators List</a></div>
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
        <h3>Student Accounts</h3>
        <?php
         $tbData = "SELECT * FROM student_users ORDER BY department ASC, last_name ASC";
         $result = $connect->query($tbData);
     
         echo "<div id='sTbl'><table id='table'>";
         echo "<thead><tr>
                <th>Student Number</th>
               <th>Last Name</th>
               <th>First Name</th>
               <th>Course</th>
               <th>Delete</th>
               </thead></tr>";
     
         while ($row = $result->fetch_assoc()) {
             echo "<tr>";
             echo "<td>" . $row["stud_num"] . "</td>";
             echo "<td>" . $row["last_name"] . "</td>";
             echo "<td>" . $row["first_name"] . "</td>";
             echo "<td>" . $row["course"] . "</td>";
             echo "<td><input type='checkbox' name='returned' value=".$row['id']." class='checkboxValue'>
             <button name='submit'  id=".$row['id'].">Submit</button></td>";
             echo "</tr>";
         }
         
         echo "</table></div>";
         //$connect->close();

    ?>
        
    </div>
    <script>
         $("#table").find("td button").each(function(){
            $(this).click(function(){
                checkB=$(this).siblings("input").first();
                //console.log(checkB.val())
                if(checkB.is(":checked")){
                    $.ajax({
                        method: "POST",
                        url: "studDel.php",
                        data: {
                            id: checkB.val()
                        },
                        success: function(){
                            window.location.reload();
                            //console.log(checkB.val())
                        }

                    })
                }
                
                
            })
            
        })
    </script>
    <script src="script.js"></script>
    </body>
    </html>