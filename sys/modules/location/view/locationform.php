<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;  
?>
<script type="text/javascript">
	$(document).ready(function(){
		// disable option like this cat (action edit)
		var method = $('#method').val();
		var cat = $('#id_location').val();
		if(method=='edit'){
			$('select#id_parent option').each(function(){		
				if($(this).val()==cat){
					$(this).attr('disabled','disabled');
					$(this).addClass('disabled');
				}
			});
		}
	});
</script> 
<div class="box">
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= (($mod->method=='add')? LANG_ADD : LANG_EDIT).' '.MENU_LOCATION ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('save, cancel'); ?></h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-centers"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>

 	<?php tabsLanguageAdmin(); ?>
	
	<form method="post" enctype="multipart/form-data" name="frm_list" id="frm_list" action="index.php?p=location&q=location">
		<div id="tab_general">
			<table  class="tblForm tblList"  >
				<tr>
					<td>Option</td>
					<td>
						<ul class="list-inline">
							<li>
							<?php
							showAttrActive('publish', @$row['publish'], LANG_ENABLE);
							?>
							</li>  
						<ul>  
					</td>
				</tr>  
			   <tr> 
					<td><?=LANG_PARENT?></td>
					<td>
						<div class="input-group"><div class="input-group-addon bg-sdt1"><i class="fa fa-folder-open" aria-hidden="true"></i>:</div> 
							<select name="id_parent" id="id_parent" class="requireData form-control">
								<option value="0">----</option>
								<?php 
								foreach(@$location as $cat):  
									$select = @$row['id_parent'] == $cat[0] ? ' selected="selected"' : '';							
									echo '<option value="'.$cat[0].'" '.$select.'>'.@$cat[1].'</option>';
								endforeach;
								?>
							</select>
						</div> 	
					</td>
				</tr>	  
			</table>
		</div>      
		
		<?php
		foreach($mod->languages as $lang): ?>
			<div id="tab_<?=$lang['code']?>">
				<table class="tblForm tblList" >
					<tr>
						<td><?= LANG_TITLE; ?>:</td>
						<td><input class="form-control <?= $lang['code']=='vn' ? 'requireData':''?>"  name="title_<?=$lang['code']?>" value="<?= $json->getDataJson1D(@@$row['title'], $lang['code'])?>"  /></td>
					</tr>  
				</table>
			</div> 
		<?php
		endforeach; 
		?> 
		  
		<input name="id_location" id="id_location" type="hidden" value="<?= !empty($row['id_location'])? $row['id_location']:'' ; ?>" />
		<input name="method" id="method" type="hidden" value="<?= $_GET['m']?>" />
		<input name="task" id="task" type="hidden" value="" />
	</form>
</div> 
