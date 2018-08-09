<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod, $cShop;  
?> 
<div class="container-fluid side-main side-products">
    <div class="container">

    	<?php if(count($data['list_category_child'])> 0) {
				foreach($data['list_category_child'] as $row2){
					if($data['id_main_cat'] == $row2[5]){
						$link2  =  LINK_SHOP_LIST.$row2[4].'.html'; 
						$title2 = $row2[1];

						$rows = getProductsCategory($row2[0]);
					?>
					<div class="main-category-item clearfix">
						<div class="title-main-category"><?php echo $title2; ?></div>
						<div class="row">
							<div class="col-md-12" style="margin-top:5px">
								<div class="panel panel-default group-pannel">			 
									<div class="group-product clearfix">
										<?php        
											if(count($rows)>0)
											{ 
												foreach($rows as $row):  
													$link  = LINK_SHOP_ITEM.$row['alias'].'.html';
													$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
													$price2 = discountPrice($row['price'], $row['discount']);

													?>
													<div class="col-sm-4 col-md-3 custom-md-5row"> 
														<div class="site warrap-item" style=" position:relative">
															<div class="thumbnail">
																<a href="<?=$link?>" class="site-thumb "> 
																	<?=
																	showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', '');
																	?> 
																</a>  
															</div> 	
															<div class="caption text-center">
																<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?></span></a></div>
																<div class="caption-bottom">
																	<span class="priceFormat"><?=$row['price']?></span>
																	<span class="num-buy">Bán <?=$row['numBuy']?></span>
																</div> 
															</div>
														</div>									
													</div>
													<?php
												endforeach;
											}
											?>
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php
					
					} 
				}
			} else {?>
		<div class="col-md-3" style="margin-top:5px">
			<?php 
				$mod->view('shop/view/category')
			?>
		</div>
		<div class="col-md-9" style="margin-top:5px">
			<div class="panel panel-default group-pannel">			 
				<div class="group-product">
					<?php        
					if(count($rows)>0)
					{ 
						foreach($rows as $row):  
						$link  = LINK_SHOP_ITEM.$row['alias'].'.html';
						$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
						$price2 = discountPrice($row['price'], $row['discount']);
						?>
						<div class="col-sm-4 col-md-3"> 
							<div class="site warrap-item" style=" position:relative">
								<!-- <span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span> -->
								<div class="thumbnail">
									<a href="<?=$link?>" class="site-thumb "> 
										<?=
										showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', '');
										?> 
									</a>  
								</div> 	
								<div class="caption text-center">
									<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?></span></a></div>
									<!-- <?php
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
									?> --> 
									<div class="caption-bottom">
										<span class="priceFormat"><?=$row['price']?></span>
										<span class="num-buy">Bán <?=$row['numBuy']?></span>
									</div> 
								</div>
							</div>									
						</div>
						

						<?php
						endforeach;
						echo '<p class="clearfix">'.$paging.'</p>';
					}else
						// echo '<p class="alert bg-info">No data...<p>';  
					?>
				</div> 
			</div> 
		</div> 
		<?php } ?>
    </div> 	
</div>
