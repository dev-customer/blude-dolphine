<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;
?>
<style>
.input-group-addon{ color:#000 !important}
.bg-sdt2{ color:#fff !important}
</style>
<div class="box"> 
 	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_CONFIG ?></h2> 
		<h2 class="col-md-6 text-right modBtn"><?php Admin::button('save, cancel'); ?></h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
 
	<div id="tabs" class="htabs">
		<a tab="#tab_general"><span class="glyphicon glyphicon-cog"></span> General</a>
		<a tab="#tab_image"><span class="glyphicon glyphicon-picture"></span> Image</a>
		<a tab="#tab_template"><i class="fa fa-laptop" aria-hidden="true"></i> Template</a>
	</div>	 

	<form method="post" enctype="multipart/form-data" name="frm_list"  id="frm_list" action="index.php?p=sys&q=config">
		<div id="tab_general">
			<table  class="tblForm tblList" >
				<tr>
				<?php  
				if($_SESSION['id_group'] <= 0):?>
					<td>Active Site</td>
					<td>
						<ul class="list-inline">
							<li><?php showAttrActive('activeSite', @$row['activeSite'], LANG_ENABLE)?></li>
						</ul>
					</td>
				</tr>
				<?php
				endif;?>
				<tr>
				<?php  
				if($_SESSION['id_group'] <= 1):?>
					<td>SEO</td>
					<td>
						<ul class="list-inline">
							<li><?php showAttrActive('activeSEO', @$row['activeSEO'], LANG_ENABLE)?></li>
						</ul>
					</td>
				</tr>
				<?php
				endif;?>
				<tr>
					<td><?=REGISTER_GROUP?></td>
					<td> 
						<?php  
						echo dropDown('id_group', $groups, 'id_group', 'name', @$row['id_group'], 'class="form-control"');
						?> 
					</td>
				</tr>
				<tr>
					<td><?=LB_LANGUAGE?></td>
					<td> 
						<ul class="list-inline">
						<?php
						$languages = $this->loadObjectList('SELECT * FROM #__language');
						foreach($languages as $value):
							$checked = $value['publish']==1 ? 'checked="checked"':'';
							?>
							<li><input type="checkbox" name="languageActive[]" value="<?=$value['id_lang']?>" <?=$checked?> /> <span><?=$value['name']?></span></li>
						<?php
						endforeach; 
						?> 
						</ul>
					</td>
				</tr>
				<tr>
					<td>Google Analytics ID</td>
					<td><input name="googleAnalyticsID" class="form-control" value="<?=@$row['googleAnalyticsID']?>" />
					</td>
				</tr>
				<tr>
					<td>Facebook Apps ID</td>
					<td><input name="facebookAppID" class="form-control" value="<?=@$row['facebookAppID']?>" /></td>
				</tr>
				<tr>
					<td>Chatbox Zopim</td>
					<td><textarea name="chatboxZopim" class="form-control bg-danger"  ><?=base64_decode(@$row['chatboxZopim'])?></textarea></td>
				</tr>
				<tr>
					<td>Chatbox FB</td>
					<td><textarea name="chatboxFB" class="form-control bg-danger"  ><?=base64_decode(@$row['chatboxFB'])?></textarea></td>
				</tr>
				<tr>
					<td><?= LANG_META_TITLE ?></td>
					<td><textarea name="meta_title" class="form-control"  ><?=@$row['meta_title']?></textarea></td>
				</tr>
				<?php
				if($mod->config['activeSEO']==1):?>				
				<tr>
					<td><?= LANG_META_KEWYORDS ?></td>
					<td><textarea name="meta_keyword" class="form-control meta_keyword"  ><?=@$row['meta_keyword']?></textarea></td>
				</tr>
				<tr>
					<td><?= LANG_META_DESCRIPTION ?></td>
					<td><textarea  name="meta_description" class="form-control  meta_description "><?=@$row['meta_description']?></textarea> </td>
				</tr> 
				<?php
				endif;
				?>
			</table>
		</div> 
		
		<div id="tab_image">
			<table  class="tblForm tblList" > 
				<tr>
					<td>Image News(height)</td>
					<td><input name="imageNews" class="form-control" value="<?=@$row['imageNews']?>" /> </td>
				</tr>
				<tr>
					<td>Image Shop(height)</td>
					<td><input name="imageShop" class="form-control" value="<?=@$row['imageShop']?>" /></td>
				</tr> 
			</table>
		</div> 
		<div id="tab_template">
			<table  class="tblForm tblList" > 
				<tr>
					<td>Color Layout</td>
					<td>
						<ul class="list-inline">
							<li>
								<div class="input-group">
									<div class="input-group-addon"><label>1:</label> <input type="color" name="colorMain1" onchange="clickColor(0, -1, -1, 5)" value="<?=@$row['colorMain1']?>" style=" padding:0"/></div>
									<input name="colorMain1Code" class="form-control" style="width:100px" placeholder="#ffffff" />
								</div> 
							</li>
							<li>
								<div class="input-group">
									<div class="input-group-addon"><label>2:</label> <input type="color" name="colorMain2" onchange="clickColor(0, -1, -1, 5)" value="<?=@$row['colorMain2']?>" style=" padding:0"  /></div>
									<input name="colorMain2Code" class="form-control" style="width:100px" placeholder="#ffffff" />
								</div>
							</li>
							<li>
								<div class="input-group">
									<div class="input-group-addon">3: <input type="color" name="colorMain3" onchange="clickColor(0, -1, -1, 5)" value="<?=@$row['colorMain3']?>" style=" padding:0"  /></div>
									<input name="colorMain3Code" class="form-control" style="width:100px"  placeholder="#ffffff"/>
								</div> 
							</li>
							<li>
								<div class="input-group">
									<div class="input-group-addon">4: <input type="color" name="colorMain4" onchange="clickColor(0, -1, -1, 5)" value="<?=@$row['colorMain4']?>" style=" padding:0" /></div>
									<input name="colorMain4Code" class="form-control" style="width:100px"  placeholder="#ffffff" />
								</div> 
							</li> 
						</ul>   
					</td>
				</tr> 
			</table>
		</div> 
		
        <input type="hidden" name="id_config" value="<?= @$row['id_config']?>" />  
		<input type="hidden" name="task" id="task" value="" />
	</form>
</div> 