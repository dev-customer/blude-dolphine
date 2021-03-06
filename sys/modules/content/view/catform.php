<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;  
?>
<script type="text/javascript">
	$(document).ready(function(){
		// disable option like this cat (action edit)
		var method = $('#method').val();
		var cat = $('#id_cat').val();
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
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= (($mod->method=='add')? LANG_ADD : LANG_EDIT).' '.MENU_CATALOG ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('save, cancel'); ?></h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-centers"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>

 	<?php tabsLanguageAdmin(); ?>
	
	<form method="post" enctype="multipart/form-data" name="frm_list" id="frm_list" action="index.php?p=content&q=category">
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
								foreach(@$category as $cat):  
									$select = @$row['id_parent'] == $cat[0] ? ' selected="selected"' : '';							
									echo '<option value="'.$cat[0].'" '.$select.'>'.@$cat[1].'</option>';
								endforeach;
								?>
							</select>
						</div> 	
					</td>
				</tr>	
				<tr>
					<td><?= LANG_IMAGE ?></td>
					<td>
						<div class="input-group col-md-3">
							<div class="input-group-addon bg-sdt1"><i class="glyphicon glyphicon-picture" aria-hidden="true"></i></div>
							<input type="file" name="image" class="form-control"  id="imageUpload" accept="image/*" />
							<div class="input-group-addon bg-sdt1"> 
							<?=
							showImg('../'.DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', 20, 20, "", "", '', '');
							?>
							<span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="content/<?=$row['image']?>"></span>						
							</div> 
						</div>   
					</td>
				</tr>       
				<tr class=""> 
					<td>Link</td>
					<td><input name="link" class="form-control" value="<?=@$row['link']?>" /> </td>
				</tr>  
				<?php
				if($mod->config['activeSEO']==1):?>
				<tr>
					<td><?= LANG_META_KEWYORDS ?></td>
					<td><textarea name="meta_keywords" class="form-control bg-danger meta_keyword chkMaxLength"  maxlength="160" ><?= @$row['meta_keywords']?></textarea> 
					<span class="required">Max: 160 character</span></td>
				</tr>
				<tr>
					<td><?= LANG_META_DESCRIPTION ?></td>
					<td><textarea  name="meta_description" class="form-control  bg-danger meta_description"><?= @$row['meta_description']?></textarea> </td>
				</tr> 
				<?php
				endif?>
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
					<tr>
						<td><?= LANG_CONTENT?>:</td>
						<td><textarea name="content_<?=$lang['code']?>" class="form-control"  ><?= str_replace("##","'", @$row['content_'.$lang['code']])?></textarea></td>
					</tr> 
				</table>
			</div> 
		<?php
		endforeach; 
		?> 
		  
		<input name="id_cat" id="id_cat" type="hidden" value="<?= !empty($row['id_cat'])? $row['id_cat']:'' ; ?>" />
		<input name="old_img" id="old_img" type="hidden" value="<?= @$row['image']; ?>" />
		<input name="method" id="method" type="hidden" value="<?= $_GET['m']?>" />
		<input name="task" id="task" type="hidden" value="" />
	</form>
</div> 
