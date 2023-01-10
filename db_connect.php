<?php
        $dbservername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "book_borrowing_system-1";


        if(!$connect = mysqli_connect($dbservername,$dbusername,$dbpassword,$dbname))
        {

            die("failed to connect!");
        }
