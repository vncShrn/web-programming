$(document).ready(function(){
	$('#signup-button').click(function(){
 
    //check the form is not currently submitting
	var sign_form=	document.forms["newsletter-signup"];
    if($(sign_form).data('formstatus') !== 'submitting'){
 
         //setup variables
         var form = $(sign_form),
         formData = form.serialize(),
         formUrl = form.attr('action'),
         formMethod = form.attr('method'), 
         responseMsg = $('#signup-response');
         var email_val = $("#signup-email").val();
 
         //add status data to form
         form.data('formstatus','submitting');
 
         //show response message - waiting
         responseMsg.hide()
                    .addClass('response-waiting')
                    .text('Please Wait...')
                    .fadeIn(200);
 
         //send data to server for validation
         $.ajax({
             url: "signmeup.php",
             type: "POST",
             data: {signup_email:email_val},
             success:function(data){
            	 
                //setup variables
                var responseData = jQuery.parseJSON(data), 
                    klass = '';
 
                //response conditional
                switch(responseData.status){
                    case 'error':
                        klass = 'response-error';
                    break;
                    case 'success':
                        klass = 'response-success';
                    break;  
                }
 
                //show reponse message
                responseMsg.fadeOut(200,function(){
                   $(this).removeClass('response-waiting')
                          .addClass(klass)
                          .text(responseData.message)
                          .fadeIn(200,function(){
                              //set timeout to hide response message
                              setTimeout(function(){
                                  responseMsg.fadeOut(200,function(){
                                      $(this).removeClass(klass);
                                      form.data('formstatus','idle');
                                  });
                               },3000)
                           });
                });
           },
			error : function() {
                //show reponse message
                responseMsg.fadeOut(200,function(){
                   $(this).removeClass('response-waiting')
                          .addClass("error")
                          .text("Error calling POST php")
                          .fadeIn(200,function(){
                              //set timeout to hide response message
                              setTimeout(function(){
                                  responseMsg.fadeOut(200,function(){
                                      $(this).removeClass(klass);
                                      form.data('formstatus','idle');
                                  });
                               },3000)
                           });
                });
			}
      });
    }
 
    //prevent form from submitting
    return false;
     
    });
});