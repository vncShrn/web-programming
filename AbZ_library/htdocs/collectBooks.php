<?php
session_start ();
if (! isset ( $_SESSION ["sess_username"] )) {
	header ( "location:index.php" );
}
include_once ("config.php");
$query1 = $mysqli->query ( "SELECT net_id, fname, lname FROM user; " );

if ($query1) {
	
	$netid_array = array ();
	$fname_array = array ();
	$lname_array = array ();
	
	while ( $row = mysqli_fetch_array ( $query1 ) ) {
		
		// add each row returned into an array
		$netid_array [] = $row ['net_id'];
		$fname_array [] = $row ['fname'];
		$lname_array [] = $row ['lname'];
	}
}

$query2 = $mysqli->query ( "SELECT isbn FROM  book" );
if ($query2) {
	
	$isbn_array = array ();
	while ( $row = mysqli_fetch_array ( $query2 ) ) {
		
		// add each row returned into an array
		$isbn_array [] = $row ['isbn'];
	}
}
?>

<?php

if (isset ( $_GET ['return'] )) {
// 	echo '<script language="javascript">';
// 	echo 'alert(" hi ")';
// 	echo '</script>';
// 	echo "hi ";
	$id = $_GET ['return'];
	$query = "Select * from loans where loan_id='$id' and returned_date is NULL";
// 	echo "query: ".$query;
	$result = $mysqli->query ( $query );
	$count = mysqli_num_rows ( $result );
// 	echo "count: ".$count;
	
	$info = "";
	if ($count == 0) {
		$info = "Book is already returned";
	} else {
		$query1 = "Update loans set returned_date=CURRENT_TIMESTAMP where loan_id='$id' and returned_date is null";
// 		echo "query: ".$query1;
		
		$result = $mysqli->query ( $query1 );
		$info = "Book has been returned";
// 		echo '<script language="javascript">';
// 		echo 'alert("' . $info . '")';
// 		echo '</script>';
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
<title>Collect | AbZ</title>

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

<script type="text/javascript">
$(document).ready(function() {
	var isbnArray = <? echo json_encode($isbn_array); ?>;
    $( "#book" ).autocomplete({
      source: isbnArray
    });

    var netIdArray = <? echo json_encode($netid_array); ?>;
    $( "#card" ).autocomplete({
      source: netIdArray
    });

    var fname_array = <? echo json_encode($fname_array); ?>;
    $( "#name" ).autocomplete({
      source: fname_array
    });
});
</script>
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

				<h2 class="title text-center">COLLECT BOOKS</h2>
				<div class="container-fluid">
					<form action="collectBooks.php" method="post"
						enctype="multipart/form-data">
						<p>
							<label class='panel-title'> &nbsp;&nbsp; Book ISBN: &nbsp;</label><input type="text"
								name="book" id="book"> <label class='panel-title'> &nbsp;&nbsp; Net Id:&nbsp; </label><input
								type="text" name="card" id="card"> <label class='panel-title'> &nbsp;&nbsp; User
								Name: &nbsp;</label><input type="text" name="name" id="name">
						</p>
						<p>
							<input type="Submit" value="Search" class="btn btn-default get"
								style="float: center" />
						</p>
					</form>
					<br> 
				</div>
				<div>
					<p><?php echo $info; ?></p> 
<?php
$book = $_POST ['book'];
$card = $_POST ['card'];
$name = $_POST ['name'];
if ($name == '') {
	if ($card == '') {
		$query = "select bl.loan_id, bl.isbn,bl.net_id,bl.borrowed_date,bl.due_date,bl.returned_date from loans bl where bl.isbn='$book'";
		$result = $mysqli->query ( $query );
		if ($result->num_rows == 0){
			exit();
		}
		echo "<p class='panel-title'>Search Results</p>";
		echo "<table class='table table-condensed cart-info'>
			<tr class='cart_menu' style='font-size: 16px; font-family: 'Roboto', sans-serif; font-weight: normal;'>
				<th>ISBN</th><th>Net-Id</th><th>Borrowed Date</th><th>Due Date</th><th>Returned Date</th> <th></th></tr>";
		while ( $row = mysqli_fetch_array ( $result ) ) {
			echo '<tr><td class="cart_price">';
			echo $row ['isbn'];
			echo '</td><td class="cart_price"">';
			echo $row ['net_id'];
			echo '</td><td class="cart_price">';
			echo $row ['borrowed_date'];
			echo '</td><td class="cart_price">';
			echo $row ['due_date'];
			echo '</td><td class="cart_price">';
			echo $row ['returned_date'];
			$di = $row ['returned_date'];
			if ($di == null) {
				echo '</td><td class="cart_price"><a style="float:right; margin-right:5px;" href="collectBooks.php?return=' . $row ['loan_id'] . '">Return Book</a></td></tr>';
			} else {
				echo '<td/td>';
			}
		}
		echo '</table>';
	} else {
		$query = "select bl.loan_id, bl.isbn,bl.net_id,bl.borrowed_date,bl.due_date,bl.returned_date from loans bl where bl.isbn='$book' or bl.net_id='$card'";
		$result = $mysqli->query ( $query );
		if ($result->num_rows == 0){
			exit();
		}
		echo "<p class='panel-title'>Search Results</p>";
		echo "<table class='table table-condensed cart-info'>
			<tr class='cart_menu' style='font-size: 16px; font-family: 'Roboto', sans-serif; font-weight: normal;'>
				<th>ISBN</th><th>Net-Id</th><th>Borrowed Date</th><th>Due Date</th><th>Returned Date</th> <th></th></tr>";
		while ( $row = mysqli_fetch_array ( $result ) ) {
			echo '<tr><td class="cart_price">';
			echo $row ['isbn'];
			echo '</td><td class="cart_price">';
			echo $row ['net_id'];
			echo '</td><td class="cart_price">';
			echo $row ['borrowed_date'];
			echo '</td><td class="cart_price">';
			echo $row ['due_date'];
			echo '</td><td class="cart_price">';
			echo $row ['returned_date'];
			$di = $row ['returned_date'];
			if ($di == null) {
				echo '</td><td class="cart_price"><a style="float:right; margin-right:5px;" href="collectBooks.php?return=' . $row ['loan_id'] . '">Return Book</a></td></tr>';
			} else {
				echo '<td/td>';
			}
		}
		echo '</table>';
	}
} else {
	$query = "select bl.loan_id, bl.isbn,bl.net_id,bl.borrowed_date,bl.due_date,bl.returned_date from loans bl,user b where (b.fname LIKE '%$name%' and b.net_id=bl.net_id) or (b.lname LIKE '%$name%' and b.net_id=bl.net_id) or bl.net_id='$card' or bl.isbn='$book'";
	
	$result = $mysqli->query ( $query );
	if ($result->num_rows == 0){
		exit();
	}
	echo "<p class='panel-title'>Search Results</p>";
	echo "<table class='table table-condensed cart-info'>
			<tr class='cart_menu' style='font-size: 16px; font-family: 'Roboto', sans-serif; font-weight: normal;'>
				<th>ISBN</th><th>Net-Id</th><th>Borrowed Date</th><th>Due Date</th><th>Returned Date</th> <th></th></tr>";
	while ( $row = mysqli_fetch_array ( $result ) ) {
		echo '<tr><td class="cart_price">';
		echo $row ['isbn'];
		echo '</td><td class="cart_price">';
		echo $row ['net_id'];
		echo '</td><td class="cart_price">';
		echo $row ['borrowed_date'];
		echo '</td><td class="cart_price">';
		echo $row ['due_date'];
		echo '</td><td class="cart_price">';
		echo $row ['returned_date'];
		$di = $row ['returned_date'];
		if ($di == null) {
			echo '</td><td><a style="float:right; margin-right:5px;" href="collectBooks.php?return=' . $row ['loan_id'] . '">Return Book</a></td></tr>';
		} else {
			echo '<td/td>';
		}
	}
	echo '</table>';
}

?>

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