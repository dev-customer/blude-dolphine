<?php if(!defined('DIR_APP')) die('You have not permission');
global $cNews, $json; ?>
<div class="panel hidden-mobile" >
	<div class="panel-heading bg-sdt1">
		<h3 class="panel-title"style="color:#fff"><i class="fa fa-indent" aria-hidden="true"></i> <?=MENU_CATEGORY?></h3>
	</div>
	<div class="panel-group category" id="accordion">
		<?php
		foreach($cNews as $key => $row1):
		if($row1[5]==130):
			$link1 = LINK_INFO_LIST.$row1[4].'.html';
			$title1 = $row1[1]; 
			$m2 = $db->loadObjectList('SELECT * FROM #__category WHERE id_parent = '.$row1[0]);    
			if(count($m2)>0)
			{ 	?>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$key?>" <?= $key==0? ' aria-expanded="true"':''?>><span class="glyphicon glyphicon-minus clr-sdt1 text-primary"> </span><?=$title1?></a> </h4>
					</div>
					<div id="collapse<?=$key?>" class="panel-collapse collapse <?=$key==0? ' in':''?>">
						<ul class="list-group">
						<?php
						foreach($m2 as $row2):
							$link2 = LINK_INFO_LIST.$row2['alias'].'.html';
							$title2 = $json->getDataJson1D($row2['title'], $_SESSION['dirlang']);
							echo '<li class="list-group-item"><span class="glyphicon glyphicon-menu-hamburger clr-sdt1"></span><a href="'.$link2.'">'.$title2.'</a></li>';
						endforeach;
						?>
						</ul>
					</div>
				</div>
			
			<?php	
			}
			else{?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><a href="<?=$link1?>"><span class="glyphicon glyphicon-menu-hamburger clr-sdt1"> </span><?=$title1?></a> </h4>
					</div>
				</div>			
			<?php
			}
		endif;
		endforeach; ?>     
		                      	                     
	</div> 	
</div>
	