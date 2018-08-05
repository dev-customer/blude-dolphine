<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod, $cShop;  
?> 
<div class="container-fluid side-main side-products">
    <div class="container">  
		<div class="col-md-3" style="margin-top:5px">
			<?php 
				$mod->view('shop/view/category')
			?>
		</div>
		<div class="col-md-9" style="margin-top:5px">
			<div class="panel panel-default group-pannel">			 
				<div class="group-product">
					<div class="col-sm-4 col-md-3"> 
						<div class="site warrap-item" style=" position:relative">
							<!-- <span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span> -->
							<div class="thumbnail">
								<a href="<?=$link?>" class="site-thumb "> 
									<img src="https://cbu01.alicdn.com/img/ibank/2016/685/105/3037501586_150351792.160x160.jpg">
								</a>  
							</div> 	
							<div class="caption text-center">
								<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?> Giay thoi trang quy phai hot nhat 2018</span></a></div>
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
									<span class="priceFormat">100000</span>
								</div> 
							</div>
						</div>									
					</div>
					<div class="col-sm-4 col-md-3"> 
						<div class="site warrap-item" style=" position:relative">
							<!-- <span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span> -->
							<div class="thumbnail">
								<a href="<?=$link?>" class="site-thumb "> 
									<img src="https://cbu01.alicdn.com/img/ibank/2016/685/105/3037501586_150351792.160x160.jpg">
								</a>  
							</div> 	
							<div class="caption text-center">
								<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?> Giay thoi trang quy phai hot nhat 2018</span></a></div>
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
									<span class="priceFormat">100000</span>
								</div> 
							</div>
						</div>									
					</div>
					<div class="col-sm-4 col-md-3"> 
						<div class="site warrap-item" style=" position:relative">
							<!-- <span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span> -->
							<div class="thumbnail">
								<a href="<?=$link?>" class="site-thumb "> 
									<img src="https://cbu01.alicdn.com/img/ibank/2016/685/105/3037501586_150351792.160x160.jpg">
								</a>  
							</div> 	
							<div class="caption text-center">
								<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?> Giay thoi trang quy phai hot nhat 2018</span></a></div>
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
									<span class="priceFormat">100000</span>
								</div> 
							</div>
						</div>									
					</div>
					<div class="col-sm-4 col-md-3"> 
						<div class="site warrap-item" style=" position:relative">
							<!-- <span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span> -->
							<div class="thumbnail">
								<a href="<?=$link?>" class="site-thumb "> 
									<img src="https://cbu01.alicdn.com/img/ibank/2016/685/105/3037501586_150351792.160x160.jpg">
								</a>  
							</div> 	
							<div class="caption text-center">
								<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?> Giay thoi trang quy phai hot nhat 2018</span></a></div>
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
									<span class="priceFormat">100000</span>
								</div> 
							</div>
						</div>									
					</div>
					<div class="col-sm-4 col-md-3"> 
						<div class="site warrap-item" style=" position:relative">
							<!-- <span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span> -->
							<div class="thumbnail">
								<a href="<?=$link?>" class="site-thumb "> 
									<img src="https://cbu01.alicdn.com/img/ibank/2016/685/105/3037501586_150351792.160x160.jpg">
								</a>  
							</div> 	
							<div class="caption text-center">
								<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?> Giay thoi trang quy phai hot nhat 2018</span></a></div>
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
									<span class="priceFormat">100000</span>
								</div> 
							</div>
						</div>									
					</div>
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
									<div class="caption-top"><a class="text-uppercase title-main" href="<?=$link?>"><span class="title"><?=$title?> Giay thoi trang quy phai hot nhat 2018</span></a></div>
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
										<span class="priceFormat">100000</span>
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
    </div> 	
</div>
