<?php
session_start ();
if (isset ( $_SESSION ['cart'] )) {
	echo "Already array init";
} else {
	$_SESSION ['cart'] = array ();
	echo "Array init";
}

$user_id = $_SESSION ['sess_username'];


// var_dump ( $_SESSION);

foreach ( $_SESSION ['cart'] as $item => $book ) {
	
	// $isbnarray=$book[0];
	// echo $isbnarray."<br>";
	
	if ($book [0] === $_GET ['isbn']){
	echo "Already in cart";
	header ( "location:index_user.php" );
	exit();
	}
	
	// foreach ( $book as $v => $detail )
	// {
	// echo $detail;
	// }
}
array_push ( $_SESSION ['cart'], array (
		$_GET ['isbn'],
		$_GET ['title'],
		$_GET ['image'],
		$_GET ['desc'],
		$_GET ['days']
) );
header ( "location:index_user.php" );

?>