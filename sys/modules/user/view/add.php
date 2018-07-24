<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;
?>
<div class="box">  
 	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= (($mod->method=='add')? LANG_ADD :  LANG_EDIT).' '.MENU_USER ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('save, cancel'); ?></h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
	
	<?php tabsLanguageAdmin(); ?>
      
    <form method="post" enctype="multipart/form-data" name="frm_list" id="frm_list" action="index.php?p=user&q=user">		
        <div id="tab_general">
			<table class="tblForm tblList">
				<tr>
					<td>Option</td>
					<td>
						<ul class="list-inline">
							<li> <?php showAttrActive('publish', @$row['publish'], LANG_ENABLE)?> </li>  
						<ul>  
					</td>
				</tr>  
				<tr>
					<td><?= LANG_USER_GROUP; ?>:</td>
					<td>
						<select name="id_group" class="col-md-3 form-control">
						<?php
							foreach($group as $val) 
								echo '<option value="'.$val['id_group'].'" '.($row['id_group']==$val['id_group'] ? 'selected="selected"' : '').'>'.$json->getDataJson1D(@$val['name'], $_SESSION['dirlang']).'</option>';
						?>
						</select>
					</td>
				</tr>                   
				<tr>
					<td><?= LANG_USER_USENAME; ?>:</td>
					<td><input class="requireData form-control"  name="username"  value="<?= @$row['username']; ?>"  /> </td>
				</tr>
				<tr>
					<td><?= LANG_USER_PASSWORD; ?>:</td>
					<td><input type="password" name="password" class=" form-control" /> </td>
				</tr>
				<tr>
					<td><?= LANG_USER_EMAIL; ?>:</td>
					<td><input type="text" name="email"  value="<?= @$row['email']; ?>" class=" form-control"  />  </td>
				</tr>   
			</table>
		</div>
		
		<?php
		foreach($mod->languages as $lang): ?>
			<div id="tab_<?=$lang['code']?>">
				<table class="tblForm tblList" >
					<tr>
						<td><?= LANG_USER_FULLNAME; ?>:</td>
						<td>
							<div class="col-md-6" style="padding-left:0"><input class="form-control"  name="firstname_<?=$lang['code']?>"  value="<?= $json->getDataJson1D(@$row['firstname'], $lang['code'])?>" placeholder="firstname" /></div> 
							<div class="col-md-6" style="padding-right:0"><input class="form-control"  name="lastname_<?=$lang['code']?>"  value="<?= $json->getDataJson1D(@$row['lastname'], $lang['code'])?>" placeholder="lastname"  /></div> 
						</td>
					</tr>
					<tr>
						<td><?= LANG_USER_FULLNAME; ?>:</td>
						<td><input class="form-control <?= $lang['code']=='vn' ? 'requireData':''?>" name="fullname_<?=$lang['code']?>" value="<?= $json->getDataJson1D(@$row['fullname'], $lang['code'])?>"  /></td>
					</tr> 
				</table>
			</div> 
		<?php
		endforeach; 
		?>  
		
        <input name="id_user" id="id_user" type="hidden" value="<?= @$row['id_user']?>" />
        <input name="method" type="hidden" value="<?= $_GET['m']?>" />
        <input name="task" id="task" type="hidden" value="" />
    </form>
  </div> <!-- END Box-->
