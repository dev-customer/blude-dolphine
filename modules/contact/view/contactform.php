<?php if(!defined('DIR_APP')) die('You have not permission');
global $contact;
?>
<script>
$(document).ready(function($){   
	//send data   
	$(".frmContact").on('submit', (function(e) {
		
		$msgTxt = '';
		$('.frmContact .requireData').each(function(index){
			if($(this).val()==''){
				$(this).addClass('alert-danger');
				$msgTxt = $msgTxt + $(this).attr('placeholder');
			}
		});
		
		if($msgTxt=='')
		{	
			$.ajax({
				url: "ajax/ajax.php?module=sendContact", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					$('.frmContact .frmMsg').removeClass('alert-danger').addClass('bg-sdt2').text('Send!').fadeIn();
					$('.frmContact .btn-send').attr('disabled','disabled');
					//alert(data);
				}
			}); 
		} 
		
		return false;
	}));  
});
</script>

<div class="container-fluid side-contact side-detail">
	<div class="container">	  
		<div class="panel"> 			 
			  <div class="col-sm-6 col-md-6 shadow">
				
				<form class="frmContact" role="form" method="post" action=""> 
					
					<div class="frmMsg alert" style="display:none"></div>
					
					<div class="form-group">
						<label class="hidden"><span class="glyphicon glyphicon-user clr-sdt1"></span> <?=NAME?></label>
						<input name="ctname" class="requireData form-control"  placeholder="<?=NAME?>" required>
					</div>
					<div class="form-group">
						<label class="hidden"><span class="glyphicon glyphicon-envelope clr-sdt1"></span> Email</label>
						<input name="ctemail"  type="email" class="requireData form-control"  placeholder="Email" required>
					</div> 
					<div class="form-group">
						<label class="hidden"><span class="glyphicon glyphicon-earphone clr-sdt1"></span> <?=PHONE?></label>
						<input name="ctphone" class="requireData form-control"  placeholder="<?=PHONE?>" required>
					</div> 
					<div class="form-group">
						<label class="hidden"><span class="glyphicon glyphicon-comment clr-sdt1"></span> <?=MESSAGE?></label>
						<textarea rows="6" name="ctcontent" class="requireData form-control" placeholder="<?=MESSAGE?>"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn bg-sdt1 btn-send"><span class="glyphicon glyphicon-arrow-right"></span> <?=SEND?></button>
						<button type="reset" class="btn bg-sdt1"><span class="glyphicon glyphicon-refresh"></span> <?=RESET?></button>
					</div> 
				</form>
				<div class="spacer10 clearfix"></div>				
			  </div>
		  
			  <div class="col-sm-6 col-md-6 google-maps"> 
				<div class="embed-responsive embed-responsive-4by3">
					<iframe class="embed-responsive-item" src="<?=$contact['linkMaps']?>"  height="495" frameborder="0" style="border:0" allowfullscreen=""></iframe>
				</div>
			  </div>
			 
		</div>
	</div>
</div>
