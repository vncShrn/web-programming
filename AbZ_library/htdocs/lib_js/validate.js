// Wait for the DOM to be ready
$(function() {
	
	// Initialize form validation on the registration form.
	// It has the name attribute "registration"
	$("form[name='signup']").validate({
		rules : {
			password : {
				required : true,
				minlength : 5,
				maxlength : 15,
				pwcheck : true
			},
			cpassword : {
				equalTo : "#password",
				minlength : 5,
				maxlength : 15
			},
			net_id : {
				required : true
			},
			fname : {
				required : true,
				minlength : 2,
				maxlength : 15,
				lettersonly1 : true

			},
			Lname : {
				minlength : 2,
				maxlength : 15,
				required : true,
				lettersonly2 : true
			},
			email_id : {
				required : true,
				emailcheck : true
			},
			contactnum : {
				required : true,
				cnumcheck : true,
				minlength : 10,
				maxlength : 10
			}
		},
		messages : {
			net_id : {
				required : "Please enter your Net-Id"
			},
			password : {
				required : "Please enter your password",
				pwcheck : "Please follow password rules"
			},
			fname : {
				required : "Please enter your first name",
				lettersonly1 : "Please enter letters only"
			},
			Lname : {
				required : "Please enter your last name",
				lettersonly2 : "Please enter letters only"
			},
			email_id : {
				required : "Please enter your email address"
			},
			contactnum : {
				required : "Please enter your contact number",
				cnumcheck : "Please enter numbers only"
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

	$.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Letters only please");

	$.validator.addMethod("pwcheck", function(value) {
		return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only
				// these
				&& /[a-z]/.test(value) // has a lowercase letter
				&& /\d/.test(value) // has a digit
	});

	$.validator.addMethod("lettersonly1", function(value) {
		return /^[A-Za-z\s]*$/.test(value) // consists of only these
	});

	$.validator.addMethod("lettersonly2", function(value) {
		return /^[A-Za-z\s]*$/.test(value) // consists of only these

	});
	$.validator.addMethod("emailcheck", function(value, element) {
		return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
	}, "Please enter a valid email address");

	$.validator.addMethod("cnumcheck", function(value) {
		return /^[0-9]*$/.test(value) // consists of only these
	});
});