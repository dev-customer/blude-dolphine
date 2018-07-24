<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod;    
$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
?>
   
<div class="container-fluid side-main side-detail">
	<div class="container">	   
		<div class="col-sm-3 col-md-3 category-side">
			<?php
				$mod->load('info', 'news', 'newsSide');
			?>
		</div>		 
		<div class="col-sm-9 col-md-9 content-detail">
		<?php
		if(!empty($row))
		{
			?>
			<div class="panel shadow">  
				<div class="clearfix">   
					<ul class="nav nav-tabs" role="tablist">
						 <li role="presentation" class="active"><a href="#description"  role="tab"  data-toggle="tab"><?=LB_DESCRITION?></a></li>
						 <li role="presentation"><a href="#tabLocation" role="tab"  data-toggle="tab"><?=LB_LOCATION?></a></li>
						 <li role="presentation"><a href="#tabUtilitie"  role="tab"  data-toggle="tab"><?=LB_UTILITIES?></a></li>
						 <li role="presentation"><a href="#tabMbda" role="tab"  data-toggle="tab"><?=LB_MBDA?></a></li>
						 <li role="presentation"><a href="#tabCsbh"  role="tab"  data-toggle="tab"><?=LB_CSBH?></a></li>
						 <li role="presentation"><a href="#tabTd"  role="tab"  data-toggle="tab"><?=LB_TD?></a></li>
						 <li role="presentation"><a href="#tabGallery"  role="tab"  data-toggle="tab"><?=LB_GALLERY?></a></li>
					</ul>   
					<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="description">
								<h4 style="margin:inherit" class="clr-sdt1"><?=$title?></h4>
								<?=$row['content_'.$_SESSION['dirlang']]?>
							</div> 
							<div role="tabpanel" class="tab-pane" id="tabLocation">
								<h4 style="margin:inherit" class="clr-sdt1"><?=$title?></h4>
								<?=$row['tabLocation_'.$_SESSION['dirlang']]?>
							</div> 
							<div role="tabpanel" class="tab-pane" id="tabUtilitie">
								<h4 style="margin:inherit" class="clr-sdt1"><?=$title?></h4>
								<?=$row['tabUtilitie_'.$_SESSION['dirlang']]?>
							</div> 
							<div role="tabpanel" class="tab-pane" id="tabMbda">
								<h4 style="margin:inherit" class="clr-sdt1"><?=$title?></h4>
								<?=$row['tabMbda_'.$_SESSION['dirlang']]?>
							</div> 
							<div role="tabpanel" class="tab-pane" id="tabCsbh">
								<h4 style="margin:inherit" class="clr-sdt1"><?=$title?></h4>
								<?=$row['tabCsbh_'.$_SESSION['dirlang']]?>
							</div> 
							<div role="tabpanel" class="tab-pane" id="tabTd">
								<h4 style="margin:inherit" class="clr-sdt1"><?=$title?></h4>
								<?=$row['tabTd_'.$_SESSION['dirlang']]?>
							</div> 
							<div role="tabpanel" class="tab-pane " id="tabGallery">
								<h4 style="margin:inherit" class="clr-sdt1"><?=$title?></h4>
								<?=$row['tabGallery']?>
							</div> 
						</div>
				</div> 
			</div> 
			<?php
		}else{
			echo '<div  class="alert alert-danger">'.LB_NO_RESULT.'</div>';
		}
		?>
		</div>
	</div>
	
    <div class="container">
		<div class="spacer10"></div>
		<div class="panel panel-group">		 
			<div class="panel-heading text-center">
				<h1 class="panel-title">DỰ ÁN CÙNG LOẠI</h1>
				<img class="" src="<?=TEMPLATE?>images/line-head.png" alt="..." title="" />
			</div>
			<div class="panel-body">					 		 
				<?php				 
				$sqlExt = ' AND c.alias <> "'.$_GET['id'].'" AND c.id_cat = '.$row['id_cat'];
				$data = loadListInfo('', $sqlExt, '', 8); //limit item home				
				foreach($data['rows'] as $key => $row):  
					$link = $row['link'] != '' ? $row['link'] : LINK_INFO_ITEM.$row['alias'].'.html';
					$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']); 
					if($title !=''): ?>	 
						<div class="col-sm-6 col-md-3 text-center">
							  <div class="thumbnail zoomItemImg">  	
								<?php
								 if (strpos($link, 'youtube') > 0) { ?>
									 <div class="embed-responsive embed-responsive-4by3">
										<iframe class="embed-responsive-item" src="<?=$link?>"></iframe>
									</div>	
								 <?php
								 }else{ ?>
									<a href="<?=$link?>">
										<?=
										showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', $title, $title, 'img-responsive', 'style="width:100%"');
										?>
									</a>
								 <?php
								 } 
								 ?>
							  </div>
							  <div class="caption clearfix">
								<h5><a href="<?=$link?>"><?=$title?></a></h5>
								<p class="clr-sdt1 priceFormat txtPrice hidden"><?=$row['price']?></p> 
							  </div>							
						</div>
					<?php
					endif;
				endforeach;
				?> 	 
			</div>
		</div>	
	</div>
	
</div> 


<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>js/lightslider/lightslider.min.css">
<script src="<?=TEMPLATE?>js/lightslider/lightslider.min.js"></script>  
<script language="javascript" type="text/javascript">
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
			},
			zoom: {
				enabled: true,
				duration: 500 // don't foget to change the duration also in CSS
			},
			closeMarkup: '<button title="%title%" class="mfp-close img-circle" style="padding-right:inherit">x</button>',
			
		});
	});
</script>
