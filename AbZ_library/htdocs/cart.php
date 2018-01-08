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
<title>Cart | AbZ</title>

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

		<h2 class="title text-center">BOOK CART</h2>

		<form action="updateLoans.php" method="post">

			<table class="table table-condensed cart-info">
				<thead>
					<tr class="cart_menu"
						style="font-size: 16px; font-family: 'Roboto', sans-serif; font-weight: normal;">
						<td class="image"></td>
						<td class="description"><b>Book</b></td>
						<td class="price"><b>Return in (days)</b></td>
						<td></td>
					</tr>
				</thead>
				<tbody id="get_cart_items">
				</tbody>
			</table>

			<button style="float: right" type="submit"
				class="btn btn-default get">Check-out</button>
		</form>
		<br> <br> <br> <br> <br> <br> <br> <br> <br>
	</section>
	<!--/#cart_items-->

<?php
if (isset ( $_GET ['rc'] ) && isset ( $_SESSION ['cart'] )) {
	$isbn = $_GET ['rc'];
	
	foreach ( $_SESSION ['cart'] as $key => $cartItem ) {
		if ($cartItem [0] == $isbn) {
			unset ( $_SESSION ['cart'] [$key] );
		}
	}
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