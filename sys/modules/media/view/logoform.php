<?php if(!defined('DIR_APP')) die('Your have not permission');
global $json;   ?>
<div class="box">
 	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= (($mod->method=='add')? LANG_ADD : LANG_EDIT).' '.MENU_LOGO ?></h2> 
		<h2 class="col-md-6 text-right modBtn"><?php Admin::button('save, cancel'); ?></h2>
    </div>
	
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; 
	?>
  
 	<?php tabsLanguageAdmin(); ?>

	<form method="post" enctype="multipart/form-data" name="frm_list" action="index.php?p=media&q=logo">
		<div id="tab_general">
		  <table class="tblForm tblList">        
			<tr>
				<td>Option</td>
				<td>
					<ul class="list-inline">
						<li><?php showAttrActive('publish', @$row['publish'], LANG_ENABLE)?></li>  
					<ul>  
				</td>
			</tr>   
			<tr>
			  <td><?= LANG_UPLOAD ?></td>
			  <td>
				<div class="col-md-3 input-group">
					<input class="<?= $_GET['m']=='add'? 'requireData':''?>" name="image" type="file" id="imageUpload" accept="image/*" />
					<div class="input-group-addon bg-sdt1"> 
					<?=
					showImg('../'.DIR_UPLOAD.'/logo/'.$row['image'], 'logo/'.$row['image'], 'no-image.png', 20, 20, "", "", '', '');
					?>
					<span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="logo/<?=$row['image']?>"></span>
					</div> 
					<input name="old_image" id="old_image" type="hidden" value="<?= @$row['image'] ?>" />
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
						<td><input class="form-control"  name="title_<?=$lang['code']?>" value="<?= $json->getDataJson1D(@@$row['title'], $lang['code'])?>"  /></td>
					</tr>  
				</table>
			</div> 
		<?php
		endforeach; 
		?>   

		<input name="id_logo" id="id_logo" type="hidden" value="<?= @$row['id_logo'] ?>" />
		<input name="method" id="method" type="hidden" value="<?= $_GET['m']?>" />
		<input name="task" id="task" type="hidden" value="" />
	</form>
</div>
