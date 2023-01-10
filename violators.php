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
    <title>Violators</title>
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
    <h1>Violators List</h1>
    <?php
         $tbData = "SELECT * FROM violators WHERE  Returned = 0;";
         $result = $connect->query($tbData);
     
         echo "<div id='dataTbl'><table id='table'>";
         echo "<thead><tr> 
                <th>Student Number</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Book Title</th>
               <th>Date Borrowed</th>
               <th>Return Date</th>
               <th>Violation Type</th>
               <th>Returned</th>
               </thead></tr>";
     
         while ($row = $result->fetch_assoc()) {
             echo "<tr id=" . $row["id"].">";
             echo "<td id=" . $row["Stud_num"]."><a href='#'>" . $row["Stud_num"] . "</a></td>";
             echo "<td>" . $row["First_name"] . "</td>";
             echo "<td>" . $row["Last_name"] . "</td>";
             echo "<td>" . $row["Book_title"] . "</td>";
             echo "<td>" . $row["Date_borrowed"] . "</td>";
             echo "<td>" . $row["Return_date"] . "</td>";
             if ($row["Lost"] == 1) {
                echo "<td>Damaged/Lost</td>";
            } else {
                echo "<td>Late Return</td>";
            }
             echo "<td>
             <input type='checkbox' name='returned' value=".$row['id']." class='checkboxValue'>
             <button name='submit'  id=".$row['id'].">Submit</button>
            </td>";
             echo "</tr>";
         }
         
         echo "</table></div>";
         $connect->close();

    ?>
    </div>
    <div id="myPopUp" class="modal">
        <div class="modal-content">
        <span class="close" id="closeBtn">&times;</span>
        <h3>Violator Information:</h3>
        <table>
        <tr>
            <th>Student Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course</th>
            <th>Year</th>
            <th>Section</th>
            <th>Department</th>
        </tr>
        <tr id="container">
        </tr>
        </table>
        </div>
    </div>
    <script>
        $("#table").find("td button").each(function(){
            $(this).click(function(){
                checkB=$(this).siblings("input").first();
                //console.log(checkB.val())
                if(checkB.is(":checked")){
                    $.ajax({
                        method: "POST",
                        url: "violatorSubmit.php",
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

        $("#table").find("td a").each(function(){
            $(this).click(function(){
                //console.log($(this).text())
                var studnum = $(this).text();
                $.ajax({
                    method: "POST",
                    url: "studinfo.php",
                    data: {
                        number: studnum
                    },
                    dataType: "json",
                    success: function(response){
                        let modal = document.getElementById("myPopUp");
                        modal.style.display = "block";
                        
                        for (var element in response[0]) {
                        $("#container").append("<td>"+response[0][element]+"</td>");
                         }
                        let close = document.getElementById("closeBtn")
                        close.addEventListener("click", function(){
                        $("#container").empty();
                        let modalClose = document.getElementById("myPopUp");
                        modalClose.style.display = "none"
                        })
                    },
                })
            })
        })
    </script>
    <script src="script.js"></script>
</body>
</html>