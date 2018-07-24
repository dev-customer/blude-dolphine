<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;
?>
<div class="box">  
	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert  modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= ($mod->method=='add')? LANG_ADD.' '.MENU_SHOP_MANUAFACT :  LANG_EDIT.' '.MENU_SHOP_MANUAFACT ?></h2> 
		<h2 class="col-md-6 text-right modBtn" ><?php Admin::button('save, cancel'); ?></h2>
    </div>

    <?php if(@$_SESSION['message']) { ?>
    	<div class="warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php } ?>
	
	<?php tabsLanguageAdmin(); ?>

    <form method="post" enctype="multipart/form-data"  name="frm_list" id="frm_list"  action="index.php?p=shop&q=manuafact">
		<div id="tab_general">
			<table class="tblForm tblList">
				<tr class="hidden">
					<td><?= LANG_ALIAS ?></td>
					<td><input name="alias" size="100" id="alias" value="<?= @$row['alias'] ?>"/> </td>
				</tr>
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
                <tr class="">
                    <td width="200">Image:</td>
                    <td> 
						<div class="input-group col-md-4">
							<div class="input-group-addon bg-sdt1">Image </div>
							<input type="file" name="image" class="form-control" id="imageUpload" accept="image/*"  />
							<div class="input-group-addon bg-sdt1"> 
							<?=
							showImg('../'.DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', 20, 20, "", "", 'zoom', '');
							?>                    
							<span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="shop/<?=$row['image']?>"></span>
							</div> 
							<input name="old_img" type="hidden" value="<?=@$row['image']?>" />
						</div>   
                    </td>
                </tr>	
				
			</table>
		</div>
		
		<?php
		foreach($mod->languages as $key => $lang): ?>
			<div id="tab_<?=$lang['code']?>">
				<table class="tblForm tblList" >
					<tr>
						<td><?= LANG_TITLE; ?>:</td>
						<td><input class="form-control <?= $lang['code']=='vn' ? 'requireData':''?>"  name="name_<?=$lang['code']?>" value="<?= $json->getDataJson1D(@@$row['name'], $lang['code'])?>"  /></td>
					</tr> 
					<tr>
						<td><?= LANG_CONTENT?>:</td>
						<td><textarea name="description_<?=$lang['code']?>" class="form-control"  ><?= str_replace("##","'", @$row['description_'.$lang['code']])?></textarea></td>
					</tr> 
				</table>
			</div> 
		<?php
		endforeach; 
		?>    
        
		<input name="id_manuafact" id="id_manuafact" type="hidden" value="<?= @$row['id_manuafact'] ?>" />
		<input name="method" type="hidden" value="<?= $_GET['m']?>" />
		<input name="task" id="task" type="hidden" value="" />
    </form>
</div>  
