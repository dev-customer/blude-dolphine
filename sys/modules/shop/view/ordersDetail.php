<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;
?>
<div class="box"> <!-- Box begins here -->
	<div class="headMod">
      <h2 class="modTitle"> <?= MENU_MANAGE.' '.MENU_SHOP_ORDER ?></h2> 
	  <h2 class="modBtn"><?php Admin::button('delete'); ?></h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
      
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=shop&q=products&m=viewDetail">
	 
	 <table class="tblList" cellspacing="0" cellpadding="0"><!-- Table -->
          <thead>
				<tr>
					<th width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th>ID</th>
					<th>Product</th>        
					<th>Image</th>        
					<th>Price</th>        
					<th>Quality</th>					
					<th>Total</th>     
					<th>Link</th>					
					<th class="right"><?= LANG_ACTION; ?></th>
				</tr>
           </thead>
      		<?php 
			if( empty($rows) ) 
			{ ?>
                <tr>
                    <td class="center" colspan="12"><?= LANG_NO_RESULT; ?></td>
                </tr>
                <?php
            }else
			{			
				$page = isset($_GET['page'])? $_GET['page']: 1;
							
				$i= ($page-1)*PAGE_ROWS + 1;
				foreach($rows as $row):
					$rprice = $row['discount'] > 0 ? discountPrice($row['price'], $row['discount']) : $row['price'];
					$subTotal = $_SESSION['cart'][$row['id_product']] * $rprice;
					$title = $json->getDataJson1D($row['product'], $_SESSION['dirlang']);
				
					?>
					<tr>
						<td><input type="checkbox" name="id[]" value="<?= $row['id_order']; ?>"></td>
						<td><?= $row['id_order']; ?></td>
						<td><?=$title?></td> 
						<td>
                        <?=
                        showImg('../'.DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', 50, 50, "", "", '', '');
                        ?>												
						</td> 
						<td>
							<?php
							if($row['discount']>0){?>
								<span class="priceFormat"><?=$rprice?></span> - <del><span class="priceFormat discountPrice" style=""><?=$row['price']?></span></del>											
							<?php
							}else{?>
								<span class="priceFormat"><?=$rprice?></span>											
							<?php
							}?> 
						</td> 
						<td><?=$row['qty']?></td> 
						<td><?=($row['price']*$row['qty'])?></td> 
						<td><a href="<?=@$row['link']?>" target="_blank">Link SP</a></td>
						<td class="right" width="130px">
                            <?php  Admin::delete($row['id_order']); ?>
                        </td>
					</tr>
					<?php 
					$i++;
				endforeach;?>
                <tr >
                    <td class="center" colspan="12"> 
                    <?=$paging?>
                    </td>
                </tr>
			<?php	
			}?>
          
        </table>
		<input type="hidden" name="task" id="task" value="" />      
</form>
</div> 
  
  
