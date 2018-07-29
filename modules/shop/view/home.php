<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod, $cNews, $cShop;  

?>

<div class="container-fluid side-slide head-home">
	<div class="container"> 
		<div class="col-md-2 hidden-mobile" style="padding-left:0"> 
			<ul class="list-group category-home">
				<!--
				<li class="list-group-item">
					<h5><a href="<?=BASE_NAME?>sale-off.html"> 
					<?= showImg(DIR_UPLOAD.'/shop/new_mnu1.png', 'shop/new_mnu1.png', 'no-image.png', '', '', "", "", '', ' ');?>							
					Khuyến mãi HOT</a></h5>
				</li>
				-->
				<?php 
				foreach($cShop as $key => $row1):
				if($row1[5]==0):
					$link1 = LINK_SHOP_LIST.$row1[4].'.html';
					$title1 = $row1[1];  
					$cShopSub = getCategoryShop($row1[0], '', '');  
					
					if(count($cShopSub)>0)
					{ ?> 
						<li class="list-group-item dropdown-submenu">
							<h5><a href="<?=$link1?>">					
							<?=$title1?></a></h5>
							<div class="dropdown-menu " style="z-index: 99999999;"> 
								<?php
								foreach($cShopSub as $row2):
									if($row2[5] == $row1[0]):
										$link2  =  LINK_SHOP_LIST.$row2[4].'.html'; 
										$title2 = $row2[1];
										?>
										<div class="col-md-3 panel">
											<div class="">
												<h5 class="panel-title"><a href="<?=$link2?>"><?=$title2?></a></h5>
											</div>
											<ul class="list-group">
												<?php
												$cShopSub3 = getCategoryShop($row2[0], '', '');
												if(count($cShopSub3)>0):
													foreach($cShopSub3 as $row3):														
														$link3  =  LINK_SHOP_LIST.$row3[4].'.html'; 
														$title3 = $row3[1];
														echo '<li class="list-group-item"><a href="'.$link3.'">'.$title3.'</a></li>';
													endforeach;
												endif;
												?>
											</ul>
										</div>
										<?php 
									endif;
								endforeach;
								?> 
							</div>
						</li> 
					<?php	
					}
					else{?>
						<li class="list-group-item">
							<h5><a href="<?=$link1?>">
							<?=$title1?></a></h5>
						</li>			
					<?php
					}
				endif;
				endforeach; ?> 
			</ul> 	
		</div>
		<div class="col-md-7" style="z-index: 2;">
			<div id="carousel-example-generic1" class="carousel slide carousel-fade" style="padding-top:0">			 
				<div class="carousel-inner" role="listbox">
					<?php 
					$sides = $db->loadObjectList('SELECT * FROM #__slide WHERE publish = 1 ORDER BY orderring');
					$nav = '';
					$effArr = array('slideInRight','slideInLeft','fadeInDown');
					foreach($sides as $key => $row):  
						$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
						$nav .= '<li data-target="#carousel-example-generic1" data-slide-to="'.($key).'" class="'.(($key==0)? 'active':'').'"></li>';				
						?>
						<div class="item wow <?=$effArr[$key]?> <?=($key==0)? 'active':''?> sl<?=($key+1)?>" data-wow-duration="1s">
							<a href="<?=$row['link']?>"><img style="margin:auto;height:310px; width:100%" data-u="image" src="<?=URL_UPLOAD.'/slide/'.$row['image']?>" alt="<?=$title?>" title="<?=$title?>" /></a>
						</div>				 
					<?php
					endforeach; 
					?> 
				</div>	 
				<ol class="carousel-indicators">
					<?=$nav?>
				</ol> 	 
			</div>	
		</div>
		<div class="col-md-3 block-member">				
				<?php
				if(empty($_SESSION['id_user_frontend'])){ ?>
					<!--
					<div class="text-center" style="padding: 10px;">
						<img src="<?=TEMPLATE?>images/user.png" />
					</div>
					-->
					<div class="text-left" style="padding: 10px; font-size:17px;">
						<p>Chào mừng các bạn đã ghé thăm website của chúng tôi.</p>
					</div>
					<ul class="list-inline">
					<li><a href="<?=LINK_USER_LOGIN?>">Đăng nhập </a></li>
					<li><a href="<?=LINK_USER_REG?>">Đăng ký </a></li>
					</ul>
				<?php
				}else{	?>
				<ul class="list-inline">
					<li>
						<a href="<?=LINK_USER_ACCOUNT?>"> 
							<?=$account['fulltname']?>
						</a>
					</li>
					<li><a href="<?=LINK_USER_LOGOUT?>">Thoát </a></li>
				</ul>
				<?php
				}?>  
				<hr />
					<div class="tin-khuyen-mai">
					<?php
					foreach($cNews as $key => $value): 
					if($value[0] == 139):
						$cListID = getCategoryInfo($value[0], '', '');
						$cList 	 = categoryToArray($cListID);
						$cList[] = $value[0];  ?> 
						<h4><?=$value[1]?></h4>
						<div class="list-news" style="list-style-type: none;">
							<?php  
							$sqlExt = " AND c.publish = 1 AND c.id_cat IN (".implode(',', $cList).")"; 
							$rows = loadListInfo('', $sqlExt, '', 5)['rows']; 
							foreach($rows as $key => $row):  
								$link = LINK_INFO_ITEM.$row['alias'].'.html';
								$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);   
								if($row['title']): ?>
									<span><a href="<?=$link?>"> <?=$title?></a></span>
								<?php
								endif;							
							endforeach; 
							?>	
						</div>
						<?php
					endif;
					endforeach;
					?>
					</div>
			</ul> 
		</div>
	</div>
</div>

<div class="container-fluid" style="background:#ECECEC;">
	<div class="container">
		<div class="responsiveBanner slider">
				<?php 
				foreach($cShop as $key => $row1):
				if($row1[5]==0):
					$link1 = LINK_SHOP_LIST.$row1[4].'.html';
					$title1 = $row1[1];  
					$cShopSub = getCategoryShop($row1[0], '', '');  
					
					if(count($cShopSub)>0)
					{ ?> 
						<a class="block-category" href="<?=$link1?>">
							<div class="col-md-6 block-category-text"><?=$title1?></div>
							<div class="col-md-6 block-category-img">							<?=
							showImg(DIR_UPLOAD.'/shop/'.$row1[6], 'shop/'.$row1[6], 'no-image.png', '', '', "", "", '', '  style="height:100px"');
							?>	</div>
						</a>
					<?php	
					}
					else{?>
					<a class="block-category" href="<?=$link1?>" target="_blank">
							<div class="col-md-6 block-category-text"><?=$title1?></div>
							<div class="col-md-6 block-category-img">							<?=
							showImg(DIR_UPLOAD.'/shop/'.$row1[6], 'shop/'.$row1[6], 'no-image.png', '', '', "", "", '', '  style="height:100px"');
							?>	</div>	
					</a>
					<?php
					}
				endif;
				endforeach; ?> 
				</div>
		<?php
		foreach($cNews as $key => $value): 
		if($value[0] == 147):
			$cListID = getCategoryInfo($value[0], '', '');
			$cList 	 = categoryToArray($cListID);
			$cList[] = $value[0]; ?> 
	
				<script type="text/javascript">
				$(document).on('ready', function() {
					$('.responsiveBanner').slick({
					  dots: true,
					  infinite: false,
					  speed: 300,
					  slidesToShow: 3,
					  slidesToScroll: 3,
					  autoplay: true,
					  rows: 2,
					  arrows : true,
					  responsive: [
						{
						  breakpoint: 1024,
						  settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
							infinite: true,
							dots: true
						  }
						},
						{
						  breakpoint: 600,
						  settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						  }
						},
						{
						  breakpoint: 480,
						  settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						  }
						}
						// You can unslick at a given breakpoint now by adding:
						// settings: "unslick"
						// instead of a settings object
					  ]
					});
				});
				</script>
			</div>
		<?php
		endif;
		endforeach;
		?>
		
	</div>
</div>


<!-- Group Products Home --> 
<div class="container-fluid  c-product-home">
	<div class="container"> 
	<?php  
	$sqlExt = " AND c.publish = 1 AND c.id_cat = 143"; 
	$rowAds = loadListInfo('', $sqlExt, '', 1)['rows'][0]; 
	$rowAdsLink  = LINK_INFO_ITEM.$rowAds['alias'].'.html';
	$rowAdsTitle = $json->getDataJson1D($rowAds['title'], $_SESSION['dirlang']);

	$sqlExt2 = " AND c.publish = 1 AND c.id_cat = 148"; 
	$rowAds2 = loadListInfo('', $sqlExt2, '', 1)['rows'][0]; 
	$rowAdsLink2  = LINK_INFO_ITEM.$rowAds2['alias'].'.html';
	$rowAdsTitle2 = $json->getDataJson1D($rowAds2['title'], $_SESSION['dirlang']);
	
	foreach($cShop as $value):
		if($value[5] == 0 && $value[7] == 1):
			$cListIDS = getCategoryShop($value[0], '', '');
			$cListS   = categoryToArray($cListIDS);
			$cListS[] = $value[0]; 
			$clink = LINK_SHOP_LIST.$value[4].'.html';
			?> 
			
				<div class="col-md-6 col-xs-6 panel clearfix"> 
					<!-- <div class="panel-heading clearfix" style="">
						<h4 class="col-md-12" style="padding:5px 0; margin-bottom:0"><span class="" style="padding: 5px 10px;">							
							<a class="clr-sdt1" href="<?=$clink?>" target="_blank"><?=$value[1]?></a></span>
						</h4>
					</div>  -->
					<div class="contet-block">
						<div class="col-md-4 col-xs-3 p-category-home" style="padding:0">
							<div class="warrap-category-left">
								<a href="<?=$clink?>" target="_blank">
									<div class="title item item-a-hover"><?=$value[1]?></div>
									<div class="sub-title item item-a-hover">Size M</div>
									<?=
									showImg(DIR_UPLOAD.'/shop/'.$value[6], 'shop/'.$value[6], 'no-image.png', '', '', "", "", '', '');
									?>
									<div class="tagContainer">
										<div class="tag">Giày Nam</div>
										<div class="tag">Thời Trang</div>
									</div>

								</a>
								
							</div>
						</div> 
						<div class="col-md-8 col-xs-9 content-block-grid pannel-item" style="padding-top:20px;">
							<div class="row pannel-item-top">
								<?php   
								$sqlExt = ' AND p.publish = 1 AND p.id_cat IN ('.implode(',', $cListS).')'; 
								if($_POST['sLocation'] != '')
								{ 
									$sqlExt .= " AND p.jsLocationGroup LIKE '%".$_POST['sLocation']."%'";	 
								} 				
								$rows = loadListShop('', $sqlExt, '', 3)['rows']; 

								foreach($rows as $key => $row):   
									$link  = LINK_SHOP_ITEM.$row['alias'].'.html';
									$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
									$price2 = discountPrice($row['price'], $row['discount']);
									?>

									<!-- here -->
									
								<?php	
								endforeach; 
								?> 
									<div class="col-lg-4 col-md-6 col-xs-6 content-block-grid" style="padding-left:5px; padding-right:5px;"> 
										<!--<span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span>-->
										<div class="clearfix item-product row" style="">
											<div class="col-xs-12 col-md-12 text-center list-product-home" style="padding:0px;">
												<div class="warrap-item-top">
													<a href="<?=$link?>" class="img-class " target="_blank"> 			<div class="title item item-a-hover">Titlte 1</div>
														<div class="sub-title item item-a-hover">Sub title</div>
														<!-- <?=
															showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:100px;"');
														?>  -->
														<img src="https://img.alicdn.com/tfs/TB1NeF.yntYBeNjy1XdXXXXyVXa-210-260.png">
													</a>  
													
												</div>
											</div>
											
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-xs-6 content-block-grid" style="padding-left:5px; padding-right:5px;"> 
										<!--<span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span>-->
										<div class="clearfix item-product row" style="">
											<div class="col-xs-12 col-md-12 text-center list-product-home" style="padding:0px;">
												<div class="warrap-item-top">
													<a href="<?=$link?>" class="img-class " target="_blank"> 			<div class="title item item-a-hover">Titlte 1</div>
														<div class="sub-title item item-a-hover">Sub title</div>
														<!-- <?=
															showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:100px;"');
														?>  -->
														<img src="https://img.alicdn.com/tfs/TB15dxkxAyWBuNjy0FpXXassXXa-210-260.png">
													</a>  
													
												</div>
											</div>
										</div>
									</div> 
									<div class="col-lg-4 col-md-6 col-xs-6 content-block-grid" style="padding-left:5px; padding-right:5px;"> 
										<!--<span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span>-->
										<div class="clearfix item-product row" style="">
											<div class="col-xs-12 col-md-12 text-center list-product-home" style="padding:0px;">
												<div class="warrap-item-top">
													<a href="<?=$link?>" class="img-class " target="_blank"> 			<div class="title item item-a-hover">Titlte 1</div>
														<div class="sub-title item item-a-hover">Sub title</div>
														<?=
															showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:136px;"');
														?>
														<!-- <img src="https://img.alicdn.com/tfs/TB1trVyxuuSBuNjy1XcXXcYjFXa-210-260.png"> -->
													</a>  
													
												</div>
											</div>
										</div>
									</div> 
							</div>

							<div class="col-xs-12 pannel-item-bottom">
								<div class="warrap-item-bottom">
									<!-- <div class="col-xs-8 col-md-12 caption text-center" style="padding:0"> -->
											<!-- <h5 class="content-block-short-title" style="min-height:10px"><a class="text-uppercase" style="font-size: 10px;" href="<?=$link?>" target="_blank"><?=$title?></a></h5>
											<?php
											if($row['discount']>0){?>
												<div class="clearfix">
													<del class="col-md-6 text-right" style="padding:0"><span class="priceFormat discountPrice"><?=$row['price']?></span></del> 
													<span class="priceFormat2" style=""><?=$price2?> VNĐ</span>
												</div> 
											<?php	
											}else{?>
												<div>
													<span class="priceFormat2"><?=$row['price']?> VNĐ</span>
												</div> 
											<?php	
											}
											?>  -->


										<!--
										<p class="btn-home bg-sdt1 ">
											<a class="btn btn-addcart " style="color:#fff" href="<?=$link?>"><?=BTN_ADDCARD?></a>									
										</p>
										-->
										<!-- </div> -->
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 1</a></div>
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 2</a></div>
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 3</a></div>
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 4</a></div>
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 5</a></div>
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 6</a></div>
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 7</a></div>
									<div class="item-tag"><a class="item-a-hover" href="<?=$clink?>" target="_blank">TAG 8</a></div>
								</div>
							</div>
						</div>					
					</div>
				</div>			
			
			<?php
		endif;
	endforeach;
	?> 
	</div> 
</div>
   
