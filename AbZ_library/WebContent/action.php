<?php
session_start ();
include "config.php";

if (isset ( $_POST ["getSubject"] )) {
	$result = $mysqli->query ( "SELECT DISTINCT name FROM category ORDER BY name ASC" );
	if ($result) {
		$sub_item = '';
		// fetch results set as object and output HTML
		while ( $sub = $result->fetch_object () ) {
			$sub_item .= <<<SUB
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a class="info_link" href="#">{$sub->name}</a>
				</h4>
			</div>
		</div>
	
SUB;
		}
		$sub_item .= '';
		echo $sub_item;
	}
}

if (isset ( $_POST ["populate_cart"] )) {
	
	if (isset ( $_SESSION ['cart'] )) {
		foreach ( $_SESSION ['cart'] as $item => $book ) {
			// $book[0] = ISBN
			// $book[1] = title
			// $book[2] = image
			// $book[3] = description
			// $book[4] = checkout days
			$cart_items .= <<<TYH
			
						<tr>
							<td class="cart_product"><a href=""><img
									src="lib_images/books/$book[2]" alt="lib_images/books/$book[2]"></a></td>
							<td class="cart_description">
								<h4>
									<a href="">$book[1]</a>
								</h4>
								<p>$book[3] </p> 
								<p>ISBN id: $book[0]</p>
							</td>
							<td class="cart_price">
								<p>$book[4]</p>
							</td>
							<td class="cart_delete"><a class="cart_quantity_delete" href="?rc=$book[0]"><i class="fa fa-times"></i></a></td>
						</tr>

TYH;
		}
		echo $cart_items;
	}
}

if (isset ( $_POST ["category"] )) {
	
	$keyword = $_POST ["category"];
	
	$sql = "SELECT b.isbn, GROUP_CONCAT(a.name) AS author_names,
	title, description, publisher, edition, year, cover_img, check_out_policy, copies, available, c.name as category, l.floor, l.aisle
	FROM book b,book_author ba,author a, category c, location l
	where b.Isbn=ba.Isbn and
	ba.author_id=a.author_id and
	c.categ_id = b.categ_id and
	c.location_id = l.location_id and
	b.categ_id IN (SELECT categ_id FROM category WHERE category.name ='$keyword')
	group by (b.ISBN)
	ORDER BY title ASC";
	
	echo "
	<div class='nav nav-pills nav-stacked'>
	<p style='background-color: #000000;'><h5 class='panel-title'>Category -> $keyword</h5></p><hr>
	";
	$result = $mysqli->query ( $sql );
	if ($result->num_rows == 0) {
		echo "No matching results";
		exit ();
	}
	
	if ($_SESSION ["sess_username"] == "admin") {
		
		$products_item = '';
		// fetch results set as object and output HTML
		while ( $obj = $result->fetch_object () ) {
			$isbn = "$obj->isbn";
			// echo 'isbn: '. $isbn;
			$authors = "$obj->author_names";
			// echo 'authors: '. $authors;
			$products_item .= <<<EOT
			<div class="product-details">
				<form method="post" action="updateBookDetails.php">
					<div class="view-product col-sm-5">
						<img src="lib_images/books/{$obj->cover_img}" alt="Img unavailable" \ />
						<p>
						<input type='file' class = "btn btn-default" name= "cover_img" value="lib_images/books/{$obj->cover_img}">
						</p>
					</div>
				<div class="col-sm-7 product-information">
						<p class ="cart_delete"><a href="?delete=$isbn" style="float:right;"><i class="fa fa-times"></i></a></p>
						<p><b>ISBN ID: </b>{$obj->isbn}</p>
						<input type="hidden" name= "isbn" value="{$obj->isbn}">
						<p><b> Title: </b>
						<h2><input type="text" class="form-control" name= "title" value="{$obj->title}"></h2> <p>
						<b> Description: </b>
						<p><input type="text" class="form-control" name= "description" value="{$obj->description}"></p>
						<p>
							<b>Subject:</b>
							<input type="text" class="form-control" name= "sub" value="{$obj->category}">
						</p>
						<p>
							<b>Publisher:</b>
							<input type="text" class="form-control col-xs-2" name= "publisher" value="{$obj->publisher}">
						</p>
		
						<p>
							<b>Edition:</b></span>
							<span> <input type="text"  name= "edition" value="{$obj->edition}" style="font-size: 14px;color: #696763;"> &nbsp </span>
							<span><input type="text"  name= "year" value="{$obj->year}" style="font-size: 14px;color: #696763;"> </span>
							<span> <b> &nbsp &nbsp#copies: </b> <input type="text"  name= "copies" value="{$obj->copies}" style="font-size: 14px;color: #696763;"> </span>
							<span> <b> &nbsp &nbspreturn by: </b> <input type="text"  name= "days" value="{$obj->check_out_policy}" style="font-size: 14px;color: #696763;"> </span>
						</p>
			  			<p>
							<b>Authors:</b>
							<input type="text"  class="form-control" name= "authors" value="{$obj->author_names}">
						</p>
					<span style="float: right">
					<button type="submit"
					class="btn btn-default" name="update">Update</button>
					<button type="submit"
					class="btn btn-default" name="cancel">Cancel</button>
					</span>
					</div>
					<!--/product-information-->
			</form>
			</div>
			<!--/product-details-->
EOT;
		}
		echo $products_item;
		exit ();
	} else {
		// for normal user
		$products_item = '';
		while ( $obj = $result->fetch_object () ) {
			$products_item .= <<<EOT
			<div class="product-details row row-eq-height">
				<div class="col-sm-5">
					<div class="view-product">
						<img src="lib_images/books/{$obj->cover_img}" alt="Img unavailable" \ />
					</div>
				</div>
				<div class="col-sm-7 product-information">
						<h2>{$obj->title}</h2>
						<p><b>ISBN ID: </b>{$obj->isbn}</p>
						<p>{$obj->description}</p>
						<p>
							<b>Subject:</b> {$obj->category}
						</p>
						<p>
							<b>Publisher:</b> {$obj->publisher}
						</p>
						<p>
							<b>Edition:</b> {$obj->edition} edition, {$obj->year}
						</p>
						<p>
							<b>Authors:</b> {$obj->author_names}
						</p>
						<p>
							<b>Subject:</b> {$obj->category}
						</p>
						<p>
							<b>Find in library:</b></span>
							<span> Floor {$obj->floor}  </span>
							<span> Aisle {$obj->aisle} </span>
							<span> <b> &nbsp &nbsp#copies: </b> {$obj->copies} </span>
						</p>
EOT;
			
			if ($obj->available === "0") {
				$products_item .= <<<EOT
						<p>
							<b>Availability:</b> Out of Stock
						</p>
EOT;
			} else {
				$products_item .= <<<EOT
						<p>
							<b>Availability:</b> {$obj->available}; In Stock
						</p>
EOT;
			}
			
			if (isset ( $_SESSION ["sess_username"] )) {
				if ($_SESSION ["sess_username"] === "admin") {
					// admin already handled in above block
				} else {
					// for index_user.php
					// display add to cart button - enabled
					// if available
					if ($obj->copies === "0" || $obj->available === "0") {
						$products_item .= <<<EOT
				<p>
				<a style="float:right; pointer-events: none;" href="" class = "btn btn-default get disabled">
				<i class="fa fa-shopping-cart"></i> Add to Cart</a>
				</p>
EOT;
					} else {
						// display add to cart button - disabled
						// if unavailable
						$products_item .= <<<EOT
				<p>
				<a class = "btn btn-default get" style="float:right" href="updatecart.php?isbn=$obj->isbn&title=$obj->title&image=$obj->cover_img&desc=$obj->description&days=$obj->check_out_policy">
				<i class="fa fa-shopping-cart"></i> Add to Cart</a>
				</p>
EOT;
					}
				}
			}
			$products_item .= '
				</span>
				</p>
					<!--/product-information-->
				</div>
			</div>
			<!--/product-details-->';
		}
		echo $products_item;
	}
}

/**
 * To populate div #total_fine in orderhistory.php of index_user
 */
if (isset ( $_POST ["getTotalFine"] )) {
	
	$net_id = $_SESSION ["sess_username"];
	
	$sql_check = "SELECT * FROM loans where is_fine_paid=0 and fine_amt != 0 and net_id='$net_id'";
	$result_check = $mysqli->query ( $sql_check );
	
	if ($result_check->num_rows == 0){
		// User has paid all fines
		$sql_up = "update user set is_bal_paid=1 where net_id='$net_id'";
		$mysqli->query ( $sql_up );
// 		echo "paid= 1: ".$sql_up;
	} else {
		// User has paid all fines
		$sql_up = "update user set is_bal_paid=0 where net_id='$net_id'";
		$mysqli->query ( $sql_up );
// 		echo "paid= 0: ".$sql_up;
	}
	
	$sql = "select balance, is_bal_paid from user where net_id='$net_id'";
	$result = $mysqli->query ( $sql );
	echo "<div>";
	if ($result->num_rows == 0) {
		echo "Details missing";
		exit ();
	} else {
		while ( $obj = $result->fetch_object () ) {
			$msg .= "
				<p><b>Total Fine: </b><span>{$obj->balance}$&nbsp;</span>";
			if ($obj->balance == '0') {
			} else {
				$msg .= "<b> Is all fines paid? </b>";
				if ($obj->is_bal_paid == "1") {
					
					$msg .= "
				<span>Yes</span>
				</p>";
				} else {
					$msg .= "
				<span>No</span>
				&nbsp;</p>";
				}
			}
		}
		echo $msg . "</div>";
	}
}
?>