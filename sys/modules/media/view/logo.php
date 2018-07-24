<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;
?> 
<div class="box">
	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?=MENU_MANAGE.' '.MENU_LOGO  ?></h2> 
		<h2 class="col-md-6 text-right modBtn"><?php Admin::button('add'); ?>  </h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
 
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=media&q=logo">
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"><!-- Table -->
			<thead>
				<tr class="bg-sdt1"> 
					<th width="5"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th>No</th>
					<th><?=LANG_IMAGE?></th>
					<th><?=LANG_TITLE?></th>
					<th><?=LANG_ORDER;?> &nbsp; <i class="fa fa-save submitform" style="color: yellow;"></i></th>
					<th class="col-md-1 text-right">Action</th> 
				</tr> 
			</thead>
			<tbody>
				<?php 
				if( empty($rows) ) { ?>
				<tr>
					<td colspan="6"><?=LANG_NO_RESULT; ?></td>
				</tr>
				<?php
				}
				else{ 
					$i=1;
					foreach(@$rows as $row) 
					{	?>
						<tr>
							<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?=$row['id_logo']; ?>" class="chkbox"> </td>
							<td> <?= $row['id_logo']?> </td>
							<td>
							<?=
							showImg('../'.DIR_UPLOAD.'/logo/'.$row['image'], 'logo/'.$row['image'], 'no-image.png', 30, 30, "", "", 'img-circle', '');
							?>
							</td>
							<td><?=$json->getDataJson1D($row['title'], $_SESSION['dirlang'])?></td>
							<td class="col-md-1"><input type="number" class="form-control" name="<?= $row['id_logo']?>_id" size="2" value="<?= $row['orderring']; ?>">
							<td>
							 <?php 	
								echo '<a class="btn bg-sdt2 deleteAjx" data-id="logo#id_logo#'.$row['id_logo'].'"><span class="glyphicon glyphicon-remove"></span></a>';
								 Admin::edit($row['id_logo']); 
							 ?>
							 </td> 
						</tr>
					<?php	
					} 
				}  
				?>
			</tbody>
		</table>
	<input type="hidden" name="task" id="task" value="" />
   </form>
</div> 
			
            
