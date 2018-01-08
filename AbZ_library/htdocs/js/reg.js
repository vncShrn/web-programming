$(document).ready(
		function() {
			$("#register").click(
					function(event) {
						event.preventDefault();
						$("#username").after("<span id='user_focus'> Enter only alphabetical and numerical characters </span>");
						$("#username").after("<span id='user_error'> <i>Error.Username can contain only alphabetical and numerical characters</i> </span>");
						$("#username").after("<span id='user_empty'> <i>Please provide the username</i> </span>");
						$("#password").after("<span id='pass_focus'> <i>The password field should be at least 8 characters long</i> </span>");
						$("#password").after("<span id='pass_error'> <i>Error.Enter a valid password</i> </span>");
						$("#password").after("<span id='pass_ok'> <i>ok</i> </span>");
						$("#password").after("<span id='pass_empty'> <i>Please provide the password</i> </span>");
						$("#email").after("<span id='email_focus'> <i>email address should be in the form abc@gma.com</i> </span>");
						$("#email").after("<span id='email_error'> <i>Error.enter valid email address</i> </span>");
						$("#email").after("<span id='email_empty'> <i>Please provide email address</i> </span>");
						$("span").hide();
						var username = $("#username").val();
						var email_format = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
						var password = $("#password").val();
						var cpassword = $("#cpassword").val();
						var email = $("#email").val();
						var User_name_format = /^[A-Za-z0-9]+$/;
						var firstname = $("#firstname").val();
						var lastname = $("#lastname").val();
						if (username == "" || password == "" || email == "" || firstname == "" || (!User_name_format.test(username)) || (password.length < 8)
								|| (!email_format.test(email)) || (password != cpassword)) {
							if (username == "") {

								$("#user_empty").show().addClass('error');

							}

							else if (!User_name_format.test(username)) {
								$("#user_error").show().addClass('error');
							} else {

								$.ajax({
									url : "checkuser.php",
									type : "GET",
									data : {
										username : username
									},
									success : function(data) {
										$("#uname_availability").html(data);
									}
								});
							}

							if (password == "") {

								$("#pass_empty").show().addClass('error');

							}

							else if (password.length < 8) {

								$("#pass_error").show().addClass('error');
							} else {
								$("#pass_ok").show().addClass('ok');
							}
							if (cpassword != password) {
								$("#cpassword").after("<span class='error'>Passwords doesn't match</span>");
							}
							if (firstname == "") {

								$("#firstname").after("<span class='error'>Please provide first name</span>");
							}
							if (email == "") {
								$("#email_empty").show().addClass('error');
							} else if (!email_format.test(email)) {

								$("#email_error").show().addClass('error');
							}

							else {
								$.ajax({
									url : "checkemail.php",
									type : "GET",
									data : {
										email : email
									},
									success : function(data) {
										$("#email_availability").html(data);
									}
								});

							}
						} else {
							var username = $("#username").val();
							var password = $("#password").val();
							var email = $("#email").val();
							var first_name = $("#firstname").val();
							var last_name = $("#lastname").val();
							$.ajax({
								url : "insertdata.php",
								type : "GET",
								data : {
									username : username,
									firstname : first_name,
									lastname : last_name,
									email : email,
									password : password
								},
								success : function(data) {
									if (data == "Registered successfully") {
										$("#name_availability").html(data);
									}
								}
							});
						}
					});
		});
