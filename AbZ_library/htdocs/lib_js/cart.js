$(document).ready(function() {
	displayAllCartItems();
	function displayAllCartItems() {
		$("#get_cart_items").html("<h4>Loading...</h4>");

		$.ajax({
			url : "action.php",
			method : "POST",
			data : {
				populate_cart : 1
			},
			success : function(data) {
				$("#get_cart_items").html(data);
				if ($("body").width() < 480) {
					$("body").scrollTop(683);
				}
			}
		})

	}
});