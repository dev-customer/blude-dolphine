<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;  
?>
	 
<div class="box">
	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_ARTICLE ?></h2> 
		<h2 class="col-md-6 text-right modBtn">  <?php Admin::button('add, delete'); ?> </h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=content&q=article">
		<table class="tbltop" cellspacing="0" cellpadding="0" border="1">
			<thead>
				<tr>
					<th class="text-right"> 
						<ul class="list-inline  text-right actTopContent">
							<li> 
								<div class="input-group">
									<input class="form-control" id="search" name="search" placeholder="Search..." required  />
									<span class="input-group-btn bg-sdt1">
										<a class="bg-sdt1" id="button_search"><span class="btn glyphicon glyphicon-search"></span></a>
									</span>
								</div>
							</li>
							<li><?= $filter_cat?></li> 
							<li><?= $filter_publish?></li>
							<li>
								<div class="input-group">
									<a href="javascript:void(0);" class="btn bg-sdt1" id="button_reset"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> <?= LANG_ALL ?></a>				
									<input class="attr-reset" type="hidden" value="category-publish" />
								</div>
							</li>
						</ul>  
					</th>
				</tr>
			</thead>
		</table>
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
			<thead>
				<tr class="bg-sdt1"> 
					<th><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);" ></th>
					<th>ID</th>
					<th><?= LANG_TITLE;?> </th>
					<th><?= LANG_IMAGE?></th>
					<th><?= ucfirst(MENU_CATALOG)?></th> 
					<th><?= LANG_ENABLE;?></th>
					<?php  
					if($_SESSION['id_group'] <= 1): ?>
					<th class="col-md-1">Fix Alias</th>
					<?php
					endif?>
					<th>Home</th>
					<th><?= LANG_ORDER;?>&nbsp; <i class="fa fa-save submitform" style="color: yellow;"></i></th>
					<th class="hidden">User</th>				  
					<th class="col-md-2 text-right" >Action</th>
				</tr> 
			</thead>
			<tbody>
			<?php 
			if( empty($rows) ) { ?>
				<tr>
					<td class="center" colspan="12"><?= LANG_NO_RESULT; ?></td>
				</tr>
			<?php
            } else {
                
				$listid ='';
                foreach($rows as $row) 
				{
					$listid .= '-'.$row['id_art'];
					$link = LINK_INFO_ITEM.$row['alias'].'.html';
					?>
					<tr>
						<td width="1" class="bg-sdt1"><input type="checkbox" name="id[]" value="<?=$row['id_art']?>" class="chkbox"> </td>
						<td><?= $row['id_art'];?></td>
						<td><div class="editAjx" data-state="content#title#<?=$row['id_art']?>#<?=$_SESSION['dirlang']?>"><?=$json->getDataJson1D($row['title'], $_SESSION['dirlang'])?></div></td>
						<td>
						<?=
						showImg('../'.DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', 30, 30, "", "", 'zoom img-circle', '');
						?>
						</td>
						<td><?=$json->getDataJson1D($row['category'], $_SESSION['dirlang'])?></td> 
						<td>
							<img data-id="content#id_art#<?=$row['id_art']?>" data-state="<?=$row['publish']?>" src="images/status-<?=$row['publish']?>.png"  class="pointer change-status-record" />						
						</td>
						<?php  
						if($_SESSION['id_group'] <= 1): ?>
						<td class="bg-danger">
							<img data-id="content#id_art#<?=$row['id_art']?>#aliasFix" data-state="<?=$row['aliasFix']?>" src="images/status-<?=$row['aliasFix']?>.png" class="pointer change-status-record" />						
 						</td>
						<?php
						endif?>						
						<td>  
							<img data-id="content#id_art#<?=$row['id_art']?>#setHome" data-state="<?=$row['setHome']?>" src="images/status-<?=$row['setHome']?>.png"  class="pointer change-status-record" />						
						</td> 				
						<td class="col-md-1"><input type="number" class="orderring form-control" min="1" name="<?= $row['id_art']?>_id" value="<?= $row['orderring']; ?>"  style="width: 60px" /></td>					 
						<td class="hidden"><?=$json->getDataJson1D($row['user'], $_SESSION['dirlang'])?></td>
						<td>
							<a class="btn bg-sdt1" href="<?=$link?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
							<?php 						  
							if($_SESSION['id_group'] <= 3 && $row['statusDelete'] == 1) //Admin::delete($row['id_art']);  
								echo '<a class="btn bg-sdt2 deleteAjx" data-id="content#id_art#'.$row['id_art'].'"><span class="glyphicon glyphicon-remove"></span></a>';
								Admin::edit($row['id_art']); 
							?> 
						 </td>
					</tr>
					<?php  
					$i++;
					}?>
					<tr>
						<td class="center" colspan="12"> 
						<?=$paging?>
						</td>
					</tr>
			<?php		
			} 
			?>
			<tbody>  
        </table>
       
       <input type="hidden" name="listid"  value="<?=$listid?>" />      
       <input type="hidden" name="order" id="order" value="" />
       <input type="hidden" name="ordertype" id="ordertype" value="" />
       <input type="hidden" name="post_lang" id="post_lang" value="<?= $_SESSION['dirlang']?>" /> 
       <input type="hidden" name="task" id="task" value="" />
       </form> 
  </div> 
			
            
