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
<title>Add Book | AbZ</title>

<!-- javascript tags - start -->
<script src="lib_js/jquery2.js"></script>
<script src="lib_js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="lib_js/jquery.bootpag.min.js"></script>
<script src="lib_js/bootstrap.min.js"></script>
<script src="lib_js/index.js"></script>
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

<?php
include ("config.php");

$results = $mysqli->query ( "SELECT COUNT(*) FROM book" );
$get_total_rows = mysqli_fetch_array ( $results ); // total records
                                                   
// break total records into pages
$pages = ceil ( $get_total_rows [0] / $item_per_page );

?>
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
										class="fa fa-history"></span>Fines
								</a></li>
								<li role="presentation" class="divider"></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="logout.php"><span class="glyphicon glyphicon-user"> </span>
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
		<section>
			<div class="container" id='books'>

				<h2 class="title text-center">Add New Book</h2>
				<div class="col-sm-3"></div>

				<div class="col-sm-7 product-information">
					<form method="post" action="updateBookDetails.php">
						<p>
							<b>ISBN ID: </b>
						</p>
						<input type="text" name="isbn" value="" placeholder="12345678"
							class="form-control" required>
						<p>
							<b> Title: </b>
						</p>
						<h2>
							<input type="text" class="form-control" name="title" value=""
								placeholder="Book Title" required>
						</h2>
						<p>
							<b> Description: </b> <input type="text" class="form-control"
								name="description" placeholder="Title Description">
						</p>
						<p>
							<b>Subject:</b> <input type="text" class="form-control"
								name="sub" value="" placeholder="Mathematics" required>
						</p>
						<p>
							<b>Publisher:</b> <input type="text" class="form-control"
								name="publisher" value="" required>
						</p>

						<p>
							<b>Edition:</b>
							<span> <input type="text"  name= "edition" value="" placeholder="First" style="font-size: 14px;color: #696763;"> &nbsp </span>
							<span><input type="text"  name= "year" value="" placeholder="year" style="font-size: 14px;color: #696763;"> </span>
							<span> <b> &nbsp &nbsp#copies: </b> <input type="text"  name= "copies" value="" style="font-size: 14px;color: #696763;"> </span>
						</p>
						<p>
							<b>Checkout Policy (days):</b> <input type="text"
								class="form-control" name="days" value="" placeholder="30"
								required>
						</p>

						<p>
							<b>Authors:</b> <input type="text" class="form-control"
								name="authors" value=""
								placeholder="FName1 Mname1 LName1,FName2 Mname2 LName2" required>
						</p>
						<p>
							<b>Image:</b> <input type='file' class="btn btn-default get"
								name="cover_img" value="" style = "background: #FFFFFF; border: 1;border-radius: 1;color: #000000;" required>
						</p>
						<span style="float: right">
							<button type="submit" class="btn btn-default get" name="add">Add</button>
							<button type="submit" class="btn btn-default get" name="cancel">Cancel</button>
						</span>
					</form>
				</div>
				<!--/product-information-->

			</div>
		</section>
	</div>
	<div class="footer-bottom" style="bottom: 0; width: 100%">
		<div class="container">
			<div class="row">
				<p class="pull-left">Copyright &#169 2017 AbZ The Library Inc. All
					rights reserved.</p>
				<p class="pull-right">
					Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span>
				</p>
			</div>
		</div>
	</div>
</body>
</html>