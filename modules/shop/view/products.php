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
			<div class="panel panel-default">			 
				<div class="group-product">
					<?php        
					if(count($rows)>0)
					{ 
						foreach($rows as $row):  
						$link  = LINK_SHOP_ITEM.$row['alias'].'.html';
						$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
						$price2 = discountPrice($row['price'], $row['discount']);
						?>
						<div class="col-md-3"> 
							<div class="site" style=" position:relative">
								<span class="glyphicon glyphicon-certificate icoSpec <?=$row['discount'] > 0 ? '' : 'hidden'?> icoSaleOff text-right" title="<?=$row['discount']?>"><label><?=$row['discount']?>%</label></span>
								<div class="thumbnail">
									<a href="<?=$link?>" class="site-thumb "> 
										<?=
										showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:'.$mod->config['imageShop'].'px"');
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
						</div>	 

						<?php
						endforeach;
						echo '<p class="clearfix">'.$paging.'</p>';
					}else
						echo '<p class="alert bg-info">No data...<p>';  
					?>
				</div> 
			</div> 
		</div> 
    </div> 	
</div>
