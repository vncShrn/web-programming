$(document).ready(function() {
	$(document).on('click', '.info_link', function() {
		var category = $(this).text();

		$("#get_books").html("<h4>Loading...</h4>");
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {
				category : category
			},
			success : function(data) {
				$("#get_books").html(data);
			}
		})
	})
//	$(".info_link").click(function() {

})
