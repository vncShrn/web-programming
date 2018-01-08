<?php
session_start ();
if (! isset ( $_SESSION ["sess_username"] )) {
	header ( "location:index.php" );
}
include_once ("config.php");

if (isset ( $_POST ["fine"] )) {
	// 1. today's date has exceeded due_date, still not returned book
	// 2. he has returned the book already, but returned it late
	// summary - returns all books for whch fine has to be calculated
	$query = "Select isbn, net_id, returned_date,due_date from loans where (DATE(NOW())>DATE(due_date) and returned_date is null) || (DATE(returned_date)>DATE(due_date) and returned_date is not null);";
	
	$result = $mysqli->query ( $query );
	$count = mysqli_num_rows ( $result );
	if ($count == 0) {
		$info = "Users have no fines";
	} else {
		$query1 = "Select loan_id, isbn, net_id, returned_date,due_date from loans where (DATE(NOW())>DATE(due_date) and returned_date is null)";
		
		$result1 = $mysqli->query ( $query1 );
		while ( $row = mysqli_fetch_array ( $result1 ) ) {
			
			$dd = $row ['due_date'];
			$isbn = $row ['isbn'];
			$net_id = $row ['net_id'];
			$loan_id = $row ['loan_id'];
			
			$date1 = date_create ( date ( "Y-m-d" ) );
			$date2 = date_create ( $dd );
			$diff = date_diff ( $date1, $date2 );
			$days = $diff->format ( "%a" );
			// $info .= " diff: " . $days;
			$fine = (( int ) $days) * 5;
			// $info .= ' Fine: ' . $fine;
			$query2 = "Update loans set fine_amt='$fine' where loan_id='$loan_id'";
			$mysqli->query ( $query2 );
		}
		$info .= "Update Succesful";
		
		$query3 = "Select loan_id, isbn, net_id, returned_date,due_date from loans where (DATE(returned_date)>DATE(due_date) and returned_date is not null)";
		
		$result2 = $mysqli->query ( $query3 );
		
		$count = mysqli_num_rows ( $result2 );
		if ($count > 0) {
			while ( $row = mysqli_fetch_array ( $result2 ) ) {
				$dd = $row ['due_date'];
				$rd = $row ['returned_date'];
				$isbn = $row ['isbn'];
				$net_id = $row ['net_id'];
				$loan_id = $row ['loan_id'];
				
				$date1 = date_create ( $rd );
				$date2 = date_create ( $dd );
				$diff = date_diff ( $date1, $date2 );
				$days = $diff->format ( "%a" );
				// $info .= " diff: " . $days;
				$fine = (( int ) $days) * 5;
				// $info .= ' Fine: ' . $fine;
				$query4 = "Update loans set fine_amt='$fine' where loan_id='$loan_id'";
				$mysqli->query ( $query4 );
			}
		} else {
			$info = "All fines upto date";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>Fines | AbZ</title>

<!-- javascript tags - start -->
<script src="lib_js/jquery2.js"></script>
<script src="lib_js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="lib_js/jquery.bootpag.min.js"></script>
<script src="lib_js/bootstrap.min.js"></script>
<script src="lib_js/index.js"></script>
<script src="lib_js/cart.js"></script>
<!-- javascript tags - end -->

<!-- css tags - start -->
<link href="lib_css/bootstrap.min.css" rel="stylesheet">
<link href="lib_css/price-range.css" rel="stylesheet">
<link href="lib_css/animate.css" rel="stylesheet">
<link href="lib_css/responsive.css" rel="stylesheet">
<link href="lib_css/checknetid.css" rel="stylesheet">
<link href="images/ico/favicon.ico" rel="shortcut icon">
<link href="lib_css/font-awesome.min.css" rel="stylesheet">
<link href="lib_css/prettyPhoto.css" rel="stylesheet">
<link href="lib_css/main.css" rel="stylesheet">
<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

<!-- css tags - end -->

<link rel="stylesheet"
	href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#collapse"
					aria-expanded="false">
					<span class="sr-only">navigation</span> <span class="icon-bar"></span>
					<span class="icon-bar"></span> <span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand">The Library</a>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav">
					<li><a href="index_admin.php"><span class="fa fa-book"></span>
							Books</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li style="position: absolute; right: 100px;"><a
						href="addNewBook.php"><span class="fa fa-book"></span> Add Book </a></li>
					<li>
						<div class="dropdown"
							style="position: absolute; top: 15px; right: 5px;">
							<button class="btn btn-default dropdown-toggle" id="menu1"
								type="button" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span><?php echo " ".$_SESSION['sess_username']." "; ?><span
									class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="collectBooks.php" style="text-decoration: none;"> <span
										class="glyphicon glyphicon-shopping-cart"></span> Collect
										Books
								</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="fines.php" style="text-decoration: none;"> <span
										class="glyphicon glyphicon-euro"></span> Fines
								</a></li>
								<li role="presentation" class="divider"></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="logout.php"><span class="glyphicon glyphicon-off"> </span>
										Logout</a></li>

							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>
	<br>
	<div class="container" style="position: relative">
		<section id="cart_items">
			<div class="container">
				<h2 class="title text-center">FINES</h2>

				<div class="container-fluid col-sm-12">
					<div class="col-sm-4">
						<form action="fines.php" method="post">
							<span class="panel-title col-sm-6"> Display Fines <select
								name="pay" class="form-control">  
									<option value="False">Unpaid</option>
									<option value="True">Paid</option>  

							</select>
							</span> <span class="col-sm-4"><br> <input type="submit"
								value="Search" class="btn btn-default get"> </span>
						</form>
					</div>
					<div class="col-sm-3"></div>
					<div class="col-sm-5">
						<form action="fines.php" method="post">
							<p>
								<span class='panel-title'> Update fines for recent transactions</span>
							</p>
							<p>
								<input type="submit" value="Update Fines" name="fine"
									class="btn btn-default get"> <span>&nbsp;&nbsp;<?php echo $info ?></span>
							</p>

						</form>
					</div>
					<div class="col-sm-9"></div>
					<br> <br> <br> <br>
				</div>
				<div class="container-fluid col-sm-12">
					<br>
					<div class="col-sm-6">
				
<?php

if (isset ( $_POST ['pay'] )) {
	$paid = $_POST ['pay'];
	if ($paid == 'True') {
		$query = "select net_id, balance 
from user where is_bal_paid=1 and balance!=0;";
		$result = $mysqli->query ( $query );
		$c = mysqli_num_rows ( $result );
		if ($c == 0) {
			echo " No fines paid";
		} else {
			echo "<p><b>PAID FINES</b></p>";
			echo "<table class='table table-condensed cart-info'>
			<tr class='cart_menu' style='font-size: 16px; font-family: 'Roboto', sans-serif; font-weight: normal;'>
			<th>Net-id</th><th>Total Fines</th></tr>";
			while ( $row = mysqli_fetch_array ( $result ) ) {
				echo '<tr><td>';
				echo $row ['net_id'];
				echo '</td><td>';
				echo $row ['balance'];
				echo '</td></tr>';
			}
			echo '</table>';
		}
	} else {
		$query = "select net_id, balance 
from user where is_bal_paid=0 and balance!=0;";
		$result = $mysqli->query ( $query );
		$c = mysqli_num_rows ( $result );
		if ($c == 0) {
			echo "All fines paid";
		} else {
			echo "<p><b>UNPAID FINES</b></p>";
			echo "<table class='table table-condensed cart-info'>
					<tr class='cart_menu' style='font-size: 16px; font-family: 'Roboto', sans-serif; font-weight: normal;'>
					<th>Net-id</th><th>Total Fines</th><th></th></tr>";
			while ( $row = mysqli_fetch_array ( $result ) ) {
				$fine_amt = $row ['balance'];
				if ($fine_amt == '0') {
				} else {
					echo '<tr><td>';
					echo $row ['net_id'];
					echo '</td><td>';
					echo $row ['balance'];
					echo '</td><td><a class="btn btn-default" style="float:right; margin-right:5px;" href="fines.php?payuser=' . $row ['net_id'] . '">Collect Fine</a></td></tr>';
				}
			}
			echo '</table>';
		}
	}
}

if (isset ( $_GET ['payuser'] )) {
	$net_id = $_GET ['payuser'];
	$query = "select loan_id, net_id, isbn from loans where returned_date is not null and net_id='$net_id'";
	// echo $query;
	$result = $mysqli->query ( $query );
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$net_id = $row ['net_id'];
		$isbn = $row ['isbn'];
		$loan_id = $row ['loan_id'];
		$q = "update loans set is_fine_paid=1 where isbn='$isbn' and net_id='$net_id' and loan_id='$loan_id'";
		// echo "update loan: ".$q;
		$r = $mysqli->query ( $q );
		$q2 = "update user set is_bal_paid=1 where net_id='$net_id'";
		// echo "update user: ".$q;
		$mysqli->query ( $q2 );
	}
	echo "Payment successful";
}

if (isset ( $_GET ['pay'] )) {
	$loan_id = $_GET ['pay'];
	// $query = "select loan_id, net_id, isbn from loans where returned_date is not null and loan_id='$loan_id'";
	// $result = $mysqli->query ( $query );
	
	$net_id = $_SESSION ["sess_username"];
	$q = "update loans set is_fine_paid='1' where net_id='$net_id' and loan_id='$loan_id'";
	// echo "update loans: " . $q;
	
	// echo '<script language="javascript">';
	// echo 'alert("update loans: ' . $q . '")';
	// echo '</script>';
	
	$r = $mysqli->query ( $q );
	// all loans for a user, who have fine and havent paid
	$count = "select count(*) from loans where net_id='$id' and fine_amt!=0 and is_fine_paid=0 and returned_date is not null";
	if ($count == 0) {
		$q2 = "update user set is_bal_paid=1 where net_id='$net_id'";
		$mysqli->query ( $q2 );
	}
	echo '<script language="javascript">';
	echo 'alert("Payment successful")';
	echo '</script>';
}
?>
</div>
				</div>
			</div>
		</section>
		<!--/#cart_items-->
	</div>

	<section>
		<footer>
			<div class="footer-bottom"
				style="bottom: 0; position: fixed; width: 100%;">
				<div class="container">
					<div class="row">
						<p class="pull-left">Copyright &#169 2017 AbZ The Library Inc. All
							rights reserved.</p>
						<p class="pull-right">
							Designed by <span><a target="_blank"
								href="http://www.themeum.com">Themeum</a></span>
						</p>
					</div>
				</div>
			</div>

		</footer>
		<!--/Footer-->
	</section>
</body>
</html>