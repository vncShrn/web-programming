$(document).ready(function() {
//	alert ("hi");
	displayAllSubjects();
	//	displayAllBooks();
	//	displayAllBooksForUser();
	displayFine();
	function displayAllSubjects() {
		$("#category").addClass('response-waiting').text('Please Wait...');
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {
				getSubject : 1
			},
			success : function(data) {
				$("#category").removeClass('response-waiting');
				$("#category").html(data);
			}
		})
	}

	var $scrollingDiv = $("#subjects");

	$(window).scroll(function() {
		$scrollingDiv.stop().animate({
			"marginTop" : ($(window).scrollTop())
		}, "slow");
	})

	$('#search').keypress(function(e) {
		if (e.which == 13) {// Enter key pressed
//			alert ("Keypressed");
			$('#search_btn').click();// Trigger search button click event
		}
	})
	$("#search_btn").click(function() {
//		alert("button action");
		var keyword = document.getElementById('search').value;
		if (keyword != "") {
			$("#get_books").load("fetch_pages.php", {
				'page' : 1,
				'keyword' : keyword
			}); //initial page number to load
			$(".pagination").bootpag({
				total : 1,
				page : 1,
				maxVisible : 5
			}).on("page", function(e, num) {
				e.preventDefault();
				$("#get_books").prepend('<div class="loading-indication"><img src="lib_images/validation/loading.gif" /> Loading...</div>');
				$("#get_books").load("fetch_pages.php", {
					'page' : num,
					'keyword' : keyword
				});
				window.scrollTo(0, 0);
			})

		} else {
			// 			alert("keyword missing ");

			$("#get_books").removeClass('response-waiting');
			$("#get_books").load("fetch_pages.php");
		}
	})
	function displayFine() {
		$("#total_fine").addClass('response-waiting').text('Please Wait...');
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {
				getTotalFine : 1
			},
			success : function(data) {
				$("#total_fine").removeClass('response-waiting');
				$("#total_fine").html(data);
			}
		})
	}
})
