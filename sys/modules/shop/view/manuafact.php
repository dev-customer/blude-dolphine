<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>

<div class="box">
	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_SHOP_MANUAFACT ?></h2> 
		<h2 class="col-md-6 text-right modBtn" ><?php Admin::button('add, delete'); ?></h2>
    </div>

    <?php 
	if(@$_SESSION['message']): ?>
		<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; 
	?>
	
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=shop&q=manuafact">
      <table class="table table-hover tblList" cellspacing="0" cellpadding="0">
          <thead class="bg-sdt1">
				<tr>
					<th width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th width="40"><?= "No" ?></th>
					<th align="left"> <?= LANG_NAME; ?></th> 
					<th>Image</th>
					<th> SP</th>
					<th><?= LANG_ENABLE; ?></th>
					<th><?= LANG_ORDER;?>&nbsp; <i class="fa fa-save submitform" style="color: yellow;"></i></th>
					<th class="right"><?= LANG_ACTION; ?></th>
				</tr>
           </thead>
			<?php 
			if( empty($rows)){ ?>
				<tr>
					<td class="center" colspan="20"><?= LANG_NO_RESULT; ?></td>
				</tr>
			<?php
			}
			else 
			{
				$i=1;
				$listid ='';
				foreach($rows as $row) 
				{  
					$title = $json->getDataJson1D($row['name'], $_SESSION['dirlang']);
					$listid .= '-'.$row['id_manuafact'];
					?>
					<tr>
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_manuafact']; ?>"></td>
						<td><?= $row['id_manuafact']; ?></td>
						<td><?= $title ?></td> 
						<td>
							<?= 
							showImg('../'.DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', 30, 30, "", "", ' img-circle', '');
							?>					
						</td>
						<td> <?= $row['products']; ?></td>
						<td>
							<img data-id="shop_manuafact#id_manuafact#<?=$row['id_manuafact']?>" data-state="<?=$row['publish']?>" src="images/status-<?=$row['publish']?>.png"  class="pointer change-status-record" />						
 						</td>
						<td class="col-md-1"><input type="number" class="orderring form-control" min="1" name="<?= $row['id_manuafact']?>_id" value="<?= $row['orderring']; ?>"  style="width: 60px" /></td>					 
						<td width="130px">
							<?php 
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="shop_manuafact#id_manuafact#'.$row['id_manuafact'].'"><span class="glyphicon glyphicon-remove"></span></a>';
							Admin::edit($row['id_manuafact']); 
							?> 
						</td>
					</tr>
			<?php		
				}
			} ?> 
        </table> 
		<?= $paging; ?>
		<input type="hidden" name="listid"  value="<?=$listid?>" />      
		<input type="hidden" name="task" id="task" value="" />
    </form>
</div>
  