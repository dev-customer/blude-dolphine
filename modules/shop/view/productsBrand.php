<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod, $cShop;  

$brandName = $json->getDataJson1D($data['brandName'],  $_SESSION['dirlang']);

?> 
<div class="container-fluid side-main side-products">
    <div class="container">
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
    </div> 	
</div>
