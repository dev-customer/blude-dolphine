
$(document).ready(function() {


	$('#button_reset').click(function(){
		var href = $('#frm_list').attr('action');
		$strAttr = $('.attr-reset').val();
		$.post('ajax.php?module=resetAll', { 'item': $strAttr}, function(data){ 
			window.location = href;
		}); 		
	});
	
	
	$('.chkMaxLength').on("keyup", function() { 
		$max = parseInt($(this).attr('maxlength'));  
		if(parseInt($(this).val().length) >= $max)
		{
			alert('Max string length over '+$(this).val().length+'/'+$max+' character');
			return;
		}
	});
	
	//delete image common
	$('.actDelImgItem').click(function(){
		$src = $(this).attr('data-src');
		$.post( "ajax.php?module=actDelImgItem", {'src': $src}, function(data) {  
			alert('Image deleted!');
			$(this).parent().fadeOut();
		});
	});

	//delete all
	$('.btnDelete').click(function(){ 
		var idChecked = $('input[name="id[]"]:checked').length > 0; 
		if(!idChecked){
			alert('Bạn chưa chọn đối tượng nào');
			return false;
		}else{
				if(confirm('Xóa các đối tượng đã chọn')){
					$('#task').val('delete');
					document.frm_list.submit();
				}
		} 
	});
	
	//limit upload
	$('.maxFileListUpload').change(function(){
		$max = $(this).attr('data-number');
		if($(this)[0].files.length > $max){
			alert('Number file upload maximum >='+$max);
			$(this)[0].value = "";
		} 
	});
	
});





var tbl2 = {
	
	// Action Extend
	saveGlobalAdmin: function(task, title) {
		$msgTxt = '';
		$('.requireData').each(function(index, element) {
			if($(this).val()==''){
				$msgTxt = $msgTxt + $(this).attr('title');
				$(this).addClass('borderRequest bg-danger');  
			}
			else        
				$(this).removeClass('borderRequest bg-danger');  
		});
		
		if($msgTxt=='')
		{
			if($('#task').val()=='')
				$('#task').val(task); 
			document.frm_list.submit();
			return true;
		}
	 
		return false;
	},	
	
}
