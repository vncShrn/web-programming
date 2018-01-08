<?php
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
	$fname = $_POST ['fname'];
	$lname = $_POST ['Lname'];
	$email_id = $_POST ['email_id'];
	$contactnum = $_POST ['contactnum'];
	$password = $_POST ['password'];
	$password = sha1($password);
	
	$existingSignup = $con->query ( "SELECT * FROM user WHERE net_id='$net_id'" );
	if ($existingSignup->num_rows < 1) {
		$sql = "INSERT INTO user VALUES ('$net_id','$fname','$lname', '$email_id','$contactnum','$password','0',0,0)";
// 		echo "$sql";
		$insertSignup = $con->query ( $sql );
		if ($insertSignup) { // if insert is successful
			
			echo "<script>
				alert('Sign-up successful');
				window.location.href='login.html';
				</script>";
		} else { // if insert fails
			echo "<script>
				alert('Sign-up failed! Try again');
				window.location.href='signup.html';
				</script>";
		}
	} else { // if already signed up
		echo "<script>
				alert('Net-id already registered! Login');
				window.location.href='login.html';
				</script>";
	}
	
	exit ();
}
?>?>