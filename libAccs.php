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
        $l_userid = $_POST['userid'];
        $l_userpword = $_POST['userpword'];
        $l_userpword2 = $_POST['userpword2'];
        $l_lname = $_POST['Lname'];
        $l_fname = $_POST['FName'];
        $position = $_POST['position'];

        $l_userid = mysqli_real_escape_string($connect, $l_userid);
        $l_userpword = mysqli_real_escape_string($connect, $l_userpword);
        $l_userpword2 = mysqli_real_escape_string($connect, $l_userpword2);
        $l_lname = mysqli_real_escape_string($connect, $l_lname);
        $l_fname = mysqli_real_escape_string($connect, $l_fname);
        $position = mysqli_real_escape_string($connect, $position);

        if($l_userpword === $l_userpword2){
        $insertQuery = "INSERT INTO users (userid, password, last_name, first_name, position) VALUES ('$l_userid', '$l_userpword', '$l_lname', '$l_fname', '$position');";

            $result = mysqli_query($connect, $insertQuery);

            if ($result) {
                echo "<div class='Msg'><h3>Successfully Added!</h3></div>";
                header('refresh:2');
            } else {
                echo "<div class='Msg'><h3>Something went wrong</h3></div>" . mysqli_error($mysqli);
                header('refresh:2');
            }
        }else{
            echo "<div class='Msg'><h3>Unmatched Password</h3></div>" . mysqli_error($mysqli);
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
        <title>User Accounts</title>
        <link rel="stylesheet" href="dashStyle.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
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
        <h3>Librarian Accounts</h3>
        <?php
         $tbData = "SELECT * FROM users ORDER BY position ASC, last_name ASC";
         $result = $connect->query($tbData);
     
         echo "<div id='sTbl'><table id='table'>";
         echo "<thead><tr>
               <th>Last Name</th>
               <th>First Name</th>
               <th>Position</th>
               <th>Delete</th>
               </thead></tr>";
     
         while ($row = $result->fetch_assoc()) {
             echo "<tr>";
             echo "<td>" . $row["last_name"] . "</td>";
             echo "<td>" . $row["first_name"] . "</td>";
             echo "<td>" . $row["position"] . "</td>";
             echo "<td><input type='checkbox' name='returned' value=".$row['user_no']." class='checkboxValue'>
             <button name='submit'  id=".$row['user_no'].">Submit</button></td>";
             echo "</tr>";
         }
         
         echo "</table></div>";
         //$connect->close();
         ?>
         <button type="button" id="addAcc">Add Account</button>
         <div id="myPopUp" class="modal">
            <form class="modal-content" method="post">
                <span class="close" id="closeBtn">&times;</span>
                <h3>Enter Account Information:</h3>
                
                <div class="labels"> 
                    <label for="userid">User ID:</label>
                    <label for="userpword">User Password:</label>
                    <label for="userpword2">Confirm Password:</label>
                    <label for="Lname">Last Name:</label>
                    <label for="FName">First Name:</label>
                    <label for="position">Position:</label>
                </div>
                <div class="inputs">
                    <input type="text" id="userid"  name="userid" required="">
                    <input type="password" id="userpword"  name="userpword" required="">
                    <input type="password" id="userpword2"  name="userpword2" required="">
                    <input type="text" id="Lname"  name="Lname" required="">
                    <input type="text" id="FName"  name="FName" required="">
                    <input type="text" id="position"  name="position" required="">
                </div>
                <button type="submit" id="submit">Add</button>
            </form>
        </div>
    </div>
    <script>
         $("#table").find("td button").each(function(){
            $(this).click(function(){
                checkB=$(this).siblings("input").first();
                console.log(checkB.val())
                if(checkB.is(":checked")){
                    $.ajax({
                        method: "POST",
                        url: "libDel.php",
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