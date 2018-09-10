<?php define('DIR_APP', 'TBL');
session_start();
if(isset($_GET['lang']))
	$_SESSION['dirlang'] = $_GET['lang'];
elseif(!isset($_SESSION['dirlang']) || $_SESSION['dirlang']=='')
	$_SESSION['dirlang'] = 'vn'; 

include('../config.php');
include('../lib/database.php');
include('../lib/module.php');
include('../lib/func_extend.php');
include('../lib/PA.smtp.php');
include('../lib/db.shop.php');
include('../lib/Json.Class.php');
$json = new JsonData;
$db = new Database;
$db->connect($dbhost, $dbuser, $dbpass, $dbname);
$mod = new Module;
$mod->lang('index', '../'); 

$fn = !empty($_GET['module'])? $_GET['module']:'';
if($fn!='')
	$fn();
else
	header('location: ../index.php'); 

function test(){
	
}

function unsetPopupHomepage(){
	if($_POST['unsetpop']==1 && $_SESSION['unsetpop']==''){
			$_SESSION['unsetpop'] = 1;  
			echo $_SESSION['unsetpop'];
	}
}

function sendNewsleter(){
	global $db;
	extract($_POST);
	//check exists
	$row = $db->loadObject('SELECT * FROM #__contact_newsletter WHERE email = "'.$email.'"');
	if($row){
		echo 'Email này đã tồn tại!';
	}else{
		$db->query('INSERT INTO #__contact_newsletter SET email ="'.$email.'", date = NOW()');
		echo 'success';
	}
} 
 
function sendContact(){
	global $db;
	extract($_POST);
	if(isset($_POST))
	{
		$sql = 'INSERT INTO #__contact_msg SET
						name =  "'.$ctname.'", 
						email =  "'.$ctemail.'",
						tel =  "'.$ctphone.'",
						content =  "'.$ctcontent.'",
						date = NOW()';
		$db->query($sql); 		 	
	}
} 


function changeLangSite(){
	if(isset($_POST['lang']) && $_POST['lang'] !='') 
		$_SESSION['dirlang'] = $_POST['lang']; 		 
}


function addCartShop()
{
	global $json, $db, $mod;
	extract($_POST);
	if($id !='')
	{	
	 	$qty = $number > 0 ? $number : 1; 
	 
		if(isset($_SESSION['cart'][$id]))
			$qty = $_SESSION['cart'][$id]['number'] + $qty;
			
		$_SESSION['cart'][$id]['number'] = $qty; 
		$_SESSION['cart'][$id]['color']  = $color; 
		$_SESSION['cart'][$id]['size']   = $size; 

		$idList = implode(',', array_keys($_SESSION['cart'])); 
		 
		$sqlExt = " AND p.publish = 1 AND id_product IN (".$idList.")";				
		$data = loadListShop('', $sqlExt);  		
		?>        
        <div class="modal-header bg-sdt1">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><i class="fa fa-cart-plus" aria-hidden="true"></i> <?=LB_ORDER?></h4>
        </div>
		<div class="modal-body">
			<script>
				$(document).ready(function(e){
					$('.numberPopup').change(function(){
						$id = $(this).attr('data-id');
						$number = $(this).val();
						if($number > 0)
						{
							//alert($(this).val());
							
							$.post( "ajax/ajax.php?module=updateCartShop", {'id': $id, 'number': $number}, function( data ) { 
								alert('Value changed!');
							});
							
						}else{
							alert('Number greater than zero!');
						}
							
					});
					
					$('.priceFormat').priceFormat({
						clearPrefix: true,
						suffix: ' VNĐ',
						centsLimit: 0,
						centsSeparator: ',',
						thousandsSeparator: '.'
					}); 
					
				});
			</script>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						  <th>Image</th>
						  <th><?=MENU_PRODUCT?></th>
						  <th class="text-center">Price</th>
						  <th class="text-center">Number</th>
						  <th class="text-center">Total</th>
						  <th class="text-center">Remove</th>
					</tr>
				</thead>					
				<tbody>
					<?php
					$total = 0;	
					foreach($data['rows'] as $row): 
						$rprice = $row['discount'] > 0 ? discountPrice($row['price'], $row['discount']) : $row['price'];
						$subTotal = $_SESSION['cart'][$row['id_product']]['number'] * $rprice;
						$total += $subTotal;
						$link= BASE_NAME.'product/'.$row['alias'].'.html';
						$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']); 
						?>
						<tr id="product-item-<?=$row['id_product']?>">
							<td><?=
								showImg('../'.DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '100', '100', "", "", '', '');
								?>					  
							</td>
							<td><a href="<?=$link?>"><?=$title?></a></td>
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
							<td>
								<input type="number" name="numberPopup" data-id="<?=$row['id_product']?>" min="1" max="50" class="numberPopup form-control" placeholder="" value="<?=$_SESSION['cart'][$row['id_product']]['number']?>"/> 
							</td>
							<td class="priceFormat txtPrice clr-sdt1"><?=$subTotal?></td>
							<td><p class="pointer glyphicon glyphicon-trash clr-sdt1 item-delete delete-cart" data-id="<?=$row['id_product']?>" title="Bỏ sản phẩm #<?=$row['id_product']?>"></p></td>
						</tr>
						<?php
					endforeach;	?>
				</tbody>
			</table> 
		</div>
		
        <div class="modal-footer">
			<div class="row">
			  <div class="col-sm-6 pull-right">
				<div class="total-price-modal"> Total : <span class="item-total priceFormat txtPrice clr-sdt1"><?=$total?></span> </div>
			  </div>
			</div>
			<div class="row"> 
				<a href="/" class="btn"><span class="btn bg-sdt1"><i class="fa fa-cart-plus" aria-hidden="true"></i> <?=BTN_SHOP_CONTINUATE?></span></a>
				<a href="<?=LINK_SHOP_CART_PAYMENT?>" class="btn"><span class="btn bg-sdt1"><i class="fa fa-usd" aria-hidden="true"></i>  <?=BTN_SHOP_PAYMENT?></span></a>            
			</div>
        </div>           
		
		<?php      
	}
}
 
function deleteItemCartShop(){
	extract($_POST);
	if($id !='')
	{				
		foreach($_SESSION['cart'] as $key => $value)
			if($key == $id)
				unset($_SESSION['cart'][$key]);
	}
}
 
function updateCartShop(){
	extract($_POST);
	if($id !='' & $number !='' )
	{
		$idArray = array_keys($_SESSION['cart']);
		$rows = loadListShop('p.id_product, p.price, p.discount', ' AND p.id_product IN ('.implode(",", $idArray).')')['rows'];
		
		$subTotal = $total = 0;
		foreach($rows as $key => $row)
		{
			$rprice = $row['discount'] > 0 ? discountPrice($row['price'], $row['discount']) : $row['price'];
			
			if($row['id_product'] == $id)
			{
				$_SESSION['cart'][$row['id_product']]['number'] = $number;  
				$subTotalTxt = $_SESSION['cart'][$row['id_product']]['number'] * $rprice;
			} 
			
			$subTotal = $_SESSION['cart'][$row['id_product']]['number'] * $rprice;
			$total += $subTotal;			
		}
		
		echo $subTotalTxt.'#'.$total;
	}
}


?>
