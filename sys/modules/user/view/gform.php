<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;
?>
<div class="box"> 
 	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= (($mod->method=='add')? LANG_ADD :  LANG_EDIT).' '.MENU_GROUP ?></h2> 
		<h2 class="col-md-6 text-right modBtn"><?php Admin::button('save, cancel')?></h2>
    </div>
	
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?> 
	
	<?php tabsLanguageAdmin(); ?>
      
	<form method="post" enctype="multipart/form-data" name="frm_list" id="frm_list" action="index.php?p=user&q=group">		
		<div id="tab_general">
			<table class="tblForm tblList" >                 
				<tr>
					<td>Option</td>
					<td>
						<ul class="list-inline">
							<li> <?php showAttrActive('publish', @$row['publish'], LANG_ENABLE)?> </li>  
						<ul>  
					</td>
				</tr>  
			</table>
		</div>
		
		<?php
		foreach($mod->languages as $lang): ?>
			<div id="tab_<?=$lang['code']?>">
				<table class="tblForm tblList" >
					<tr>
						<td width="50"><?=LANG_USER_GROUP?>:</td>
						<td><input class="form-control" name="name_<?=$lang['code']?>" value="<?=$json->getDataJson1D(@$row['name'], $lang['code'])?>"  /></td>
					</tr>
				</table>
			</div> 
		<?php
		endforeach; 
		?> 
		
		<input type="hidden" name="id_group" value="<?= @$row['id_group']; ?>" />
		<input type="hidden" name="method" value="<?= $_GET['m']?>" />
		<input type="hidden" id="task" name="task" value="" />
   </form>
</div> 
