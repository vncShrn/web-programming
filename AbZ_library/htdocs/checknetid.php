<?php
if ($_SERVER ["REQUEST_METHOD"] == "POST") {

	$con = mysqli_connect('localhost','root','root','proj');
	mysqli_select_db('proj');
	
	if ($con->connect_error) {
		echo 'Could not connect to DB: ' . mysqli_error ( $con ) ;
		$message = "Ooops, Theres been a technical error! ". mysqli_error($con);
		$status = "error";
		$data = array (
				'status' => $status,
				'message' => $message
		);
		exit();
	}
	//sanitize data
	$netid = ($_POST['netid']);
	
	//validate email address - check if input was empty
	if(empty($netid)){
		$status = "error";
		$message = "You did not enter a net-id!";
	}
	else if(!preg_match('/^[a-zA-Z]{3}[0-9]{6}$/', $netid)){ //validate netid - check if is a valid netid
		$status = "error";
		$message = "You have entered an invalid net-id";
	}
	else {
		$existingSignup = $con->query ( "SELECT * FROM user WHERE net_id='$netid'" );
		if ($existingSignup->num_rows < 1) {
				
				$status = "success";
				$message = "User name is available. You can sign up";
		}
		else { //if already signed up
			$status = "error";
			$message = "This net-id has already been registered! Proceed to login";
		}
	}
	
	//return json response
	$data = array(
			'status' => $status,
			'message' => $message
	);
	
	echo json_encode($data);
	exit;
	}
	?>