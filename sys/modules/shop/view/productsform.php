<?php if(!defined('DIR_APP')) die('Your have not permission');
global $json, $cLocation; 
?>

<style type="text/css">

</style>
<div class="box">
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= ($mod->method=='add')? LANG_ADD :  LANG_EDIT.' '.MENU_SHOP_PRODUCT ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('save, cancel'); ?></h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; 
	?>

	<?php tabsLanguageAdmin(); ?>

	<div class="content"> 
		<form method="post" enctype="multipart/form-data"  name="frm_list" id="frm_list" action="<?= 'index.php?p='.$_GET['p'].'&q='.$_GET['q']?>">
			<div id="tab_general">
				<table class="tblForm tblList" >
					<tr>
						<td>Option</td>
						<td>
							<ul class="list-inline">
								<li><?php showAttrActive('publish', @$row['publish'], LANG_ENABLE);?></li> 
								<li><?php showAttrActive('setHot', @$row['setHot'], 'HOT'); ?></li> 
							<ul>  
						</td>
					</tr> 
					<tr> 
						<td><?= ucfirst(MENU_GROUP)?>  </td>
						<td>
							<ul class="list-inline">
								<li class="col-md-3">
									<div class="input-group">
										<div class="input-group-addon bg-sdt1"><i class="fa fa-folder-open" aria-hidden="true"></i> <?= ucfirst(MENU_SHOP_CATALOG)?></div> 
										<select name="id_cat" id="id_cat" class="requireData form-control">
											<option value="">---</option>
											<?php  
											foreach(@$category as $cat):
												$child = getCategoryShop($cat[0]);
												$disabled = (count($child)>0) ? ' disabled="disabled"' : '';
												$select = ($cat[0] == @$row['id_cat']) ? ' selected="selected"' : '';
												echo '<option '.$disabled.' value="'.$cat[0].'" '.$select.' >'.$cat[1].'</option>';						 							
											endforeach; 
											?>
										</select>
									</div> 
								</li> 
								<li class="col-md-3">
									<div class="input-group">
										<div class="input-group-addon bg-sdt1"> <?= ucfirst(MENU_SHOP_MANUAFACT)?></div> 
										<?php
										$dropList = $this->loadObjectList('SELECT * FROM #__shop_manuafact');
										echo dropDown('id_manuafact', $dropList, 'id_manuafact', 'name', @$row['id_manuafact'], 'class="requireData form-control"');
										?> 
									</div>
								</li> 
							</ul>							
						</td>
					</tr>  
					
					<tr>
						<td></td>
						<td>
							<ul class="list-inline">
								<li class="col-md-4"><div class="input-group"><div class="input-group-addon bg-sdt1">Code</div><input name="code" class="form-control"  value="<?= @$row['code'] ?>" /></div></li> 
								<li class="col-md-4"><div class="input-group"><div class="input-group-addon bg-sdt1"><?= SHOP_PRODUCTS_PRICE?></div><input name="price" class="form-control"  value="<?= @$row['price'] ?>" /></div></li> 
								<li class="col-md-4"><div class="input-group"><div class="input-group-addon bg-sdt1">Giảm giá(%)</div><input name="discount" class="form-control"  value="<?= @$row['discount'] ?>" /></div></li> 
							<ul> 
						</td>
					</tr>  
					<tr class=""> 
						<td>Link(ghi chú)</td>
						<td>
							 <input class="form-control"  name="link" value="<?=@$row['link']?>"  />
						</td>
					</tr>		
					<tr>
						<td>Image:</td>
						<td> 
							<table class="table table-bordered">
								<tr> 
									<td> 
										<div class="input-group ">
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
									<td> 
										<div class="input-group  tblImageParam">
											<div class="input-group-addon bg-sdt1">Image List </div>
											<input type="file" name="imageList[]" multiple="multiple" accept="image/*" class="form-control maxFileListUpload" data-number="10"  />
											<input type="hidden" name="imageListOld" value="<?=base64_encode(@$row['imageList'])?>" />                
										</div> 
										<ul class="list-group list-inline  ">
										<?php 
										$imageList = json_decode(@$row['imageList']); 
										foreach($imageList as $value) 
											if(is_file('../'.DIR_UPLOAD.'/shop/'.$value))
												echo '<li><img src="'.URL_UPLOAD.'shop/'.$value.'" width="50" height="50" class="" /><span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="../'.DIR_UPLOAD.'/shop/'.$value.'"></span></li>';
										?>
										</ul>
										<input name="old_imglist" type="hidden" value="<?=@$row['imageList']?>" />																					
									</td>
								</tr>
							</table> 
						</td>
					</tr> 
					<tr>
						<td>Color</td>
						<td class="bg-danger">
							<div class="col-md-6" style="border-right:1px solid yellow">
								<div class="panel-heading">
									Color:
								</div>
								<div class="clearfix">
									<table class="table table-bordered table-data-book tblGroupDyn" id="tab_logic" style="width:50%; background:#ddd">
										<thead style="background-color:#ccc;color: #218c8d">
											<tr>
											  <th>#</th>
											  <th>Color</th>
											  <th>Image</th>
											</tr>
										</thead>
										<tbody>
											<?php
											 
											$i=1;
											if(@$row['jsColorGroup'] != '')
											{ 
												$jsColorGroup = json_decode(@$row['jsColorGroup']); 
												foreach($jsColorGroup as $key => $value): 
													$color = 'color';
													$image = 'image';
													$src = '../'.DIR_UPLOAD.'/shop/'.$value->$image;
													?>
													<tr id='addr<?=$i?>'>
														<th scope="row"><?=$i?></th>
														<td><input type="color" name="color<?=$i?>" onchange="clickColor(0, -1, -1, 5)" value="<?=$value->$color?>" style="padding:0" /></td>
														<td>
															<div class="input-group">
																<input type="file" name="colorImage<?=$i?>" id="colorImage<?=$i?>" accept="image/*" />
																<input type="hidden" name="jsColorImageItem<?=$i?>" value="<?=$value->$image?>"/>
																<div class="input-group-addon">
																	<img src="<?=is_file($src)? $src : URL_UPLOAD.'no-image.png'?>" width="30" height="30" /><span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="<?=$src?>"></span>
																</div>
															</div>
														</td>
													</tr> 
												<?php
												$i++;
												endforeach;
											}
											else{?>
												<tr id='addr1'>
													<th scope="row">1</th>
													<td><input type="color" name="color1" id="color1"  style="padding:0" /></td>
													<td><input type="file" name="colorImage1" id="colorImage1"  accept="image/*" /></td>
												</tr> 
											<?php
											}
											?>
											<tr id="addr<?=$i?>"></tr>					
										</tbody>
									</table>
									<p class="col-md-6 text-left" style="padding-right: 0;">
										<button type="button" class="btn bg-sdt1" id="add_row"><span class="glyphicon glyphicon-plus"></span> Add</button>
										<button type="button" class="btn bg-sdt1" id="delete_row"><span class="glyphicon glyphicon-remove"></span> Remove</button>							
										<input type="hidden" name="numberRowDyn" id="numberRowDyn" value="<?=$i?>"/>
										<input type="hidden" name="jsColorGroup" value="<?=@$row['jsColorGroup']?>"/>
									</p>
									<script type="text/javascript">
										$(document).ready(function(){ 
											var i=<?=$i?>;
											$('body').on('click', '#add_row', function (e) { 
													$('#addr'+i).html("<td>"+ (i) +"</td><td><input type='color' name='color"+i+"' id='color"+i+"' style='padding:0' /></td><td><input type='file' name='colorImage"+i+"' id='colorImage"+i+"' /></td>");
													$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
													i++; 
													$('#numberRowDyn').val(i);
											});
											
											$('body').on('click', '#delete_row', function (e) {  
													if(i>1){
														$("#addr"+(i-1)).html('');
														i--;
														$('#numberRowDyn').val(i);
													}
											});
											
										});	
									</script>						
								</div>
							</div>
							<div class="col-md-6">
								<div class="panel-heading">
									Size:
								</div>
								<div class="clearfix">
									<table class="table table-bordered table-data-book tblGroupDyn" id="tab_logic_size" style="width:50%; background:#ddd">
										<thead style="background-color:#ccc;color: #218c8d">
											<tr>
											  <th>#</th>
											  <th>Size</th> 
											</tr>
										</thead>
										<tbody>
											<?php
											 
											$i2=1;
											if(@$row['jsSizeGroup'] != '') //not empty
											{ 
												$jsSizeGroup = json_decode(@$row['jsSizeGroup']); 
												foreach($jsSizeGroup as $key => $value): 
													$size = 'size';
													$image = 'image'; 
													?>
													<tr id='addrSize<?=$i2?>'>
														<th scope="row"><?=$i2?></th>
														<td><input name="size<?=$i2?>" value="<?=$value->$size?>" /></td> 
													</tr> 
												<?php
												$i2++;
												endforeach;
											}
											else{?>
												<tr id='addrSize1'>
													<th scope="row">1</th>
													<td><input name="size1" id="size1" /></td> 
												</tr> 
											<?php
											}
											?> 			
										</tbody>
									</table>
									<p class="col-md-6 text-left" style="padding-right: 0;">
										<button type="button" class="btn bg-sdt1" id="add_row_size"><span class="fa fa-plus"></span> Add</button>
										<button type="button" class="btn bg-sdt1" id="delete_row_size"><span class="fa fa-remove"></span> Remove</button>							
										<input type="hidden" name="numberRowDynSize" id="numberRowDynSize" value="<?=$i2?>"/>
										<input type="hidden" name="jsSizeGroup" value="<?=@$row['jsSizeGroup']?>"/>
									</p>
									<script type="text/javascript">
										$(document).ready(function(){ 
											var i=<?=$i2?>;
											$('body').on('click', '#add_row_size', function (e) { 
													
													//alert(i); return;
											
													$('#addrSize'+i).html("<td>"+ (i) +"</td><td><input name='size"+i+"' id='size"+i+"' /></td>");
													$('#tab_logic_size').append('<tr id="addrSize'+(i+1)+'"></tr>');
													i++; 
													$('#numberRowDynSize').val(i);
											});
											
											$('body').on('click', '#delete_row_size', function (e) {  
													if(i>1){
														$("#addrSize"+(i-1)).html('');
														i--;
														$('#numberRowDynSize').val(i);
													}
											});
											
										});	
									</script> 
								</div>
							</div>
						
						</td>
					</tr>
                    <tr>
                        <td>
                            Nhập giá sĩ
                        </td>
                        <td>
                            <div class="col-md-6">
                                <div class="panel-heading">
                                    Giá sĩ:
                                </div>
                                <div class="clearfix">
                                    <table class="table table-bordered table-data-book tblGroupDyn"
                                           id="tab_logic_soluong" style="width:50%; background:#ddd">
                                        <thead style="background-color:#ccc;color: #218c8d">
                                        <tr>
                                            <th>#</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $i=1;
                                        if(@$row['jsSoluong'] != '')
                                        {
                                            $jsSoLuong = json_decode(@$row['jsSoluong']);
                                            foreach($jsSoLuong as $key => $value):
                                                $gia = 'gia';
                                                $soluong = 'soluong';
                                                ?>
                                                <tr id='addsoluongr<?=$i?>'>
                                                    <th scope="row"><?=$i?></th>
                                                    <td>
                                                        <input type="text" name="gia<?=$i?>" value="<?php
                                                        echo $value->$gia; ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="soluong<?=$i?>" value="<?php
                                                        echo $value->$soluong; ?>"/>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            endforeach;
                                        }
                                        else{?>
                                            <tr id='addsoluongr1'>
                                                <th scope="row">1</th>
                                                <td><input type="text" name="gia1" id="gia1" /></td>
                                                <td><input type="text" name="soluong1" id="soluong1"/>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr id="addr<?=$i?>"></tr>
                                        </tbody>
                                    </table>
                                    <p class="col-md-6 text-left" style="padding-right: 0;">
                                        <button type="button" class="btn bg-sdt1" id="add_row_soluong"><span
                                                    class="glyphicon glyphicon-plus"></span> Add</button>
                                        <button type="button" class="btn bg-sdt1" id="delete_row_soluong"><span
                                                    class="glyphicon glyphicon-remove"></span> Remove</button>
                                        <input type="hidden" name="numberRowDynSoluong" id="numberRowDynSoluong"
                                               value="<?=$i?>"/>
                                        <input type="hidden" name="jsSoluong" value="<?=@$row['jsSoluong']?>"/>
                                    </p>
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            var i=<?=$i?>;
                                            $('body').on('click', '#add_row_soluong', function (e) {
                                                $('#addsoluongr'+i).html("<th>"+ (i) +"</th><td><input type='text' " +
                                                    "name='gia"+i+"' id='gia"+i+"' /></td><td><input type='text' " +
                                                    "name='soluong"+i+"' id='soluong"+i+"' /></td>");
                                                $('#tab_logic_soluong').append('<tr id="addsoluongr'+(i+1)+'"></tr>');
                                                i++;
                                                $('#numberRowDynSoluong').val(i);
                                            });

                                            $('body').on('click', '#delete_row_soluong', function (e) {
                                                if(i>1){
                                                    $("#addsoluongr"+(i-1)).html('');
                                                    i--;
                                                    $('#numberRowDynSoluong').val(i);
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </td>
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
			foreach($mod->languages as $key => $lang): ?>
				<div id="tab_<?=$lang['code']?>">
					<table class="tblForm tblList" >
						<tr>
							<td><?= LANG_TITLE; ?>:</td>
							<td><input class="form-control <?= $lang['code']=='vn' ? 'requireData':''?>"  name="title_<?=$lang['code']?>" value="<?= $json->getDataJson1D(@@$row['title'], $lang['code'])?>"  /></td>
						</tr> 
						<tr>
							<td><?=LANG_CONTENT?>:</td>
							<td> 
								<ul class="nav nav-tabs text-uppercase" role="tablist">
									<li role="presentation" class="active"><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> <?=LANG_DESCRIPTION?></a></li>
									<li role="presentation"><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> <?=SHOP_SUMMARY?></a></li>
								</ul>  
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="tab2">
										<textarea name="description_<?=$lang['code']?>" id="editor<?=$key?>" class="form-control"><?= str_replace("##","'", @$row['description_'.$lang['code']])?></textarea>
									</div> 
									<div role="tabpanel" class="tab-pane" id="tab1">
										<textarea name="summary_<?=$lang['code']?>" id="editor<?=$key+1?>" class="form-control"  ><?= str_replace("##","'", @$row['summary_'.$lang['code']])?></textarea>
									</div> 
								</div>    
							</td>
						</tr>  
					</table>
				</div> 
			<?php
			endforeach; 
			?>    
				  
			<input name="id_product" id="id_product" type="hidden" value="<?= @$row['id_product']?>" />
			<input name="method" type="hidden" value="<?= $_GET['m']?>" />
			<input name="task" id="task" type="hidden" value="" />
        </form>  
	</div>    
</div>  