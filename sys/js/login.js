$(document).ready(function() { 
	$("#password").keypress(function() {
		if(event.which == 13) loginForm()
	});
	  
	$('.btnLogin').click(loginForm); 
}); 

var loginForm = function()
{ 
	$msg = '';
	$('.frmLogin .requireData').each(function(index, element) {
		if($(this).val()==''){
			$msg = $msg + $(this).attr('title');
			$(this).addClass('requireRed');  
		}else {        
			$(this).removeClass('requireRed');  
		}
	});
	
	if($msg=='')
	{
		var dataString = 'username=' + $('#username').val() + '&password=' + $('#password').val();
		$.ajax({type: "POST", url: "ajax.php?module=logIn", data: dataString, success: function(data) { 
				if(data=='success'){						
					$('.login-form form').hide();
					//$('#error_message').html("Login Success! ").append('<div class="loading_dots "><span></span> <span></span><span></span></div>').hide().fadeIn(1000, function() {});
					$('#error_message').html("Login Success! ").append('<img src="images/Waiting_4.gif" class="img-responsive" />').hide().fadeIn(1000, function() {});
					setInterval(function() { window.location = 'index.php'}, 3000); 
				}else
					$('#error_message').empty().append('Username or password is invaid! <br/> Please login again').fadeIn();						 	
			 }
		});
	}else
		$('#error_message').empty().append('Please type info!').fadeIn();
	
	return false; 
};
