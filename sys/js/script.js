// Javascript code 
// Javascript for TBL
var tbl = {
	
	// Action
	deleted: function(task, title, request) {
		$flag=0;
		$("input:checkbox[name=id[]]:checked").each(function(){
			if($(this).val())
				$flag =1;
		 });	
		if($flag==1){
			if(confirm(title)) {
				$('#task').val(task);
				document.frm_list.submit();
				return true;
			}
			else 
				return false;
		}else
			alert(request);
	},
	
	duplicate: function(task, title, request) {
		$flag=0;
		$("input:checkbox[name=id[]]:checked").each(function(){
			if($(this).val())
			$flag =1;
		 });	
		if($flag==1){
			$('#task').val(task);
			document.frm_list.submit();
			return true;
		}else
			alert(request);
	},
	
	publish: function(task, title, request) {
		$flag=0;
		$("input:checkbox[name=id[]]:checked").each(function(){
			if($(this).val())
			$flag =1;
		 });	
		if($flag==1){
			$('#task').val(task);
			document.frm_list.submit();
			return true;
		}else
			alert(request);
	},
	
	save: function(task, title) {
		$array_msg = '';
		var list = $('#fieldrequest').val().split('-');
		$.each(list, function() {
			if($('#'+this).val()==''){
				$array_msg +="\n"+$('#'+this).attr('title');
				$('#'+this).addClass('borderRequest');
			}else
				$('#'+this).removeClass('borderRequest');
	   });
				
		if($array_msg=='') {
			if($('#task').val()=='')
				$('#task').val(task); 
			document.frm_list.submit();
			return true;
		}
		return false;
	},	
	
	
	
	button: function(href) {
		document.frm_list.action = href;
		document.frm_list.submit();
		return true;
	}
	
}
///Load ajax type
function remove(href,title)
{ 
	if(confirm(title)) {// alert($('#frm_list').attr('action'));
			document.frm_list.action = href;
			document.frm_list.submit();
			return true;
		}
		else {
			return false;
		}
}

//submit upload
function submitUpload(page){
	var order_number=document.getElementById('order_number').value;
	var filmid=document.getElementById('filmid').value;
	var videofile=document.getElementById('videofile').value;
	var dataString = 'order_number='+ order_number +'&filmid='+filmid+'&videofile='+videofile;	
	
	$(function() {
		$(".button").click(function() {
			var order_number = $("input#order_number").val();  
			if (order_number == "") {  
				$("input#order_number").style.background="#FFFFCC";
				$("input#order_number").focus();  
				return false;  
			}  
		});
	});
	
	$.ajax({
		type: "POST",
		url: "ajax.php?p="+page,
		data: dataString,
		success: function(msg) {
			$('.content').html(msg);					
		}
	});
	return false;	
}


function keypress(e, msg){
	//Hàm dùng để ngăn người dùng nhập các ký tự khác ký tự số vào TextBox
	var keypressed = null;

    if (window.event)
    {
    	keypressed = window.event.keyCode; //IE
    }
    else
    {
    	keypressed = e.which; //NON-IE, Standard
    }

    if (keypressed < 48 || keypressed > 57)
    { //CharCode của 0 là 48 (Theo bảng mã ASCII)
    //CharCode của 9 là 57 (Theo bảng mã ASCII)

        if (keypressed == 8 || keypressed == 127)
        {//Phím Delete và Phím Back
        	return;
        }
		alert(msg);
    	return false;
    }
}

function Ordering(field, type){
		$('#order').val(field);
		$('#ordertype').val(type);
		document.frm_list.submit();
}

// 
$(document).ready(function() {
	// check delete
	$('.delete').click(function() { 
		var msg = $('.delete').attr('title');
		if(confirm(msg))
			return true;
		return false;
	});
	
	$('.button').click(function(){
		$('.tblList').hide();
		$('.tblList').fadeIn(2000);
	});
	
  
	$('#button_search').click(function(){ 
		if($('#search').val()=='')
			$('#search').addClass('bg-danger').attr('placeholder', 'Type keywords...');
		else
			document.frm_list.submit();
	});
	
	// submit form list: all module
	$('.submitform').click(function(){
		$('#task').val('orderring');
		document.frm_list.submit();
		return true;
	});

	// hover tr table tblList : all module
	$(".tblList tbody tr").each(function(){
		$(this).find('td').find('input[type=number]').click(function(){
			$(this).parent().parent().find('input:checkbox').attr('checked', true);
		});
	});
	
	// subport select muliti row--------------------------------------
	var lastChecked = null;
	var $chkboxes = $('.chkbox');
	$chkboxes.click(function(event) {
		if(!lastChecked) {
			lastChecked = this;
			return;
		}

		if(event.shiftKey) { 
			var start = $chkboxes.index(this);
			var end = $chkboxes.index(lastChecked);
			$chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', lastChecked.checked);
		}
		lastChecked = this;
	});

});


$.tabs = function(selector, start) {
	$(selector).each(function(i, element) {
		$($(element).attr('tab')).css('display', 'none');
		$(element).click(function() {
			$(selector).each(function(i, element) {
				$(element).removeClass('selected');
				
				$($(element).attr('tab')).css('display', 'none');
			});
			
			$(this).addClass('selected');
			
			$($(this).attr('tab')).css('display', 'block');
		});
	});
	
	if (!start) {
		start = $(selector + ':first').attr('tab');
	}

	$(selector + '[tab=\'' + start + '\']').trigger('click');
};

$(document).ready(function(){

	$(".tblList tbody tr").each(function(){
			$(this).mouseenter(function(){  
				$(this).css({'color':'red', 'font-weight':'bold'});
			}); 
			$(this).mouseout(function(){  
				$(this).css('color','black');
			}); 
			
	});
	
});