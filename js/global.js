// JavaScript Document
// Javascript code 
// Javascript for TBL
$(document).ready(function(e) {
	//change language
	$('.lang').click(function(){
		$lang = $(this).attr('data-id');  
		$url = $(this).attr('href');
		$.post( "ajax/ajax.php?module=changeLangSite", {'lang': $lang}, function( data ) {
			window.location = $url;
		});
	});
	 
	 
	$('body').on('click', '.btn-newsletter', function (e) { 

		$msgTxt = '';
		$('.frmNewsletter .requireData').each(function(index){
			if($(this).val()==''){
				$(this).addClass('alert-danger');
				$msgTxt = $msgTxt + $(this).attr('placeholder');
			}
		});

		if($msgTxt == '')
		{ 
			$email 		= $('#subscribeEmail').val();
			if(!isValidEmailAddress($email) ) 
			{
				alert('Email không hợp lệ');
				return false; 
			} 
			
			$.post( "ajax/ajax.php?module=sendNewsleter",{'email': $email}, function( data ) { 
				$('#myModal .modal-content').html('<div class="alert alert-info">..Đang gửi dữ liệu...</div><div class="loader"></div>');
				$('#myModal').modal('toggle');
				setInterval(function() {
						if(data=='success'){
							$('#myModal .modal-content').html('<div class="alert alert-info"><span class="glyphicon glyphicon-chevron-down"></span> Đã gửi!</div>');
						}
						else{
							$('#myModal .modal-content').html('<div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span> '+data+'</div>');
						}

						$('#subscribeEmail').val('');
						
						
					setInterval(function() {
						location.reload();
					}, 1000); 
				}, 3000); 
				return false;
			});	  
		} 
		return false;
	}); 
	
	
	$('.pagination > li').each(function(){
		$(this).find('a').addClass('bg-sdt2');
	});

	
});


function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};