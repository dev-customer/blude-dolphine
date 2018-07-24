<?php if(!defined('DIR_APP')) die('Your have not permission'); ?>
<div class="box">
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?=MENU_MANAGE.' '.MENU_MODULE  ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"></h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
 
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=sys&q=func">
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
			<thead>
				<tr class="bg-sdt1"> 
					<th width="5"><strong><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></strong></th>
					<th>No</th>  
					<th>Group</th>
					<th>Module</th> 
					<th>Controller</th>
					<th>Menu Admin</th>
				</tr> 
			</thead>
			<tbody>
				<?php 
				if( empty($rows) ) { ?>
				<tr>
					<td class="center" colspan="20"><?=LANG_NO_RESULT; ?></td>
				</tr>
				<?php
				}
				else{ 
					$i=1;
					foreach(@$rows as $row) 
					{	?>
						<tr class="<?=$row['controller']==''? 'bg-info':''?>">
							<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?=$row['id_func']; ?>" class="chkbox"> </td>
							<td> <?= $row['id_permis']?> </td>
							<td> <?= $row['id_group']?> </td>
							<td> <?= $row['module']?> </td>
							<td> <?= $row['controller']?> </td>
							<td>
								<img data-id="permission#id_permis#<?=$row['id_permis']?>#setAdmin" data-state="<?=$row['setAdmin']?>" src="images/status-<?=$row['setAdmin']?>.png"  class="pointer change-status-record" />						
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
			
            
