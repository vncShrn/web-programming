<?php
session_start ();
if ($_SERVER ["REQUEST_METHOD"] == "POST") {
	
	$con = mysqli_connect ( 'localhost', 'root', 'root', 'proj' );
	mysqli_select_db ( 'proj' );
	
	if ($con->connect_error) {
		echo 'Could not connect to DB: ' . mysqli_error ( $con );
		$message = "Ooops, Theres been a technical error! " . mysqli_error ( $con );
		exit ();
	}
	// sanitize data
	$net_id = $_POST ['net_id'];
	$password = $_POST ['password'];

	$password = sha1($password);
	
// 	echo $net_id;
// 	echo $password;
	$existingSignup = $con->query ( "SELECT * FROM user WHERE net_id='$net_id'" );
	if ($existingSignup->num_rows >= 1) {
		$sql = "SELECT pwd, is_admin FROM user WHERE net_id='$net_id'";
		
		$insertSignup = $con->query ( $sql );
		$data = mysqli_fetch_assoc ( $insertSignup );
		if ($data ["pwd"] != $password) { // if passwords do not match
			echo "<script>
				alert('Invalid login credentials!');
				window.location.href='login.html';
				</script>";
		} else { // if passwords match
			session_regenerate_id ();
			$_SESSION ['sess_username'] = $net_id;
			session_write_close ();
			if ($data ["is_admin"] == 1)
				header ( 'Location: index_admin.php' );
			else
				header ( 'Location: index_user.php' );
		}
	} else { // if not already signed up
	         // session_regenerate_id();
	         // $_SESSION['sess_username'] = $net_id;
		echo "<script>
				alert('You seem to be a new user! Please sign up');
				window.location.href='signup.html';
				</script>";
	}
	exit ();
}
?>