<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>
<div class="box"> 
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_SHOP_PRODUCT ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('add, delete'); ?></h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
      
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=shop&q=products">
		<table class="tbltop" cellspacing="0" cellpadding="0" border="1" ><!-- Table -->
			<thead>
				<tr>
					<th class="text-right"> 
						<ul class="list-inline  text-right actTopContent"> 
							<li> 
								<div class="input-group">
									<input class="form-control" id="search" name="search" placeholder="Search..." required  />
									<span class="input-group-btn bg-sdt1">
										<a class="bg-sdt1" id="button_search"><span class="btn glyphicon glyphicon-search"></span></a>
									</span>
								</div>
							</li>
							<li><?= $filter_cat?></li> 
							<li><?= $filter_publish?></li>
							<li>
								<div class="input-group">
									<a href="javascript:void(0);" class="btn bg-sdt1" id="button_reset"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> <?= LANG_ALL ?></a>				
									<input class="attr-reset" type="hidden" value="category-manuafact-publish" />
								</div>
							</li>
						</ul>      
					</th>
				</tr>
			</thead>
		</table>
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
			<thead class="bg-sdt1">
				<tr>
					<th width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th>ID</th>
					<th><?= LANG_NAME?></th>
					<th><?= LANG_IMAGE?></th>
					<th><?= ucfirst(MENU_CATALOG)?></th>
					<th><?= SHOP_PRODUCTS_PRICE?></th>
					<th><?= LANG_ENDABLE?></th>
					<th>HOT</th>
					<th><?= LANG_ORDER;?>&nbsp; <i class="fa fa-save submitform" style="color: yellow;"></i></th>
					<th width="150"><?= LANG_ACTION; ?></th>
				</tr>
			</thead>
      		<?php 
			if( empty($rows)) 
			{ ?>
                <tr>
                    <td colspan="12"><?= LANG_NO_RESULT; ?></td>
                </tr>
                <?php
            }else
			{			
				$page = isset($_GET['page'])? $_GET['page']: 1;
							
				$i= ($page-1)*PAGE_ROWS + 1;
				$listid ='';
				foreach($rows as $row):
					$link = LINK_SHOP_ITEM.$row['alias'].'.html';
					$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
					$category = $json->getDataJson1D($row['category'], $_SESSION['dirlang']);
					$listid .= '-'.$row['id_product'];
					?>
					<tr>
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_product']; ?>"></td>
						<td><?= $row['id_product']; ?></td>
						<td title="<?= @$row['alias'] ?>"><?=$title?></td>
                        <td>
                        <?=
                        showImg('../'.DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', 30, 30, "", "", ' img-circle', '');
                        ?>
                        </td>
						<td><?= $category?></td>
						<td><span class="priceFormat"><?= $row['price']?></span><?=$row['discount']>0?'(-'.$row['discount'].'%)':''?></td>
						<td>
							<img data-id="shop_products#id_product#<?=$row['id_product']?>" data-state="<?=$row['publish']?>" src="images/status-<?=$row['publish']?>.png"  class="pointer change-status-record" />						
						</td>
						<td>
							<img data-id="shop_products#id_product#<?=$row['id_product']?>#setHot" data-state="<?=$row['setHot']?>" src="images/status-<?=$row['setHot']?>.png"  class="pointer change-status-record" />						
						</td>
						<td class="col-md-1"><input type="number" class="orderring form-control" min="1" name="<?= $row['id_product']?>_id" value="<?= $row['orderring']; ?>"  style="width: 60px" /></td>					 
						<td width="130px">
							<a class="btn bg-sdt1" href="<?=$link?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
                            <?php 
							//Admin::delete($row['id_product']); 
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="shop_products#id_product#'.$row['id_product'].'"><span class="glyphicon glyphicon-remove"></span></a>';
							Admin::edit($row['id_product']); 
							?>
                        </td>
					</tr>
					<?php 
					$i++;
				endforeach;?>
                <tr>
                    <td class="center" colspan="12"> 
						<?=$paging?>
                    </td>
                </tr>
			<?php	
			}?>
          
        </table>
		<input type="hidden" name="listid"  value="<?=$listid?>" />      
		<input type="hidden" name="post_lang" id="post_lang" value="<?= $_SESSION['dirlang']?>" /> 
		<input type="hidden" name="task" id="task" value="" />      
	</form>
</div> 
  
  
