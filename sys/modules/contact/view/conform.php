<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>
<style>
.list-link-social .input-group{ width:100%}
</style>
<div class="box"> 
	<div class="headMod bg-sdt1">
		<h2 class="col-md-6 text-left alert modTitle"><?= ($_GET['m']=='add'? LANG_ADD :  LANG_EDIT).' '.MENU_CONTACT?></h2> 
		<h2 class="col-md-6 text-right modBtn" ><?php Admin::button('save, cancel'); ?></h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?> 

	<?php tabsLanguageAdmin(); ?>
      
    <div class="content">
   		<form method="post" enctype="multipart/form-data" id="frm_list" name="frm_list" action="index.php?p=contact&q=contact">
			<div id="tab_general">
		    <table class="tblForm tblList" >          		
				<tr>
					<td>Option</td>
					<td>
						<ul class="list-inline">
							<li><?php showAttrActive('publish', @$row['publish'], LANG_ENABLE); ?> </li>  
						<ul>  
					</td>
				</tr>  
               <tr>
                    <td></td>
                    <td>
						<ul class="list-inline">
							<li class="col-md-3">	
								<div class="input-group"><div class="input-group-addon bg-sdt1"> Email</div> 
								<input name="email" style="width:190px" value="<?= @$row['email']?>" class="form-control"/>
								</div> 
							</li>
							<li class="col-md-2">	
								<div class="input-group"><div class="input-group-addon bg-sdt1">Phone</div> 
								<input name="phone" style="width:120px" value="<?= @$row['phone']?>" class="form-control"/>
								</div> 
							</li>
							<li class="col-md-2">
								<div class="input-group"><div class="input-group-addon bg-sdt1">Fax</div> 
									<input name="fax" style="width:120px"  value="<?= @$row['fax']?>" class="form-control"/>
								</div> 
							</li>
							<li class="col-md-2">
								<div class="input-group"><div class="input-group-addon bg-sdt1"><?= ucfirst(Tel)?>:</div> 
									<input name="tel" style="width:120px"  value="<?= @$row['tel']?>" class="form-control"/>
								</div> 
							</li>
							<li class="col-md-3 hidden">
								<div class="input-group"><div class="input-group-addon bg-sdt1"><?= ucfirst(GPKD)?>:</div> 
									<input name="gpkd" style="width:170px"  value="<?= @$row['gpkd']?>" class="form-control"/>
								</div> 
							</li>
						</ul>
					</td>
                </tr>              
				<tr>
                    <td>Website</td>
                    <td><input name="website" class="form-control" value="<?= @$row['website']?>"/></td>
                </tr>  
				<tr>
                    <td>Google Maps</td>
                    <td><input name="linkMaps" class="form-control" value="<?= @$row['linkMaps']?>"/></td>
                </tr>  
             	<tr>
                    <td>Link Social</td>
                    <td class="bg-danger"> 
						<ul class="list-inline list-link-social">
							<li class="col-md-6">	
								<div class="input-group"><div class="input-group-addon bg-sdt1">Facebook:</div> 
								<input name="linkFb"  value="<?= @$row['linkFb']?>" class="form-control"/>
								</div> 
							</li> 
							<li class="col-md-6">	
								<div class="input-group"><div class="input-group-addon bg-sdt1">Google +:</div> 
								<input name="linkGg"  value="<?= @$row['linkGg']?>" class="form-control"/>
								</div> 
							</li> 
							<li class="col-md-6">	
								<div class="input-group"><div class="input-group-addon bg-sdt1">Youtube:</div> 
								<input name="linkYu"  value="<?= @$row['linkYu']?>" class="form-control"/>
								</div> 
							</li> 
							<li class="col-md-6">	
								<div class="input-group"><div class="input-group-addon bg-sdt1">Instergram:</div> 
								<input name="linkInstergram"  value="<?= @$row['linkInstergram']?>" class="form-control"/>
								</div> 
							</li> 
							<li class="col-md-6">	
								<div class="input-group"><div class="input-group-addon bg-sdt1">Twiter:</div> 
								<input name="linkTw"  value="<?= @$row['linkTw']?>" class="form-control"/>
								</div> 
							</li> 
							<li class="col-md-6">	
								<div class="input-group"><div class="input-group-addon bg-sdt1">Pinterest:</div> 
								<input name="linkPinterest"  value="<?= @$row['linkPinterest']?>" class="form-control"/>
								</div> 
							</li> 
						</ul> 
						<style>
						.list-link-social .input-group-addon{ width:100px}
						</style>
						
					</td>
                </tr>   
                <tr>
                    <td><?= LANG_IMAGE ?></td>
                    <td> 
						<div class="col-md-3 input-group">
							<input name="image" type="file"  class="form-control" id="imageUpload" accept="image/*"  />
							<div class="input-group-addon bg-sdt1"> 
							<?=
							showImg('../'.DIR_UPLOAD.'/'.$row['image'], $row['image'], 'no-image.png', 20, 20, "", "", '', '');
							?>
							<span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="<?=$row['image']?>"></span>
							</div> 
							<input name="old_img" id="old_img" type="hidden" value="<?= @$row['image'] ?>" />
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
							<td><?= LANG_ADDRESS; ?>:</td>
							<td><input class="form-control <?= $lang['code']=='vn' ? 'requireData':''?>"  name="address_<?=$lang['code']?>" value="<?= $json->getDataJson1D(@@$row['address'], $lang['code'])?>"  /></td>
						</tr> 
						<tr>
							<td><?= LANG_ADDRES_GROUP; ?>:</td>
							<td> 
								<ul class="nav nav-tabs text-uppercase" role="tablist">
									<li role="presentation" class="active"><a class="bg-sdt1" href="#tab1" data-toggle="tab"><?= LANG_ADDRES_GROUP ?> 1</a></li>
									<li role="presentation"><a class="bg-danger" href="#tab2" data-toggle="tab"><?= LANG_ADDRES_GROUP ?> 2</a></li>
									<li role="presentation"><a class="bg-danger" href="#tab3" data-toggle="tab"><?= LANG_ADDRES_GROUP ?> 3</a></li>
								</ul>  
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="tab1">
										<textarea name="address_1_<?=$lang['code']?>" class="form-control"  ><?= str_replace("##","'", @$row['address_1_'.$lang['code']])?></textarea>
									</div> 
									<div role="tabpanel" class="tab-pane" id="tab2">
										<textarea name="address_2_<?=$lang['code']?>" class="form-control"  ><?= str_replace("##","'", @$row['address_2_'.$lang['code']])?></textarea>
									</div> 
									<div role="tabpanel" class="tab-pane" id="tab3">
										<textarea name="address_3_<?=$lang['code']?>" class="form-control"  ><?= str_replace("##","'", @$row['address_3_'.$lang['code']])?></textarea>
									</div> 
								</div>  
							</td>
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
  
			<input name="id_contact" id="id_contact" type="hidden" value="<?= @$row['id_contact']?>" />
			<input name="method" type="hidden" value="<?= $_GET['m']?>" />
			<input name="task" id="task" type="hidden" value="" />
        </form>
      </div>
</div>  
