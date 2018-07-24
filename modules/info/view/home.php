<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $contact, $cNews;  ?>

<div class="container-fluid side-slide" style="position: relative; z-index:0">
		<div id="carousel-example-generic1" class="item carousel slide">			 
			<div class="carousel-inner" role="listbox">
				<?php 
				$sides = $db->loadObjectList('SELECT * FROM #__slide ORDER BY orderring');
				$nav = '';
				foreach($sides as $key => $row):  
					$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
					$nav .= '<li data-target="#carousel-example-generic1" data-slide-to="'.($key).'" class="'.(($key==0)? 'active':'').'"></li>';				
					?>
					<div data-p="225.00" class="item <?=($key==0)? 'active':''?> sl<?=($key+1)?>" data-animation="animated zoomInUp">
						<a href="<?=$row['link']?>"><img style="margin:auto" data-u="image" src="<?=URL_UPLOAD.'slide/'.$row['image']?>" alt="<?=$title?>" title="<?=$title?>" /></a>
					</div>				 
				<?php
				endforeach; 
				?> 
			</div>			
			
			<ol class="carousel-indicators">
				<?=$nav?>
			</ol> 	 
			 
			<a class="left carousel-control" href="#carousel-example-generic1" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic1" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a> 
			
		</div>	
</div> 

<div class="container-fluid side-main side-home ">
	<div class="container group-projects-home">
		<div class="">
			<div class="panel">
				<div class="panel-heading text-center">
					<h2 class="text-uppercase"><?=MENU_PROJECTS?></h2> 
				</div> 
				<div class="panel-body">	 
					<?php
					foreach($cNews as $key => $value):  
						if($value[5] == 130):
							$link  = LINK_INFO_LIST.$value[4].'.html';
							$title = $value[1]; ?>
							
								<div class="col-sm-6 col-md-4"> 
									<div class="thumbnail zoomItemImg">
										<a href="<?=$link?>">
										<?=
										showImg(DIR_UPLOAD.'/content/'.$value[6], 'content/'.$value[6], 'no-image.png', '', '', "", "", '', ' style="max-height:210px"');
										?></a>  
									</div> 	
									<div class="caption" style="height:50px">
										<h4 class="text-center text-uppercase"><a class="clr-sdt1" href="<?=$link?>"><span class="glyphicon glyphicon-equalizer  hidden clr-sdt1"></span> <?=$title?></a></h4>
									</div>	 
								</div>		 
							<?php
						endif;
					endforeach;
					?> 
				</div>
				<style>
				.group-projects-home .panel-body > div:hover a{color:#0170b1} 
				</style> 
			</div>			
		</div>
		
	</div> 
</div> 
<div class="container-fluid side-main side-about-home">
	<div class="container">
		<div class="">
			<div class="panel-heading text-center">
				<h2 class="text-uppercase"><?=MENU_ABOUT?></h2> 
				<img class="" src="<?=TEMPLATE?>images/line-head.png" alt="..." title="" />
				<p></p>				
			</div> 
			<div class="panel-body fadeElem">	 
				<?php		 
				$sqlExt = ' AND  cc.id_cat = 139';
				$rows = loadListInfo('', $sqlExt, '', 3)['rows'];
				$icoList = array('fa-pie-chart','fa-recycle','fa-map-o');
			
				foreach($rows as $key => $row):  
					$link = LINK_INFO_ITEM.$row['alias'].'.html';
					$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']); 
					if($title !=''): ?>	 
						<div class="col-xs-4 col-sm-4 col-md-4"> 
							<div class="item-about" style="width:90%; margin:auto">
								<div class="thumbnail zoomElementInit text-center" style="background:inherit; padding-top: 0;">
									<?=
									showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', "", "", 'img-circle', ' style=" "');
									?> 
								</div> 	
								<div class="caption">
									<h4 class="text-center text-uppercase"><i class="fa <?=$icoList[$key]?> text-left" aria-hidden="true"></i> <a class=""> &nbsp;&nbsp;&nbsp;<?=$title?></a></h4>
									<div style="text-align:justify"><?= $row['content_'.$_SESSION['dirlang']]?></div>
								</div>
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
 
 
 
<div class="container-fluid side-main side-home">
	<div class="container group-news-home">
		<div class="panel">
			<div class="panel-heading text-center">
				<h2 class="text-uppercase"><?=MENU_NEWS?></h2> 
				<img class="" src="<?=TEMPLATE?>images/line-head.png" alt="..." title="" />				
			</div>
			<div class="panel-body fadeElem">
				<?php
				$sqlExt = " AND c.publish = 1 AND c.id_cat = 136"; 
				$rows = loadListInfo('', $sqlExt, '', 4)['rows']; 
				foreach($rows as $key => $row): 
					$link = LINK_INFO_ITEM.$row['alias'].'.html';
					$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
					?>
					<div class="col-xs-3 col-sm-3 col-md-3">
						<div class="thumbnail zoomItemImg zoomElementInit">
							<a href="<?=$link?>" title="<?=$title?>">
							<?=
							showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:170px; width:100%"');
							?></a>  
						</div> 	
						<div class="caption text-center">
							<h5 style="height:20px"><a class=" clr-sdt2" href="<?=$link?>" title="<?=$title?>"><?=$title?></a></h5>
							<p><span class="glyphicon glyphicon-calendar"><?=date('d-m-Y', strtotime($row['date']))?></p>
							<p><?= $mod->cutstring(strip_tags($row['content_'.$_SESSION['dirlang']]), 200)?></p>
							<p><a href="<?=$link?>" class="btn bg-sdt1"> <?=READ_MORE?> ...</a></p>
						</div>	 							
					</div> 
					<?php
				endforeach;
				?>
			</div>
		</div> 
	</div>
</div>


<div class="container-fluid" style="border-top:5px solid #96711f">
	<div class="container">  
		<div class="panel">  			
			<div id="owl-demo-logo" class="owl-carousel">
				<?php						
				$logos = $db->loadObjectList('SELECT * FROM #__logo ORDER BY orderring');	 
				foreach($logos as $key => $row):
				//$link= LINK_INFO_ITEM.$row['alias'].'.html';
				//$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']); 																
				 ?>	 
					<div class=""> 
						<?=
						showImg(DIR_UPLOAD.'/logo/'.$row['image'], 'logo/'.$row['image'], 'no-image.png', '', '', "", "", '', '');
						?>                
					</div>
				<?php
				endforeach;
				?>
			</div> 
			<script type="text/javascript">
				$(document).ready(function() { 
					var owl2 = $("#owl-demo-logo"); 
						owl2.owlCarousel({
						autoPlay: true,
						items : 7, //10 items above 1000px browser width
						itemsDesktop : [1000,5], //5 items between 1000px and 901px
						itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
						itemsTablet: [600,2], //q items between 600 and 0;
						itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option 
						animateOut: 'slideOutDown',
						animateIn: 'flipInX',
					});

					// Custom Navigation Events
					$(".next").click(function(){
					owl2.trigger('owl.next');
					})
					$(".prev").click(function(){
					owl2.trigger('owl.prev');
					})
					$(".play").click(function(){
					owl2.trigger('owl.play',1000);
					})
					$(".stop").click(function(){
					owl2.trigger('owl.stop');
					}) 
				});
			</script>  
		</div>
	</div> 	 
</div>
 
 
<link href="<?=TEMPLATE?>js/owl.carousel/owl.carousel.css" rel="stylesheet">
<link href="<?=TEMPLATE?>js/owl.carousel/owl.transitions.css" rel="stylesheet">
<script type="text/javascript" src="<?=TEMPLATE?>js/owl.carousel/owl.carousel.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() { 
		var owl = $("#owl-demo"); 
		owl.owlCarousel({
			autoPlay:true,
			items : 4, //10 items above 1000px browser width
			itemsDesktop : [1000,5], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
			itemsTablet: [600,1], //q items between 600 and 0;
			itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
		});

		// Custom Navigation Events
		$(".next").click(function(){
			owl.trigger('owl.next');
		})
		$(".prev").click(function(){
			owl.trigger('owl.prev');
		})
		$(".play").click(function(){
			owl.trigger('owl.play',1000);
		})
		$(".stop").click(function(){
			owl.trigger('owl.stop');
		}) 

	});
</script> 

<script type="text/javascript">
	$(document).ready(function() { 
		var owl = $("#owl-demo-logo"); 
		owl.owlCarousel({
			autoPlay:true,
			items : 4, //10 items above 1000px browser width
			itemsDesktop : [1000,5], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
			itemsTablet: [600,1], //q items between 600 and 0;
			itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
		});

		// Custom Navigation Events
		$(".next").click(function(){
			owl.trigger('owl.next');
		})
		$(".prev").click(function(){
			owl.trigger('owl.prev');
		})
		$(".play").click(function(){
			owl.trigger('owl.play',1000);
		})
		$(".stop").click(function(){
			owl.trigger('owl.stop');
		}) 

	});
</script>