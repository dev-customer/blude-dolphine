<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $contact; 
$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
$mtitle = $json->getDataJson1D($row['mtitle'], $_SESSION['dirlang']);
$mlink = LINK_SHOP_MANUFACT_ITEM.$row['malias'].'.html';
$ctitle = $json->getDataJson1D($row['ctitle'], $_SESSION['dirlang']);
$tmp = explode('watch?v=', $row['link']); 
$price2 = discountPrice($row['price'], $row['discount']);

//var_dump($_SESSION['cart']);

?>
<style>
#lightSlider > li{text-align:center}
#lightSlider > li img{ margin:auto}
.lSSlideWrapper, .lSPager{ width:100% !important  }
.summary-right .list-group-item{border:0}
.modal-content, .modal-footer{background-color:#fff !important}

.p-desc .nav-tabs>li>a{ font-size:13px}
</style> 
<script>
$(document).ready(function(){ 
	$(function() {
		 
		$('.fa-plus').click(function(){
				$("#number").val(parseFloat($("#number").val())+1);
		});
		$('.fa-minus').click(function(){
				$("#number").val(parseFloat($("#number").val())-1);
		});
		
	});	
}); 
</script>
<div class="container-fluid side-main side-detail">
    <div class="container">
		<div class="panel panel-default clearfix">
			<div class="">
				<div class="clearfix">
					   <div class="col-md-5 summary-left" style="padding:0">
							<ul id="lightSlider">  
								<li data-thumb="<?=URL_UPLOAD.'shop/'.$row['image']?>" data-src="<?=URL_UPLOAD.'shop/'.$row['image']?>">
									<a href="<?=URL_UPLOAD.'shop/'.$row['image']?>" data-lightbox="example-set" title="<?= $title?>">
									<?=
									showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", 'img-responsive', 'id="zoom" data-zoom-image="'.URL_UPLOAD.'shop/'.$row['image'].'"');
									?>
									</a>
									<script>
										$('#zoom').elevateZoom({
											scrollZoom : false,
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
											$('#zoom').elevateZoom({
												scrollZoom : false,
												zoomWindowFadeIn: 500,
												zoomWindowFadeOut: 750
										   }); 
										</script>												
									</li>                                
								<?php         
								}?>	                          
							</ul>
					   </div>
					   <div class="col-md-7 summary-right"> 
							<ul class="list-group">
								<li class="list-group-item"><h3 class="text-uppercase clr-sdt1" style="margin-top:0px"><?=$title?></h3></li>
								<li class="list-group-item">Thương hiệu: <a href="<?=$mlink?>" class="clr-sdt1"><?=$mtitle?></a></li> 
								<li class="list-group-item">
									<div class="fb-like" data-href="<?=$mod->curPageURL()?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>								
								</li>
							</ul>
							<div class="col-md-8">
								<li class="list-group-item">
									<?php
									if($row['discount']>0){?>
										<h4 class="clearfix">
											<b>GIÁ : </b>
											<del class="col-md-12 text-left" style="padding:0"><span class="priceFormat discountPrice"><?=$row['price']?></span></del> 
											<div class="col-md-12" style="padding:0"><span class="priceFormat"><?=$price2?></span></div>
											<div class="col-md-12" style="padding-top:20px;">(Tiết kiệm <span class="priceFormat"><?=$row['price']-$price2?></span>)</div>
										</h4> 
									<?php	
									}else{?>
									<h4>GIÁ : </b></h4>
										<h3>
											<span class="priceFormat"><?=$row['price']?></span>
										</h3> 
									<?php	
									}
									?>  
								</li>
								
								<!-- color -->
								<?php
								if($row['jsColorGroup'] !=''):
								?>
								<li class="list-group-item clearfix">
									<span>Màu sắc</span>
									<ul class="list-inline colorSelect">                       
										<?php
										$imageList =json_decode($row['jsColorGroup']);
										foreach($imageList as $key => $value):
											
											$color = 'color';
											$image = 'image';
											
											$imgUrl = is_file(DIR_UPLOAD.'/shop/'.$value->$image)? URL_UPLOAD.'shop/'.$value->$image : URL_UPLOAD.'no-image.png';?>
											<li class="col-md-3"> 
																								<div class=""><img class="pointer reloadImg img-rouned" data-option="<?=$value->$color?>" src="<?=$imgUrl?>" /> </div>
												

												<!--
												<div class="pointer reloadImg img-rouned text-center" data-option="<?=$value->$color?>"  style="background-color: <?=$value->$color?>; width:40px; height:40px">
													<input type="radio" name="color" class="reloadColor" />	
												</div>
												-->
											</li>                                
										<?php         
										endforeach;
										?>	
									</ul>
									<script type="text/javascript">
										$(document).ready(function() {
											$(".reloadImg").click(function(){ 
												$('.reloadImg').removeClass('active');
												$(this).addClass('active');
												$('.imgDetailLagre').attr('src', $(this).attr('src'));
												$('.imgDetailLagre').attr('data-option', $(this).attr('data-option'));
												$('.btn-addcart<?=$row['id_product']?>').attr('data-color', $(this).attr('data-option'));
											});
										});
									</script>
									<style>
									.colorSelect li img.active{box-shadow: 2px 2px 2px #e6cf0e; border-radius: 5px;} 
									</style>  						
								</li>	
								<?php
								endif;
								?>
								<!-- size -->
								<?php
								if($row['jsSizeGroup'] !=''):
								?>
								<li class="list-group-item clearfix">
									<span>Size</span>
									<ul class="list-inline sizeSelect bg-info">                       
										<?php
										$imageList =json_decode($row['jsSizeGroup']);
										foreach($imageList as $key => $value):
											
											$size = 'size';											
											?>
											<li class="col-md-3 text-uppercase"> 
												<input type="radio" name="size" class="reloadSize" value="<?=$value->$size?>" /> <span><?=$value->$size?></span>	
											</li>                                
										<?php         
										endforeach;
										?>	
									</ul>
									<script type="text/javascript">
										$(document).ready(function() {
											$(".reloadSize").click(function(){  										 
												$('.btn-addcart<?=$row['id_product']?>').attr('data-size', $(this).val());
											});
										});
									</script>
									<style>.sizeSelect li img.active{box-shadow: 2px 2px 2px #e6cf0e; border-radius: 5px;} </style>  						
								</li>								
								<?php
								endif;
								?>
								<li class="list-group-item">
										<span>Số lượng </span>
									<div class="input-group col-md-4">
										<div class="input-group-addon"><i class="pointer  fa fa-minus"></i></div>
										<input class="form-control" name="number" id="number" min="1" max="50" placeholder="Số lượng"  value="1"/> 
										<div class="input-group-addon"><i class="pointer  fa fa-plus"></i></div>
									</div>
								</li>
								<li class="list-group-item text-uppercase">   
									<div class="col-md-6"><a class="btn bg-sdt1 btn-addcart btn-addcart<?=$row['id_product']?>" data-color="" data-size="" data-id="<?=$row['id_product']?>" style="width: 100%;"><h4><span class="glyphicon glyphicon-shopping-cart" title=""></span><?=BTN_ADDCARD2?></h4></a></div>
								</li>
							</div>
							<div class="col-md-4">
								<div class="panel" style="background-color: #f2f2f2; padding: 5px 15px;color: #212121;">
									<span style="padding: 10px 0px;"><i style="margin-top: 5px" class="fa fa-phone"></i> Liên hệ : <br /><?=filter_var($contact['tel'], FILTER_SANITIZE_NUMBER_INT)?></span>
									<span style="padding: 10px 0px;"><i style="margin-top: 5px" class="fa fa-asterisk"></i> Được bán bởi : <br /> <a href="<?=$mlink?>" class="clr-sdt1"><?=$mtitle?></a></span>
								</div>
								<div class="panel bg-info">
									<div class="panel-body">
										<?=$row['summary_'.$_SESSION['dirlang']]?>
									</div>
								</div>
							
							</div> 
							
						</div>  
				</div>
			</div>
		</div>
		<hr style="border-top:0"/>
		<div class="panel clearfix p-desc">
			<div class="col-md-7">
				<div class="clearfix" style="border-top:1px solid #ddd; padding-top:5px">	  
					<ul class="nav nav-tabs text-uppercase" role="tablist">
						 <li role="presentation" class="active"><a href="#description" data-toggle="tab">Chi tiết</a></li>
						 <li role="presentation"><a href="#shipper" data-toggle="tab">Đặt hàng & Giao hàng</a></li>
						 <li role="presentation"><a href="#warranty" data-toggle="tab">Bảo hành & đổi trả</a></li>
						 <li role="presentation"><a href="#vip" data-toggle="tab">ĐÁNH GIÁ CỦA KHÁCH HÀNG</a></li>
					</ul>   
					<div class="tab-content panel panel-default">
						<div role="tabpanel" class="tab-pane active" id="description">
							<?=$row['description_'.$_SESSION['dirlang']]?>
						</div> 	
						<div role="tabpanel" class="tab-pane" id="shipper">
							
							
						</div>			
						<div role="tabpanel" class="tab-pane" id="warranty">
							
							
						</div>			
						<div role="tabpanel" class="tab-pane" id="vip">
							
							
						</div>			
					</div>                                                       
				</div> 
				<div>
					<div class="fb-comments" data-href="<?=$mod->curPageURL()?>" data-numposts="5"></div>				
				</div>
			</div>
			<div class="col-md-5" style="border-top:1px solid #ddd; padding-top:5px">
				<div class="panel-heading text-uppercase">
					<h4>Sản phẩm tương tự</h4> 
				</div> 
				
				<ul class="list-group list-unstyled">					 		 
					<?php  
					$sqlExt = ' AND p.publish = 1 AND p.id_product <> "'.$row['id_product'].'" AND p.id_cat = '.(int)$row['id_cat'];
					$rows = loadListShop('', $sqlExt, '')['rows']; 
					foreach($rows as $key => $row):  
						$link  = LINK_SHOP_ITEM.$row['alias'].'.html';
						$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
						$price2 = discountPrice($row['price'], $row['discount']);?> 
						<li class="col-md-6 "> 
							<div class="site" style="position:relative">
								<span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span>
								<div class="thumbnail">
									<a href="<?=$link?>" class="site-thumb"> 
										<?=
										showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:170px "');
										?> 
									</a>  
								</div> 	
								<div class="caption text-center">
									<h5><a class="text-uppercase" href="<?=$link?>"><?=$title?></a></h5>
									<?php
									if($row['discount']>0){?>
										<div>
											<del class="col-md-6 text-right" style="padding:0"><span class="priceFormat discountPrice"><?=$row['price']?></span></del> 
											<span class="col-md-6 priceFormat" style="padding:0"><?=$price2?></span>
										</div> 
									<?php	
									}else{?>
										<div>
											<span class="priceFormat"><?=$row['price']?></span>
										</div> 
									<?php	
									}
									?> 
								</div>
							</div>							 		
						</li>	 
						
						<?php
					endforeach; 
					?> 	 
				</ul> 
			</div>
		</div> 
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
        auto: false,
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
			mainClass: 'mfp-img-mobile wow zoomIn',
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

<link href="<?=TEMPLATE?>js/youtube-Video/css/YouTubeDefaultImageLoader.css" rel="stylesheet" type="text/css">
<script src="<?=TEMPLATE?>js/youtube-Video/js/YouTubeDefaultImageLoader.js"></script>

<div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
		<div id="videoModalContainer"> 
		</div>
	  </div>
	  <div class="modal-footer">
		<button id="CloseModalButton" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>