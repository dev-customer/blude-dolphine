<?php if(!defined('DIR_APP')) die('Your have not permission');
global $json;
?>
		 
<div class="box"> 
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_USER ?></h2> 
	  <h2 class="col-md-6 text-right modBtn" >
		<?php  
		if($_SESSION['id_group'] <= 1) 	 
			Admin::button('add'); 
		?> 
	  </h2>
    </div>
	
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
 
	 <form id="frm_list" name="frm_list" method="post" action="index.php?p=user&q=user">    
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
			<thead>
				<tr class="bg-sdt1">
					<th class="center" width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th><?= "ID" ?></th>
					<th><?= LANG_USER_NAME; ?></th>
					<th><?= LANG_USER_USENAME; ?></th>
					<th><?= LANG_IMAGE?></th>
					<th><?= LANG_USER_EMAIL; ?></th>
					<th><?= LANG_USER_GROUP; ?></th>                      
					<th><?= LANG_USER_PUBLISH; ?></th>
					<th><?=News?></th>					
					<th class="col-md-1 text-right" >Action</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if( empty($rows) ) { ?>
            <tr>
                <td colspan="20"><?= LANG_NO_RESULT?></td>
            </tr>
			<?php
				} else {
					$i=1;
					foreach($rows as $row) {
					?>
						<tr>
							<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_user']; ?>" class="chkbox"></td>
							<td><?= $row['id_user']; ?></td>
							<td><?=$json->getDataJson1D($row['firstname'], $_SESSION['dirlang'])?> <?=$json->getDataJson1D($row['lastname'], $_SESSION['dirlang'])?></td>
							<td><?= $row['username']; ?></td>
							<td>
							<?=
							showImg('../'.DIR_UPLOAD.'/users/'.$row['image'], 'users/'.$row['image'], 'no-image.png', 30, 30, "", "", 'zoom img-circle', '');
							?>
							</td>
							<td><?= $row['email']; ?></td>
							<td><?= $json->getDataJson1D(@$row['groups'], $_SESSION['dirlang'])?></td>                       
							<td>
								<?php
								if($row['id_user'] != $_SESSION['admin_id']):?>
									<img data-id="users#id_user#<?=$row['id_user']?>" data-state="<?=$row['publish']?>" src="images/status-<?=$row['publish']?>.png"  class="pointer change-status-record" />						
								<?php
								endif;
								?>
							</td>
							<td><?= $row['numArticle']?> </td>							
							<td class="right">
							<?php 
							if($row['id_user'] != $_SESSION['admin_id'] && $row['setDelete'] == 1) 
								echo '<a class="btn bg-sdt2 deleteAjx" data-id="users#id_user#'.$row['id_user'].'"><span class="glyphicon glyphicon-remove"></span></a>';
							if($row['setEdit'] == 1)
								Admin::edit($row['id_user']); 
							?> 
							</td>
						</tr>
					<?php $i++;
				} 
			} ?>
			</tbody>
        </table>

      <?= $paging; ?>
       <input type="hidden" name="task" id="task" value="" />
       </form> 
  </div> 