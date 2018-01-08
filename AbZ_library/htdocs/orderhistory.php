<?php
session_start ();
if (! isset ( $_SESSION ["sess_username"] )) {
	header ( "location:index.php" );
}
include_once ("config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>Loans | AbZ</title>

<!-- javascript tags - start -->
<script src="lib_js/jquery2.js"></script>
<script src="lib_js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
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
	$("#get_loan_items").load("fetch_pages.php", {'loans':'1'});
});
</script>
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
					<li><a href="index_user.php"><span class="fa fa-book"></span> Books</a></li>
				</ul>
				<div class="nav navbar-nav navbar-right">

					<div class="dropdown"
						style="position: absolute; top: 15px; right: 5px;">
						<button class="btn btn-default dropdown-toggle" id="menu1"
							type="button" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span><?php echo " ".$_SESSION['sess_username']." "; ?><span
								class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>Cart</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="orderhistory.php" style="text-decoration: none;"> <i
									class="glyphicon glyphicon-header" aria-hidden="true"></i>
									History
							</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="logout.php"><span class="glyphicon glyphicon-off"> </span>
									Logout</a></li>

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>
	<br>
	<section id="cart_items">

				<h2 class="title text-center">CHECKED-OUT BOOKS</h2>

				<div id="total_fine" style="padding-right=30px;float: right; "><span>&nbsp;&nbsp;&nbsp;</span></div>
				<table class="table table-condensed cart-info">
					<thead>
						<tr class="cart_menu" style="font-size: 16px; font-family: 'Roboto', sans-serif; font-weight: normal;">
							<td class="image"></td>
							<td class="description"><b>Book</b></td>
							<td class="price"><b>Borrowed Date</b></td>
							<td class="price"><b>Due Date</b></td>
							<td class="price"><b>Returned?</b></td>
							<td class="price"></td>
						</tr>
					</thead>
					<tbody id="get_loan_items">
					</tbody>
				</table>

	</section>
	<!--/#cart_items-->

<?php

if (isset ( $_GET ['pay'] )) {
	$loan_id = $_GET ['pay'];
	// $query = "select loan_id, net_id, isbn from loans where returned_date is not null and loan_id='$loan_id'";
	// $result = $mysqli->query ( $query );
	
	$net_id = $_SESSION ["sess_username"];
	$q = "update loans set is_fine_paid='1' where net_id='$net_id' and loan_id='$loan_id'";
// 	echo "update loans: " . $q;
	
// 	echo '<script language="javascript">';
// 	echo 'alert("update loans: ' . $q . '")';
// 	echo '</script>';
	
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

	<section>
		<footer>
			<div class="footer-bottom" style="bottom: 0; width: 100%">
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