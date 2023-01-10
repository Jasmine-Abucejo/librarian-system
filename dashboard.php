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
    
    if($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $b_snum = $_POST['snum'];
        $b_fname = $_POST['fname'];
        $b_lname = $_POST['lname'];
        $bookName = $_POST['Bname'];
        $Rdate = $_POST['Rdate'];
        $Bdate = date('m/d/Y h:i A');

        $b_snum = mysqli_real_escape_string($connect, $b_snum);
        $b_fname = mysqli_real_escape_string($connect, $b_fname);
        $b_lname = mysqli_real_escape_string($connect, $b_lname);
        $bookName = mysqli_real_escape_string($connect, $bookName);
        $Rdate = mysqli_real_escape_string($connect, $Rdate);

        $checkQuery = "SELECT * FROM student_users WHERE stud_num = '$b_snum' AND first_name = '$b_fname' AND last_name = '$b_lname'";
        $checkResult = mysqli_query($connect,$checkQuery);
        if (mysqli_num_rows($checkResult) > 0){
            $insertQuery = "INSERT INTO borrowing_acts (stud_num, b_first_name, b_last_name, book_title, date_borrowed, return_date) VALUES ('$b_snum', '$b_fname', '$b_lname', '$bookName', NOW(), '$Rdate');";

            $result = mysqli_query($connect, $insertQuery);

            if ($result) {
                echo "<div class='Msg'><h3>Successfully Added!</h3></div>";
                header('refresh:2');
            } else {
                echo "<div class='Msg'><h3>Something went wrong</h3></div>" . mysqli_error($mysqli);
                header('refresh:2');
            }
        } else{
            echo "<div class='Msg'><h3>Account Doesn't Exist</h3></div>";
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashStyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
</head>
<body>
    <div class="sidebar">
        <h3>Quick Links</h3>
        <br><hr><br>
        <div class="qlinks"><a href="current.php">Currently Borrowed</a></div>
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
    <div class="mainScrn">
        <?php
            $current_date = date('Y-m-d');
            $dateCheck = "SELECT * FROM borrowing_acts WHERE return_date = '$current_date' && status = 0";
            $dateResult = mysqli_query($connect, $dateCheck);
            if (mysqli_num_rows($dateResult) > 0) {
                echo '<div id="notifParent"><p id="notifModal">There are books due today!
                </p></div>';
            }
            //$connect->close();
        ?>
        
        <br><br>
        <h1 id="date"></h1><br>
        <h2>Today's Borrowers</h2>
        <div class="bBox">
            <?php
                $Bdata = "SELECT * FROM `borrowing_acts` WHERE DATE(date_borrowed) = CURDATE();";
                $tbResult = $connect->query($Bdata);

                echo "<div id='bDataTbl'><table cellspacing='10'>";
                echo "<thead><tr>
               <th>Student Number</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Book Title</th>
               <th>Date/Time Borrowed</th>
               <th>Return Date</th>
               </thead></tr>";

               while ($row = $tbResult->fetch_assoc()) {
                echo "<tr id=" . $row["id"].">";
                echo "<td>" . $row["stud_num"] . "</td>";
                echo "<td>" . $row["b_first_name"] . "</td>";
                echo "<td>" . $row["b_last_name"] . "</td>";
                echo "<td>" . $row["book_title"] . "</td>";
                echo "<td>" . $row["date_borrowed"] . "</td>";
                echo "<td>" . $row["return_date"] . "</td>";
                echo "</tr>";
            }
            
            echo "</table></div>";

            ?>
        </div>
        <button type="button" id="addBtn">Add Entry</button>
        <div id="myPopUp" class="modal">
            <form class="modal-content" method="post">
                <span class="close" id="closeBtn">&times;</span>
                <h3>Enter Borrowing Information:</h3>
                
                <div class="labels"> 
                    <label for="borrowerSnum">Borrower Student Number:</label>
                    <label for="borrowerFname">Borrower First Name:</label>
                    <label for="borrowerLname">Borrower Last Name:</label>
                    <label for="bookName">Book Title:</label>
                    <label for="returnDate">Return Date:</label>
                </div>
                <div class="inputs">
                    <input type="text" id="borrowerSnum"  name="snum" required="">
                    <input type="text" id="borrowerFname"  name="fname" required="">
                    <input type="text" id="borrowerLname"  name="lname" required="">
                    <input type="text" id="bookName"  name="Bname" required="">
                    <input type="date" id="returnDate"  name="Rdate" required="">
                </div>
                <button type="submit" id="submit">OK</button>
            </form>
        </div>
    </div>
    
    <script src="dash.js"></script>
</body>
</html>
