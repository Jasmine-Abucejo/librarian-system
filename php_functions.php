<?php

function check_login($connect)
{

	if(isset($_SESSION['userid']))
	{

		$id = $_SESSION['userid'];
		$query = "select * from users where userid = '$id' limit 1";

		$result = mysqli_query($connect,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	header("Location: login.php");
	die;

}

function copy_record($connect)
{
	$current_date = date('Y-m-d');
	$query = "SELECT * FROM borrowing_acts WHERE return_date < $current_date AND returned = 0 AND NOT EXISTS 
	(SELECT * FROM violators WHERE borrowing_acts.stud_num = violators.Stud_num AND borrowing_acts.b_last_name = violators.Last_name 
	AND borrowing_acts.b_first_name = violators.First_name AND borrowing_acts.book_title = violators.Book_title 
	AND borrowing_acts.date_borrowed = violators.Date_borrowed )";

	$result = mysqli_query($connect, $query);

	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$query = "INSERT INTO violators (Stud_num, Last_name, First_name, Book_title, Date_borrowed, Return_date, Returned) VALUES ('" . $row['stud_num'] . "', '" . $row['b_last_name'] . "', '" . $row['b_first_name'] . "', '" . $row['book_title'] . "', '" . $row['date_borrowed'] . "', '" . $row['return_date'] . "', '" . $row['returned'] . "')";
			mysqli_query($connect, $query);
		}
	}

	//mysqli_close($connect);

}