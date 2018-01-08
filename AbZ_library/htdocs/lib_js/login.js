// Wait for the DOM to be ready
$(function() {
	
	// Initialize form validation on the registration form.
	// It has the name attribute "registration"
	$("form[name='login']").validate({
		rules : {
			password : {
				required : true,
				minlength : 5,
				maxlength : 15,
				pwcheck : true
			},
			net_id : {
				required : true
			}
		
		},
		messages : {
			net_id : {
				required : "Please enter your Net-Id"
			},
			password : {
				required : "Please enter your password",
				pwcheck : "Please follow password rules"
			}
		},
		submitHandler : function(form) {
			form.submit();
		}
	});
	$.validator.setDefaults({
		debug : true,
		success : "valid"
	});


	$.validator.addMethod("pwcheck", function(value) {
		return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only
				// these
				&& /[a-z]/.test(value) // has a lowercase letter
				&& /\d/.test(value) // has a digit
	});


});