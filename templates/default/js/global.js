$(document).ready(function(e){
	$('.priceFormat').priceFormat({
		clearPrefix: true,
		suffix: ' VNĐ',
		centsLimit: 0,
		centsSeparator: ',',
		thousandsSeparator: '.'
	}); 
	
	$('.txtFormatPhone').text(function(i, text) {  
		return text.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/, '$1-$2-$3');
	});

	$('body').on('click', '.btn-addcart', function (e) {  
		$id = $(this).attr('data-id'); 
		$number = $('#number').val(); 
		$color  = $(this).attr('data-color'); 
		$size = $(this).attr('data-size'); 
		$.post( "ajax/ajax.php?module=addCartShop", {'id': $id, 'number': $number, 'color': $color, 'size': $size}, function( data ) { 
			$('#myModal').modal('show');
			$('#myModal').find('.modal-content').html(data);
		});
		return false;
	});
	
	$('body').on('click', '.delete-cart', function (e) {
		$id = $(this).attr('data-id');
		$.post( "ajax/ajax.php?module=deleteItemCartShop", {'id': $id}, function( data ) {
			$('#product-item-'+$id).fadeOut();
		});
	});

	$('.navbar .dropdown').hover(function() {
		$(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
	}, function() {
		$(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
	}); 
	
	$('.nav-tabs > li>a').removeClass('bg-sdt1');
	$('.nav-tabs > li.active>a').addClass('bg-sdt1');
 	
 	// clear event zoom image product
 	clearEventZoomImageProductOnMobile();
});

function clearEventZoomImageProductOnMobile() {
	var windowScreen = $(window).width();

	if (windowScreen > 992) {
		$('#zoom').elevateZoom({scrollZoom : true});
	} else {
		$('#zoom').elevateZoom({scrollZoom : false});
	}
}

$(document).scroll(function(e){
	/*
    var scrollTop = $(document).scrollTop();
    if(scrollTop > 0){
        //console.log(scrollTop);
		$('.navbar > div').addClass('container');
        $('.navbar').removeClass('navbar-static-top').addClass('navbar-fixed-top bg-sdt1');
		//$('.navbar-fixed-top li.active a').addClass('bg-sdt2');
    } else {
        $('.navbar > div').removeClass('container');
		$('.navbar').removeClass('navbar-fixed-top bg-sdt1').addClass('navbar-static-top');
		//$('.navbar li.active a').removeClass('bg-sdt2');
    }
	*/
});