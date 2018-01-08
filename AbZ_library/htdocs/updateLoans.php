<?php
session_start ();
include "config.php";

if (isset ( $_SESSION ['cart'] )) {
	$net_id = $_SESSION ['sess_username'];
	echo '' . $net_id;
	foreach ( $_SESSION ['cart'] as $item => $book ) {
		// $book[0] = ISBN
		// $book[1] = title
		// $book[2] = image
		// $book[3] = description
		// $book[4] = checkout days
		
		// Insert into loans table
		$days = ( int ) $book [4];
		
		$check_sql = "SELECT * FROM loans where isbn='$book[0]' and net_id='$net_id' and RETURNED_DATE is null";
		$check_result = $mysqli->query ( $check_sql );
		
		if ($check_result->num_rows == 0){
			// No such book loaned out before
			
		} else {
			// Same book has been loaned by this user before, and not returned yet
				echo "Old book not returned yet";
				unset ( $_SESSION ['cart'] [$item] );
				header ( "location:index_user.php" );
				exit();
		}
		
		$sql = "insert into loans values(null, '$book[0]','$net_id',CURDATE(),CURDATE()+ INTERVAL $days day,NULL,'0','0')";
		echo "loans: ".$sql;
		$results = $mysqli->query ( $sql );
		if (! $results) {
			echo "You have already checked out the book " . $book [1];
		}
		unset ( $_SESSION ['cart'] [$item] );
	}
	echo "Checkout complete";
	header ( "location:index_user.php" );
}
?>