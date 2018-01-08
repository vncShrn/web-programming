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
<title>Home | AbZ</title>

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

<script type="text/javascript">
$(document).ready(function() {
	$("#get_books").load("fetch_pages.php");  //initial page number to load
	$(".pagination").bootpag({
	   total: <?php echo $pages; ?>,
	   page: 1,
	   maxVisible: 5 
	}).on("page", function(e, num){
		e.preventDefault();
		$("#get_books").prepend('<div class="loading-indication"><img src="lib_images/validation/loading.gif" /> Loading...</div>');
		$("#get_books").load("fetch_pages.php", {'page':num});
		window.scrollTo(0, 0);
	})
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
					<li><a href="index_admin.php"><span class="fa fa-book"></span>
							Books</a></li>
					<li style="width: 300px; left: 10px; top: 10px;">
						<div class="input-group">
							<input type="text" class="form-control" id="search"
								placeholder="Search by Title" /> <span class="input-group-addon"> <i
								class="fa fa-search"></i>
							</span>
						</div>
					</li>
					<li style="top: -5px; left: 20px;"><button class="btn btn-primary"
							id="search_btn" style="display: none;">Search</button></li>
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
		<section>
			<div class="container" id='books'>
				<div class="row">
					<div class="col-sm-3">
						<div class="left-sidebar" id="subjects">
							<h2 class="title text-center">Subjects</h2>
							<div class="panel-group category-products" id="category">
								<!--category-products - start-->
							</div>
							<!--/category-products-->
						</div>
					</div>

					<div class="col-sm-9 padding-right">
						<div class="featured_items">
							<!--features_items-->
							<h2 class="title text-center">Featured Books</h2>
							<!-- Products List Start -->
							<div id="get_books"></div>
							<!-- Products List End -->
						</div>
						<div class="pagination" style="float: right"></div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<?php
	if (isset ( $_GET ['delete'] )) {
		$isbn = $_GET ['delete'];
		
		$sql = "Update book set available=0, copies=0 where isbn='$isbn'";
		$mysqli->query ( $sql );
	}
	?>
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
	<script src="lib_js/getBookSubjects.js"></script>

</body>
</html>