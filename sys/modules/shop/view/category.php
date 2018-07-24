<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>

<div class="box">
	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_SHOP_CATALOG ?></h2> 
		<h2 class="col-md-6 text-right modBtn" ><?php  Admin::button('add'); ?></h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
 
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=shop&q=category">
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
			<thead class="bg-sdt1">
                <tr>
                    <th width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
                    <th>ID </th>
                    <th><?= LANG_NAME; ?></th>
					<th>Image</th>
                    <th>SP</th>
                    <th><?= LANG_ENABLE; ?></th>
					<th>setHome</th>
					<th><?= LANG_ORDER?>&nbsp; <i class="fa fa-save submitform" style="color: yellow;"></i></th>
                    <th class="right"><?= LANG_ACTION; ?></th>
                </tr>
			</thead>
			<?php 
			if(empty($rows)) 
			{ ?>
				<tr>
					<td colspan="20"><?= LANG_NO_RESULT?></td>
				</tr>
			<?php
			}
			else 
			{
				$listid ='';
				foreach($rows as $row) 
				{  	 
				
					$products = $db->num('SELECT * FROM #__shop_products WHERE id_cat = '.$row[0]);

					$listid .= '-'.$row[0];?>
					<tr>
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row[0]; ?>" class="chkbox"></td>
						<td><?= $row[0]; ?></td>
						<td title="<?= $row[6]; ?>"> <?= $row[1]; ?></td>
						<td>
							<?=
							showImg('../'.DIR_UPLOAD.'/shop/'.$row[5], 'shop/'.$row[5], 'no-image.png', 30, 30, "", "", ' img-circle', '');
							?>						
						</td>
						<td> <?= $products?></td>
						<td>
							<img data-id="shop_category#id_cat#<?=$row[0]?>" data-state="<?=$row[2]?>" src="images/status-<?=$row[2]?>.png"  class="pointer change-status-record" />						
						</td>
						<td>
							<img data-id="shop_category#id_cat#<?=$row[0]?>#setHome" data-state="<?=$row[7]?>" src="images/status-<?=$row[7]?>.png"  class="pointer change-status-record" />						
						</td>
						<td class="col-md-1"><input type="number" class="form-control" min="1" name="<?= $row[0]?>_id" size="2" value="<?= $row[3]; ?>"></td>	 
						<td width="150">
							<?php  
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="shop_category#id_cat#'.$row[0].'"><span class="glyphicon glyphicon-remove"></span></a>';
							Admin::edit($row[0]);
							?>  
						</td>
					</tr>
					<?php	
										  
				} 
				echo '<tr><td colspan="9" align="right">'.count($rows).'</td></tr>';
			}
		   ?>
		</table>
       <input type="hidden" name="listid"  value="<?=$listid?>" />      
       <input type="hidden" name="task" id="task" value="" />
     </form>
</div>