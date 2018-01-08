<?php
$conn = mysqli_connect ( "localhost", "root", "root", "hw4" );
if (! conn) {
	echo "Failed to connect" . mysqli_connect_err ();
} else {
	$url = $_SERVER ['REQUEST_URI'];
	$uriarray = explode ( "/", $url );
	// echo $uriarray [0] . $uriarray [1] . $uriarray [2];
	$id = $uriarray [2];
	if ($id != '') {
		$sql = "SELECT title, year, price, category, GROUP_CONCAT(Author_name) AS authors 
		FROM Book, Authors, Book_Authors
		WHERE Book.Book_id='$id'
		AND Book.Book_id = Book_Authors.Book_id 
		AND authors.Author_id=book_authors.Author_id";
		
		// $sql = "SELECT title,year,price,category,GROUP_CONCAT(Author_name) AS authors
		// FROM (Book,Authors)
		// INNER JOIN book_authors ON Book.Book_id=book_authors.Book_id AND authors.Author_id=book_authors.Author_id where book.Book_id='$id'";
		
		$result = mysqli_query ( $conn, $sql );
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			$bookDetails [] = $row;
		}
		
		echo json_encode ( $bookDetails );
	} else {
		$sql = "SELECT title, price, category FROM Book";
		$result = mysqli_query ( $conn, $sql );
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			$booksList [] = $row;
		}
		echo json_encode ( $booksList );
	}
}
?> 
