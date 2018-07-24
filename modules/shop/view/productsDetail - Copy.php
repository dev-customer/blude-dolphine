<?php if(!defined('DIR_APP')) die('You have not permission');
global $json; 
$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
$ctitle = $json->getDataJson1D($row['ctitle'], $_SESSION['dirlang']);
?>
<style>
#lightSlider > li img{ margin:auto}
.lSSlideWrapper, .lSPager{border:1px solid #ccc;  }
</style> 
<div class="container-fluid side-main side-detail">
    <div class="container">
		<div class="panel panel-default">	 
			<div class="clearfix">
				   <div class="col-md-6 summary-left">
						<ul id="lightSlider">  
							<li data-thumb="<?=URL_UPLOAD.'shop/'.$row['image']?>" data-src="<?=URL_UPLOAD.'shop/'.$row['image']?>">
								<a href="<?=URL_UPLOAD.'shop/'.$row['image']?>" data-lightbox="example-set" title="<?= $title?>">
								<?=
								showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", 'img-responsive', 'id="zoom" data-zoom-image="'.URL_UPLOAD.'shop/'.$row['image'].'"');
								?>
								</a>
								<script>
									$('#zoom').elevateZoom({
										zoomType: "inner",
										cursor: "crosshair",
										zoomWindowFadeIn: 500,
										zoomWindowFadeOut: 750
								   }); 
								</script>
							</li>
							<?php
							$imageList =json_decode($row['imageList']);
							foreach($imageList as $key => $value){
								$imgUrl = is_file(DIR_UPLOAD.'/shop/'.$value)? URL_UPLOAD.'shop/'.$value: URL_UPLOAD.'no-image.png';?>
								<li data-thumb="<?=$imgUrl?>" data-src="<?=$imgUrl?>">
									<a href="<?=$imgUrl?>" data-lightbox="example-set" title="<?= $title?>">
									<?=
									showImg(DIR_UPLOAD.'/shop/'.$value, 'shop/'.$value, 'no-image.png', '', '', "", "", '', 'id="zoom'.$key.'" data-zoom-image="'.URL_UPLOAD.'shop/'.$value.'"');
									?>
									</a>
									<script>
										$('#zoom<?=$key?>').elevateZoom({
											zoomType: "inner",
											cursor: "crosshair",
											zoomWindowFadeIn: 500,
											zoomWindowFadeOut: 750
									   }); 
									</script>													
								</li>                                
							<?php         
							}?>	                          
						</ul>
				   </div>
				   <div class="col-md-6 summary-right"> 
						<ul class="list-group">
							<li class="list-group-item"><h3 class="clr-sdt2" style="margin-top:0px"><?=$title?></h3></li>
							<li class="list-group-item">Mã SP: <?=$row['code']?></li> 
							<li class="list-group-item">Giá: <span class="<?=$row['price'] >0 ? 'priceFormat':''?>"><?=$row['price'] >0 ? $row['price'] : 'Liên hệ'?></span></li>
							<li class="list-group-item">Sơ lược:<br/>  
								<?=$row['summary_'.$_SESSION['dirlang']]?>												
							</li> 
							<li class="list-group-item"> 
								<div class="col-md-5 input-group">
									<span class="input-group-addon hidden">Số lượng </span>
									<input type="number" name="number" id="number" min="1" max="50" class="form-control" placeholder="Số lượng"  value="1"/> 
									<a class="btn bg-sdt1 btn-addcart input-group-addon bg-sdt1" data-id="<?=$row['id_product']?>"><?=BTN_ADDCARD?> <span class="glyphicon glyphicon-shopping-cart" title=""></span></a>
								</div>
							</li>
						</ul>
					</div>  
			</div>
			<br/> 
			<div class="clearfix">	  
				<ul class="nav nav-tabs" role="tablist">
					 <li role="presentation" class="active"><a href="#description" data-toggle="tab">Mô tả</a></li>
					 <!--<li role="presentation"><a href="#parameter" data-toggle="tab">Thông tin sản phẩm</a></li>-->
				</ul>   
				<div class="tab-content panel panel-default">
					<div role="tabpanel" class="tab-pane active" id="description">
						<?=$row['description_'.$_SESSION['dirlang']]?>
					</div>
					<!--
					<div role="tabpanel" class="tab-pane" id="parameter">
						<?=$row['parameter_'.$_SESSION['dirlang']]?>
					</div>
					-->					
				</div>                                                       
			</div>  
		</div> 
	</div>
	 
    <div class="container">
		<hr />
		<div class="panel">		 
			<div class="panel-heading text-center">
				<h1 class="panel-title text-uppercase" style="float:inherit; margin:auto; "><?=LB_RELATION?></h1>
			</div>
			<div class="group-list">					 		 
				<?php  
				$sqlExt = ' AND p.publish = 1 AND p.alias <> "'.$_GET['id'].'" AND p.id_cat = '.(int)$row['id_cat'];
				$rows = loadListShop('', $sqlExt, '', 8)['rows']; 
				foreach($rows as $key => $row):  
					$link  = LINK_SHOP_ITEM.$row['alias'].'.html';
					$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
					?>
					
					<div class="col-md-3"> 
						<div class="site">
							<div class="thumbnail">
								<a href="<?=$link?>" class="site-thumb">
									<div class="site-metrics">
										<div class="inner">
											<div class="site-stats">
												<span><i class="fa fa-link"></i></span>
											</div>
										</div>
									</div>								
									<?=
									showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:'.$mod->config['imageShop'].'px"');
									?> 
								</a>  
							</div> 	
							<div class="caption text-center">
								<h5><a class="text-uppercase" href="<?=$link?>"><?=$title?></a></h5>
								<p>
									<span class="<?=$row['price'] >0 ? 'priceFormat':''?>"><?=$row['price'] >0 ? $row['price'] : MENU_CONTACT?></span>											
								</p> 
								<p class="">
									<a class="btn bg-sdt1 btn-addcart " data-id="<?=$row['id_product']?>" href="#"><?=LB_ORDER?> <i class="fa fa-cart-plus" aria-hidden="true"></i></a>									
								</p>
							</div>
						</div>									
					</div>	 
					
					<?php
				endforeach; 
				?> 	 
			</div>
		</div>	
		<hr />
	</div> 
</div> 
 
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>js/lightslider/lightslider.min.css">
<script src="<?=TEMPLATE?>js/lightslider/lightslider.min.js"></script>  

<script type="text/javascript">
$(document).ready(function() {
    $("#lightSlider").lightSlider({
        item: 1,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 0,
 
        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////
 
        speed: 400, //ms'
        auto: true,
        loop: false,
        slideEndAnimation: true,
        pause: 2000,
 
        keyPress: false,
        controls: true,
        prevHtml: '',
        nextHtml: '',
 
        rtl:false,
        adaptiveHeight:false,
 
        vertical:false,
        verticalHeight:300,
        vThumbWidth:500,
 
        thumbItem:10,
        pager: true,
        gallery: true,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',
 
        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,
 
        responsive : [],
 
        onBeforeStart: function (el) {},
       
	    onSliderLoad: function (el) {
		  el.lightGallery({
                selector: '#lightSlider .lslide'
            });	
		},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {},
		 
    });
});
</script>

<link rel="stylesheet" href="<?=TEMPLATE?>js/magnific/magnific-popup.css">
<script src="<?=TEMPLATE?>js/magnific/jquery.magnific-popup.min.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		
		$('#lightSlider').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					return item.el.attr('title') + '<small></small>';
				}
			}
		});
	});
</script>


 