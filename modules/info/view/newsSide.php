<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod;  ?>
<div class="panel hidden-mobile panel-default">
	<div class="panel-heading bg-sdt1">
		<h3 class="panel-title"><i class="fa fa-indent" aria-hidden="true"></i> <?=MENU_NEWS?></h3>
	</div>
	<div class="panel-body" style="padding:2px !important">
		<?php
		 
		$cListID = getCategoryInfo(139, '', '');
		$cList = categoryToArray($cListID);
		$cList[] = 139;
		$sqlExt = " AND c.publish = 1 AND c.id_cat IN (".implode(',', $cList).")";	 
		
		$sqlExt .= ($mod->method == 'detail') ? " AND c.alias != '".$_GET['id']."'" : '';
		 
		$rows = loadListInfo('', $sqlExt, '', 5)['rows'];   
		if(count($rows) > 0)
		{
			foreach($rows as $key => $row):
				$link = $row['link'] != '' ? $row['link'] : LINK_INFO_ITEM.$row['alias'].'.html';
				$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']); 
				?>
				<div class="clearfix">
					<div class="col-md-3 thumbnail">
						<a href="<?=$link?>"><?=
						showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', $title, $title, 'img-responsive', '');
						?></a>
					</div>
					<div class="col-md-9 caption" style="padding-left:3px; padding-right:0">
						<h6 style="margin-top:0"><a class="clr-sdt1" href="<?=$link?>"><?=$title?></a></h6>
						<p style="color:#b1a9a9"><?=$mod->cutstring(strip_tags($row['content_'.$_SESSION['dirlang']]), 50)?></p>
					</div>
				</div> 
				<hr style="margin-top:0"/>
				<?php 
			endforeach;
		}
		?>			 	  
	</div>
</div>
