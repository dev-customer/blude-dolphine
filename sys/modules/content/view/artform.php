<?php if(!defined('DIR_APP')) die('Your have not permission');
global $json, $mod;
?>
<div class="box">
	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= ($mod->method=='add' ? LANG_ADD : LANG_EDIT).' '.MENU_ARTICLE ?></h2> 
		<h2 class="col-md-6 text-right modBtn" >  <?php Admin::button('save, cancel'); ?>  </h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
      
 	<?php tabsLanguageAdmin(); ?>

	<div class="content"> 
        <form name="frm_list" id="frm_list" method="post" enctype="multipart/form-data" action="index.php?p=content&q=article">				
        <div id="tab_general">
            <table class="tblForm tblList" >
				<tr>
					<td>Option</td>
					<td>
						<ul class="list-inline">
							<li><?php showAttrActive('publish', @$row['publish'], LANG_ENABLE)?></li>  
							<li><?php showAttrActive('setHome', @$row['setHome'], "Home")?></li>  
						<ul>  
					</td>
				</tr>   
				<tr>
                    <td><?= ucfirst(MENU_GROUP)?></td>
                    <td> 
						<div class="input-group col-md-5"><div class="input-group-addon bg-sdt1"><?= ucfirst(MENU_SHOP_CATALOG)?>:</div> 
							<select name="category" id="category" class="requireData form-control">
								<?php  
								foreach(@$category as $cat):
									$child = getCategoryInfo($cat[0]);
									$disabled = (count($child)>0) ? ' disabled="disabled"' : '';
									$select = ($cat[0] == @$row['id_cat']) ? ' selected="selected"' : '';
									echo '<option '.$disabled.' value="'.$cat[0].'" '.$select.' >'.$cat[1].'</option>';						 							
								endforeach; 
								?>
							</select>
						</div> 
                    </td>
                </tr>
				<tr>
					<td>Image:</td>
					<td> 
						<table class="table table-bordered">
							<tr> 
								<td> 
									<div class="input-group">
										<div class="input-group-addon bg-sdt1">Image </div>
										<input type="file" name="image" class="form-control" id="imageUpload" accept="image/*"  />
										<div class="input-group-addon bg-sdt1"> 
										<?=
										showImg('../'.DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', 20, 20, "", "", 'zoom', '');
										?>                    
										<span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="content/<?=$row['image']?>"></span>
										</div>	 
										<input type="hidden" name="old_img" value="<?= @$row['image']; ?>" />
									</div>  
								</td>
								<td> 
									<div class="input-group tblImageParam">
										<div class="input-group-addon bg-sdt1">Image List </div>
										<input type="file" name="imageList[]" class="form-control maxFileListUpload" data-number="10" multiple="multiple" accept="image/*" />
										<ul class="list-group list-inline">
										<?php 
										$imageList = json_decode(@$row['imageList']);
										foreach($imageList as $value) 
											if(is_file('../'.DIR_UPLOAD.'/content/'.$value))
												echo '<li><img src="'.URL_UPLOAD.'content/'.$value.'" width="50" height="50" class="" /><span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="../'.DIR_UPLOAD.'/content/'.$value.'"></span></li>';
										?>
										</ul>
										<input type="hidden" name="imageListOld" value="<?=base64_encode(@$row['imageList'])?>" />                
									</div> 
								</td>
							</tr>
						</table> 
					</td>
				</tr>	 
                <tr class="hidden"> 
                    <td>Link</td>
                    <td><input name="link" class="form-control"  value="<?=@$row['link']?>" /> </td>
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
				endif;
				?>
			</table>
        </div>     
		
		<?php
		foreach($mod->languages as $key => $lang): ?>
			<div id="tab_<?=$lang['code']?>">
				<table class="tblForm tblList" >
					<tr>
						<td><?= LANG_TITLE; ?>:</td>
						<td><input class="form-control <?= $lang['code']=='vn' ? 'requireData':''?>"  name="title_<?=$lang['code']?>" value="<?= $json->getDataJson1D(@@$row['title'], $lang['code'])?>"  /></td>
					</tr> 
					<tr>
						<td><?= LANG_CONTENT?>:</td>
						<td>
							<ul class="nav nav-tabs text-uppercase" role="tablist">
								<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> <?=LANG_DESCRIPTION?></a></li>
								<li role="presentation"><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> <?=SHOP_SUMMARY?></a></li>
							</ul>  
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="tab1">
									<textarea name="content_<?=$lang['code']?>" id="editor<?=$key?>" class="form-control"><?= str_replace("##","'", @$row['content_'.$lang['code']])?></textarea>
								</div> 
								<div role="tabpanel" class="tab-pane" id="tab2">
									<textarea name="summary_<?=$lang['code']?>" class="form-control"  ><?= str_replace("##","'", @$row['summary_'.$lang['code']])?></textarea>
								</div> 
							</div>    
						</td>
					</tr> 
				</table>
			</div> 
		<?php
		endforeach; 
		?>   
		
        <input type="hidden" name="id_art" id="id_art" value="<?= @$row['id_art']?>" />
        <input type="hidden" name="method" value="<?=$_GET['m']?>" />
        <input type="hidden" name="task" id="task"value="" />
        </form>
		</div>       
	</div>
</div> 
 