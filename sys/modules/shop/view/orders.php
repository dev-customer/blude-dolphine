<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>
<script type="text/javascript">
	$( document ).ready(function() { 
		/* Open when someone clicks on the span element */
		$("body").on( "click", ".btn-item-view", function(e){ 
			$('#myNav .overlay-content').html('Loading...');
			$id = $(this).attr('data-id');	 
			$.post( "ajax.php?module=loadShopOrderItem", {'id': $id}, function(data) {  
				$('#myNav .overlay-content').html(data);  
				
				$('.priceFormat').priceFormat({
					clearPrefix: true,
					suffix: ' VNĐ',
					centsLimit: 0,
					centsSeparator: ',',
					thousandsSeparator: '.'
				}); 

		
				return false;
			});	   
			$("#myNav").css('width',"100%");
		}); 
		
		$("body").on( "click", ".approveOrder", function(e){ 
			$.post( "ajax.php?module=approveOrder", {'id': $(this).attr('data-id')}, function(data) { 
				alert('Đã duyệt...');
			});	  
		});
		
	}); 
</script>   

<div class="box"> 
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_SHOP_ORDER ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('delete'); ?></h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
      
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=shop&q=orders">
		<table class="tbltop" cellspacing="0" cellpadding="0" border="1" >
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
	 
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"><!-- Table -->
			<thead class="bg-sdt1">
				<tr>
					<th width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th>ID</th>
					<th><?= LANG_NAME?></th> 
					<th>Email</th> 
					<th>Phone</th> 
					<th>Address</th> 
					<th>Thanh toán</th> 
					<th>Ghi chú</th>                      
					<th>Date</th>
					<th>Status</th>                      
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
					$ptitle = $json->getDataJson1D($row['ptitle'], $_SESSION['dirlang']);
					?>
					<tr>
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_order']; ?>"></td>
						<td><?= $row['id_order']; ?></td>
						<td><?=$row['fullname']?></td>
						<td><?=$row['email']?></td>
						<td><?=$row['phone']?></td>
						<td><?=$row['address']?></td>
						<td><?=$ptitle?></td>
						<td><?=$row['description']?></td>
						<td><?=date("d-m-Y", strtotime($row['date']))?></td> 
						<td><?=$row['status']?></td>
						<td class="right" width="130px">
                            <?php  
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="shop_product_orders#id_order#'.$row['id_order'].'"><span class="glyphicon glyphicon-remove"></span></a>';
							Admin::view($row['id_order']);
							if($row['id_status'] > 1)
							echo '<a class="btn bg-sdt2 approveOrder" data-id="'.$row['id_order'].'" title="Duyệt"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>';
							?>
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
		<input class="attr-reset" type="hidden" value="category-publish" />
		<input type="hidden" name="task" id="task" value="" />      
	</form>
</div> 
  
  
