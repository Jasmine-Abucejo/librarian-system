<?php

    session_start();
    include_once("db_connect.php");
    include_once("php_functions.php");
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
    <title>Renewal Request</title>
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
    <h1>Renewal Requests</h1>
    <?php
        $sel = "SELECT*FROM borrowing_acts WHERE req_sent = '1'";
	    $result = $connect->query($sel);

        echo "<div id='dataTbl'><table id='table'>";
        echo "<thead>
            <tr>
               <th>Student Number</th>
               <th>Student Name</th>
               <th>Book Title</th>
               <th>Date Borrowed</th>
               <th>Return Date</th>
            </tr>
            </thead>";

    if (mysqli_num_rows($result) > 0) {
	    while ($row = $result->fetch_assoc()) {
		    echo "<tr id=" . $row['id']. ">
		    <td class='snum'>" . $row['stud_num'] . "</td>
		    <td>" . $row['b_first_name'] . " ".$row['b_last_name']."</td>
            <td class='btitle'>" . $row['book_title'] . "</td>
            <td>" . $row['date_borrowed'] . "</td>
		    <td>" . $row['return_date'] . "</td>
		    <td>
			    <button class='accept'>Accept</button>
		    </td>
            <td>
			    <button class='decline'>Decline</button>
		    </td>";
		}
    }else{
	echo "<td><h3>No Request</h3></td></tr>";
    }      
    echo "</table></div>";     
     $connect->close();
    ?>
    <div id="myPopUp" class="modal">
            <form action="" class="modal-content" method="post">
                <div>
                    <span class="close" id="closeBtn">&times;</span>
                    <h3>Enter New Return Date:</h3>
                </div>
                <div id="lndate">
                    <label for="newRDate">New Return Date:</label>
                </div>
                <div id="forNdate">
                    <input type="date" id="newRDate"  name="nrdate" required="">
                </div>
                <button type="submit" id="submit">OK</button>
            </form>
    </div>
    <script>
        $("#table").find("td .accept").each(function(){
            $(this).click(function(){
                var row = $(this).closest("tr");
                var rowId = row.attr("id");
                 console.log(rowId)
                let modal = document.getElementById("myPopUp");
                        modal.style.display = "block";
                let close = document.getElementById("closeBtn")
                let modalClose = document.getElementById("myPopUp");
                close.addEventListener("click", function(){
                        modalClose.style.display = "none"
                })
                
                let subButton = document.getElementById("submit");
                subButton.addEventListener("click", function(){
                    console.log(newDate);
                    var newDate = document.getElementById("newRDate").value;
                    if (newDate){ 
                    $.ajax({
                    method: "POST",
                    url: "renewalSubmit.php",
                    data: {
                        id: rowId,
                        ndate: newDate
                    },
                    dataType: "json",
                    success: function(){
                        //window.location.reload();
                        //console.log(rowId)
                        row.remove();
                    }
                    })
                 }
                })
                
        })
    })

    $("#table").find("td .decline").each(function(){
            $(this).click(function(){
                var row = $(this).closest("tr");
                var rowId = row.attr("id");
                console.log(rowId)
                 $.ajax({
                    method: "POST",
                    url: "renewalDecline.php",
                    data: {
                        id: rowId,
                    },
                    //dataType: "json",
                    success: function(){
                        //window.location.reload();
                        //console.log("success")
                        row.remove();
                    },
                    
                    })
            })
        })
    </script>
    <script src="script.js"></script>
</body>
</html>