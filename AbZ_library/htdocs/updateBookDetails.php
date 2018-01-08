<?php
include_once ('config.php');
session_start ();
if (isset ( $_POST ['update'] )) {
	// echo $_POST['isbn'].$_POST['title']. $_POST['description'].$_POST['publisher'].$_POST['edition'].$_POST['year'].$_POST['copies'].$_POST['authors'].$_POST['cover_img'];
	$isbn = htmlspecialchars ( $_POST ['isbn'] );
	$title = htmlspecialchars ( $_POST ['title'] );
	$desc = htmlspecialchars ( $_POST ['description'] );
	$publisher = htmlspecialchars ( $_POST ['publisher'] );
	$edition = htmlspecialchars ( $_POST ['edition'] );
	$year = htmlspecialchars ( $_POST ['year'] );
	$copies = htmlspecialchars ( $_POST ['copies'] );
	$authors = htmlspecialchars ( $_POST ['authors'] );
	$cover_img = htmlspecialchars ( $_POST ['cover_img'] );
	$days = htmlspecialchars ( $_POST ['days'] );
	$category = htmlspecialchars ( $_POST ['sub'] );
	
	$sql = "Update book set title='$title', description='$desc', publisher='$publisher', edition='$edition', year='$year', check_out_policy='$days', copies='$copies', available='$copies',
	categ_id = ( SELECT categ_id FROM proj.category
	where proj.category.NAME like '%$category%' limit 1)";

	
	if (! empty ( $cover_img )) {
		$sql .= ", cover_img='$cover_img'";
	}
	$sql .= " where isbn='$isbn'";
	
	echo "update: " . $sql;
	
	$results = $mysqli->query ( $sql );
	
	if ($results) {
		$sql_del = "DELETE FROM book_author where isbn='$isbn'";
		$results_del = $mysqli->query ( $sql_del );
		if ($results_del) {
			$authorArray = explode ( ',', $authors );
			foreach ( $authorArray as $author ) {
				$query_sql = "SELECT author_id FROM author where name ='$author'";
				$result = $mysqli->query ( $query_sql );
				// Already existing author found
				if ($result->num_rows == 0) {
					// Create new author entry and book_author
					$create_sql = "insert into author values (null,'$author');";
					$mysqli->query ( $create_sql );
					
					$author_id = $mysqli->insert_id;
					
					$update_sql = "insert into book_author values('$isbn', '$author_id');";
					echo " new: " . $update_sql;
					$mysqli->query ( $update_sql );
				} else {
					while ( $row = mysqli_fetch_array ( $result ) ) {
						$author_id = $row ["author_id"];
					}
					$update_sql = "insert into book_author values('$isbn', '$author_id');";
					echo " existing: " . $update_sql;
					$mysqli->query ( $update_sql );
				}
			}
		}
	}
	
	header ( "Location: index_admin.php" );
	exit ();
}
if (isset ( $_POST ['add'] )) {
	$isbn = htmlspecialchars ( $_POST ['isbn'] );
	$title = htmlspecialchars ( $_POST ['title'] );
	$desc = htmlspecialchars ( $_POST ['description'] );
	$publisher = htmlspecialchars ( $_POST ['publisher'] );
	$edition = htmlspecialchars ( $_POST ['edition'] );
	$year = htmlspecialchars ( $_POST ['year'] );
	$copies = htmlspecialchars ( $_POST ['copies'] );
	$authors = htmlspecialchars ( $_POST ['authors'] );
	$cover_img = htmlspecialchars ( $_POST ['cover_img'] );
	$days = htmlspecialchars ( $_POST ['days'] );
	$category = htmlspecialchars ( $_POST ['sub'] );
	
	$sql = "Insert into book values ('$isbn', '$title', '$desc', '$publisher', '$edition', '$year', '$cover_img', '$days', '$copies','$copies', 
	( SELECT categ_id FROM proj.category
	where proj.category.NAME like '%$category%' limit 1))";
	echo "1: " . $sql;
	$results = $mysqli->query ( $sql );
	
	if ($results) {
		$authorArray = explode ( ',', $authors );
		foreach ( $authorArray as $author ) {
			$query_sql = "SELECT author_id FROM author where name ='$author' LIMIT 1";
			$result = $mysqli->query ( $query_sql );
			echo " query auth: " . $query_sql;
			// Already existing author found
			if ($result->num_rows == 0) {
				// Create new author entry and book_author
				$create_sql = "insert into author values (null,'$author');";
				$mysqli->query ( $create_sql );
				$author_id = $mysqli->insert_id;
				$update_sql = "insert into book_author values('$isbn', '$author_id');";
				echo " new: " . $update_sql;
				$mysqli->query ( $update_sql );
			} else {
				$userData = mysqli_fetch_assoc ( $result );
				$id = $userData ["author_id"];
				echo " id: " . $id;
				$update_sql = "insert into book_author values('$isbn', '$id');";
				echo " existing: " . $update_sql;
				$mysqli->query ( $update_sql );
			}
		}
		header ( "Location: index_admin.php" );
	} else {
		echo '<script type="text/javascript">';
		echo 'alert("Book cannot be added! Try again");';
		echo 'window.location.href = "addNewBook.php";';
		echo '</script>';
	}
	
	exit ();
}
if (isset ( $_POST ['cancel'] )) {
	header ( "Location: index_admin.php" );
	exit ();
}

?>