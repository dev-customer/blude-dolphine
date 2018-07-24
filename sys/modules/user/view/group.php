<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>		 
<form id="frm_list" name="frm_list" method="post" action="index.php?p=user&q=group">
<div class="box"> 
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_GROUP ?></h2> 
	  <h2 class="col-md-6 text-right modBtn">
	  <?php 
		if($_SESSION['id_group'] <= 1) 	  
			Admin::button('add, delete'); 
	  ?>
	  </h2>
    </div>
	
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?> 

		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
			<thead>
				<tr class="bg-sdt1">
					<th class="center" width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th><?="ID" ?></th>
					<th><?=ucfirst(GROUP) ?></th>
					<th><?=ucfirst(USER) ?></th>
					<th><?=LANG_ENABLE; ?></th>
					<th class="col-md-1 text-right" >Action</th>
				</tr>
			</thead>
			<?php if( empty($rows) ) { ?>
            <tr>
                <td class="center" colspan="20"><?=LANG_NO_RESULT; ?></td>
            </tr>
			<?php
			} 
			else
			{
				$listid ='';
                foreach($rows as $row) 
				{
					$listid .= '-'.$row['id_group'];
					$num = $this->num("SELECT id_user FROM #__users WHERE id_group = ".$row['id_group']);
					
					?> 
					<tr>
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?=$row['id_group']?>" class="chkbox"></td>
						<td><?=$row['id_group']; ?></td>
						<td><?=$json->getDataJson1D($row['name'], $_SESSION['dirlang'])?></td>
						<td><?=$num ?></td>
						<td>
							<?php
							if($row['id_group'] != $_SESSION['id_group']):?>
								<img data-id="user_group#id_group#<?=$row['id_group']?>" data-state="<?=$row['publish']?>" src="images/status-<?=$row['publish']?>.png"  class="pointer change-status-record"/>						
							<?php
							endif;
							?>
						</td>
						<td class="right">
						<?php 
						if($_SESSION['id_group'] != $row['id_group'] && $row['setDelete'] == 1)
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="user_group#id_group#'.$row['id_group'].'"><span class="glyphicon glyphicon-remove"></span></a>';
						if($row['setEdit'] == 1)
							Admin::edit($row['id_group']);
						?>
						</td>
					</tr>
				<?php  
			} 
		} ?>
          
        </table>
      
      <?=$paging; ?>
       <input type="hidden" name="listid"  value="<?=$listid?>" />      
       <input type="hidden" name="task" id="task" value="" />
      
  </div>  
</form>
  