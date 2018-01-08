<?php
session_start ();
include "config.php";
if (isset ( $_POST ["page"] )) {
	$page_number = filter_var ( $_POST ["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH );
	if (! is_numeric ( $page_number )) {
		die ( 'Invalid page number!' );
	} // incase of invalid page number
} else {
	$page_number = 1;
}

// get current starting point of records
$position = (($page_number - 1) * $item_per_page);

/**
 * To populate div #get_loan_items in orderhistory.php of index_user
 * Called from orderhistory.php
 */
if (isset ( $_POST ["loans"] )) {
	$net_id = $_SESSION ['sess_username'];
	
	$sql = "SELECT loan_id, borrowed_date, cover_img, book.isbn, title, returned_date, due_date, fine_amt, is_fine_paid FROM book,loans WHERE book.isbn=loans.isbn and net_id='$net_id' ORDER BY borrowed_date ASC LIMIT $position, $item_per_page";
	
	$results = $mysqli->query ( $sql );
	if ($results) {
		while ( $obj = $results->fetch_object () ) {
			$cart_items .= <<<TYH
						<tr>
						
							<td class="cart_product"><a href=""><img
									src="lib_images/books/{$obj->cover_img}" alt="lib_images/books/$book[2]"></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{$obj->title}</a></h4>
								<p>ISBN id: {$obj->isbn}</p>
							</td>
							<td class="cart_description">{$obj->borrowed_date}</td>		
							<td class="cart_description">{$obj->due_date} </td>
							<td class="cart_price"> 
TYH;
			$date = $obj->returned_date;
			if ($date === null) {
				$isReturned = "NO";
			} else {
				$isReturned = "YES";
			}
			
			$cart_items .= <<<TYH
								<p>$isReturned</p>
							</td>
TYH;
			
			$isFinePaid = $obj->is_fine_paid;
			$fineAmt = $obj->fine_amt;
			
			if ($isReturned === "YES" and $isFinePaid === '0' and $fineAmt !== '0') {
				$cart_items .= <<<TYH
				
<td class="cart_description"><a class = "btn btn-default get" href="orderhistory.php?pay=$obj->loan_id">Pay Fine</td>
						</tr>
TYH;
			} else {
				$cart_items .= "<td></td>";
			}
		}
		echo $cart_items;
	}
	exit ();
}

/**
 * Search
 * To populate div #get_books in index.php, index_user.php, index_admin.php
 */
if (isset ( $_POST ["keyword"] )) {
	$keyword = $_POST ["keyword"];
	
	$sql = "select b.isbn, GROUP_CONCAT(a.name) AS author_names, 
	title, description, publisher, edition, year, cover_img, check_out_policy, copies, available, c.name as category, l.floor, l.aisle
	from book b,book_author ba,author a, category c, location l
	where b.Isbn=ba.Isbn and
	ba.author_id=a.author_id and
	c.categ_id = b.categ_id and
    c.location_id = l.location_id and 
	(b.title LIKE '%$keyword%')
	group by (b.ISBN)
	ORDER BY title ASC
	LIMIT $position, $item_per_page";
} else {
	/**
	 * Listing all books
	 */
	$sql = "select b.isbn, GROUP_CONCAT(a.name) AS author_names, 
	title, description, publisher, edition, year, cover_img, check_out_policy, copies, available, c.name as category, l.floor, l.aisle
	from book b,book_author ba,author a, category c, location l
	where b.Isbn=ba.Isbn and
	ba.author_id=a.author_id and
    c.categ_id = b.categ_id and
    c.location_id = l.location_id
	group by (b.ISBN)
	ORDER BY title ASC
	LIMIT $position, $item_per_page";
}

/**
 * Listing all books for admin
 * as edit fields
 */
if ($_SESSION ["sess_username"] === "admin") {
	$results = $mysqli->query ( $sql );
	if ($results->num_rows == 0) {
		echo "No results found";
		exit ();
	} else {
		$products_item = '';
		// fetch results set as object and output HTML
		while ( $obj = $results->fetch_object () ) {
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
	}
}

/**
 * Listing all books for index.php, index_user.php
 */
$results = $mysqli->query ( $sql );
if ($results->num_rows == 0) {
	echo "No results found";
	exit ();
} else {
	$products_item = '';
	while ( $obj = $results->fetch_object () ) {
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

?>