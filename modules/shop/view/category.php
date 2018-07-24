<?php if(!defined('DIR_APP')) die('You have not permission');
global $cShop, $json; ?>
<style>
.category h4{ font-size:14px}
.category .list-group a{ font-size:13px}
</style>
<div class="panel panel-default hidden-mobile" >
	<div class="panel-heading bg-sdt1 text-uppercase">
		<h3 class="panel-title"style="color:#fff"><i class="fa fa-indent" aria-hidden="true"></i> <?=MENU_CATEGORY?></h3>
	</div>
	<div class="panel-group category" id="accordion">
		<?php
		foreach($cShop as $key => $row1):
		if($row1[5]==0):
			$link1 = LINK_SHOP_LIST.$row1[4].'.html';
			$title1 = $row1[1]; 
			
			$cShopSub = getCategoryShop($row1[0], '', '');    
			if(count($cShopSub)>0)
			{ 	?>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title text-uppercase"><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$key?>" <?= $key==0 && $_GET['alias'] == '' ? ' aria-expanded="true"':''?>><i class="fa fa-plus-square" aria-hidden="true"></i> <?=$title1?></a> </h4>
					</div>
					<div id="collapse<?=$key?>" class="panel-collapse collapse <?=($key==0 && $_GET['alias'] == '')? ' in':''?>">
						<ul class="list-group">
						<?php
						foreach($cShopSub as $row2):
							if($row2[5] == $row1[0]):
								$link2  =  LINK_SHOP_LIST.$row2[4].'.html'; 
								$title2 = $row2[1];
								echo '<li class="list-group-item text-uppercase"><i class="fa fa-list-ul" aria-hidden="true"></i> <a href="'.$link2.'">'.$title2.'</a></li>';
							endif;
						endforeach;
						?>
						</ul>
					</div>
				</div>
			
			<?php	
			}
			else{?>
				<div class="panel">
					<div class="panel-heading">
						<h4 class="panel-title text-uppercase"><a href="<?=$link1?>"><i class="fa fa-plus-square" aria-hidden="true"></i> <?=$title1?></a> </h4>
					</div>
				</div>			
			<?php
			}
		endif;
		endforeach; ?>     
		                      	                     
	</div> 	
</div>


	