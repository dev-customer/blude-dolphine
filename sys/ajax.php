<?php define('DIR_APP', 'TBL');  
session_start();
include('../config.php');
include('../lib/database.php');
include('../lib/module.php');
include('../lib/func_extend.php');  
include('../lib/db.shop.php');
include('../lib/Json.Class.php');
$json = new JsonData;
$db = new Database;
$db->connect($dbhost, $dbuser, $dbpass, $dbname);
$mod = new Module;  
$fn = !empty($_GET['module'])? $_GET['module']:'';
if($fn!='')
	$fn();

function logIn(){
	global $db;
	$row = $db->loadObject('SELECT * FROM #__users WHERE username = "'.addslashes($_POST['username']) .'" AND publish = 1 AND id_group <= 4');
	
	if($row) {						
		if(md5(sha1(addslashes($_POST['password'])))==$row['password']){ 
			
			$_SESSION['isLoggedIn'] = true;
			$_SESSION['user'] = $row['username'];
			$_SESSION['admin_id'] = $row['id_user'];
			$_SESSION['id_group'] = $row['id_group'];
			$_SESSION['fullname'] = $row['fullname'];
			$_SESSION['password'] 	  = $row['password'];
			//$db->query("UPDATE #__users SET last_connection=NOW(), ip='".$_SERVER['REMOTE_ADDR']."' WHERE id_user =".$row['id_user']);
			echo 'success';
		}else
			echo 'fail';
	}
	else
			echo 'fail';
}

//important
function removeItemRecord()
{
	global $db; 
	if(isset($_POST) && !empty($_SESSION['admin_id']))
	{
		extract($_POST);  
		if($tbl != '' && $idName  != '' && $idValue != '')
		{ 			
			$row  = $db->loadObject('SELECT * FROM #__'.$tbl. ' WHERE '.$idName.' = '.(int)$idValue);
			 
			if(!empty($row))
			{ 	 
				switch($tbl){
					//USER---------------------------------
					case 'user_group': 
						//check user in table(*)
						$rowsUser  = $db->loadObjectList('SELECT * FROM #__users WHERE id_group = '.(int)$idValue);
						if(count($rowsUser)>0)
							echo 'Không thể xóa Nhóm đang chứa các User';
						else
						{
							//delete record		
								$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.' AND id_group > 1'); 
							echo 1;
						}
						break; 
					case 'users': 
						//check user in table(*)
						$rowsArt  = $db->loadObjectList('SELECT * FROM #__content WHERE user_add = '.(int)$idValue);
						if(count($rowsArt)>0)
							echo 'Không thể xóa User đang tạo ra các bài viết';
						else
						{	 
							//delete record		
								$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.' AND id_user <> '.$_SESSION['admin_id']);
							//delete image
								is_file('../'.DIR_UPLOAD.'/user/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/user/'.$row['image']) : '';
							echo 1;
						}
						break; 
						
					//CONTENT---------------------------------	
					case 'category':
						//delete All Article & Media
						$rowsArt  = $db->loadObjectList('SELECT * FROM #__content WHERE id_cat = '.(int)$idValue);
						$rowsCat  = $db->loadObjectList('SELECT * FROM #__category WHERE id_parent = '.(int)$idValue);
						if(count($rowsArt)>0 || count($rowsCat)>0)
							echo 'Không thể xóa danh mục(Vui lòng xóa Bài viết hoặc Danh mục con)';
						else{
							//delete record
								$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue);
							//delete image
								is_file('../'.DIR_UPLOAD.'/content/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/content/'.$row['image']) : '';
							//delete imageList
								$imageList = json_decode($row['imageList']);
								foreach($imageList as $value) 
									is_file('../'.DIR_UPLOAD.'/content/'.$value) ? unlink('../'.DIR_UPLOAD.'/content/'.$value) : '';						
							echo 1;
						} 
						break; 
					case 'content':
						//delete record		
							$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.' AND statusDelete = 1');
						//delete image
							is_file('../'.DIR_UPLOAD.'/content/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/content/'.$row['image']) : '';
						//delete imageList 
							$imageList = json_decode($row['imageList']);
							foreach($imageList as $value) 
								is_file('../'.DIR_UPLOAD.'/content/'.$value) ? unlink('../'.DIR_UPLOAD.'/content/'.$value) : '';						
						//delete image in content??
						echo 1;
						break; 
						
					//SHOP---------------------------------	
					case 'shop_category':
						$rowsPro  = $db->loadObjectList('SELECT * FROM #__shop_products WHERE id_cat = '.(int)$idValue);
						$rowsCat  = $db->loadObjectList('SELECT * FROM #__shop_category WHERE id_parent = '.(int)$idValue);
						if(count($rowsPro)>0)
							echo 'Không thể xóa danh mục(Vui lòng xóa Sản phẩm hoặc Danh mục con)';
						else
						{
							//delete record
								$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue);
							//delete image
								is_file('../'.DIR_UPLOAD.'/shop/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/shop/'.$row['image']) : '';
							//delete imageList
								//$imageList = json_decode($row['imageList']);
								//foreach($imageList as $value) 
									//is_file('../'.DIR_UPLOAD.'/shop/'.$value) ? unlink('../'.DIR_UPLOAD.'/shop/'.$value) : '';						
							echo 1;
						} 
						break;
					case 'shop_manuafact':
						$rowsMan  = $db->loadObjectList('SELECT * FROM #__shop_products WHERE id_manuafact = '.(int)$idValue);
						if(count($rowsMan)>0)
							echo 'Không thể xóa Nhà sản xuất đang chứa sản phẩm. Vui lòng xóa hết sản phẩm trong Nhà sản xuất này';
						else
						{
							//delete record
								$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue);
							//delete image
								is_file('../'.DIR_UPLOAD.'/shop/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/shop/'.$row['image']) : ''; 						
							echo 1;
						} 
						break; 
					case 'shop_products':
						//delete order & order detail 
							$rowsOrder  = $db->loadObjectList('SELECT * FROM #__shop_product_orders_detail WHERE id_product = '.(int)$idValue);
						if(count($rowsOrder)>0)
							echo 'Không thể xóa Sản phẩm đang chứa đơn hàng. Vui lòng xóa hết đơn hàng chứa sản phẩm này';
						else
						{
							//delete record		
								$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.'');
							//delete image
								is_file('../'.DIR_UPLOAD.'/shop/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/shop/'.$row['image']) : '';
							//delete imageList 
								$imageList = json_decode($row['imageList']);
								foreach($imageList as $value) 
									is_file('../'.DIR_UPLOAD.'/shop/'.$value) ? unlink('../'.DIR_UPLOAD.'/shop/'.$value) : '';	 
							//delete colorList
							$colorList = json_decode($row['jsColorGroup']);
							foreach($colorList as $key=>$value):
								 
								$image = 'image'; 
								is_file('../'.DIR_UPLOAD.'/shop/'.$value->$image) ? unlink('../'.DIR_UPLOAD.'/shop/'.$value->$image) : ''; 
							endforeach;
							//delete image in content product?
							
							echo 1; 
						} 
						break; 
					case 'shop_product_orders':
						//delete record detail
							$db->query('DELETE FROM #__shop_product_orders_detail WHERE id_order = '.$idValue.'');					
						//delete record
							$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.'');					
						echo 1;
						break; 
						
					//CONTACT---------------------------------	
					case 'contact_msg':
						//delete record		
							$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.'');					
						echo 1;
						break;
					case 'contact_newsletter':
						//delete record		
							$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.'');					
						echo 1;
						break;
						
					//SLIDE---------------------------------	
					case 'slide':
						//delete record		
							$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.'');					
						//delete image
							is_file('../'.DIR_UPLOAD.'/slide/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/slide/'.$row['image']) : '';
						echo 1;
						break;
						
					//LOGO---------------------------------
					case 'logo':
						//delete record		
							$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue.'');					
						//delete image
							is_file('../'.DIR_UPLOAD.'/logo/'.$row['image']) ? unlink('../'.DIR_UPLOAD.'/logo/'.$row['image']) : '';
						echo 1;
						break;
					//LOCATION---------------------------------	
					case 'location':
						//delete child
						$rowsChild  = $db->loadObjectList('SELECT * FROM #__location WHERE id_parent = '.(int)$idValue);
						if(count($rowsChild)>0)
							echo 'Không thể xóa khu vực(Vui lòng xóa hết cấp con của khu vực)';
						else{
							//delete record
								$db->query('DELETE FROM #__'.$tbl.' WHERE '.$idName.' = '.$idValue);
							echo 1;
						} 
						break; 
					default:
					
				}
				
			}else{
				echo 'Item not exists';
			}
			
		}
	}
} 

function loadContactMessageItem()
{ 
	global $db;
	if(isset($_POST))
	{
		extract($_POST);  
		$row = $db->loadObject('SELECT * FROM #__contact_msg WHERE id_msg = '.(int)$id);
		if($row): ?>
			<div class="container-fluid">
				<div class="container">
					<div class="col-md-10 panel text-left" style="margin:auto; min-height:300px; float:inherit; color:#000">
					<?= $row['content']?>
					</div>
				</div>
			</div>
		<?php
		endif;	 
	}
} 
function loadShopOrderItem()
{ 
	global $db, $json;
	if(isset($_POST))
	{
		extract($_POST);  
		$rowOrder = $db->loadObject('SELECT * FROM #__shop_product_orders WHERE id_order = '.(int)$id);
		
		$fieldList = "od.*, p.title AS product, p.price, p.discount, p.image, p.link";	 
		$rows 	= loadItemShopOrder($fieldList, (int)$id, $sqlExt, '')['rows']; 
		$total = 0;
		if($rows): ?>
			<div class="container-fluid">
				<div class="container" style="margin:3px auto">
					<div class="col-md-10 panel text-left" style="margin:auto; min-height:300px; float:inherit; color:#000">
						<h3>Order ID#: <?=$id?></h3>
						
						<div class="panel panel-info"> 
							<div class="panel-body bg-danger">
								<ul>
									<li class="list-group-item"> Họ tên: <?=$rowOrder['fullname']?> </li>
									<li class="list-group-item"> Phone: <?=$rowOrder['phone']?> </li>
									<li class="list-group-item"> Address: <?=$rowOrder['address']?> </li> 
								</ul>
							</div>
						</div>
						<table class="table table-bordered table-hover" cellspacing="0" cellpadding="0"> 
							<thead class="bg-sdt1">
								<tr>
									<th width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
									<th>ID</th>
									<th>Product</th>        
									<th>Image</th>        
									<th>Color</th>        
									<th>Sizes</th>        
									<th>Price</th>        
									<th>Quality</th>        
									<th>Total</th>
									<th>Link</th>
								</tr>
							</thead>
							<?php  			 
							foreach($rows as $row): 
								$rprice = $row['discount'] > 0 ? discountPrice($row['price'], $row['discount']) : $row['price'];
								$subTotal = $row['qty'] * $rprice;
								$total = $total + $subTotal;
								$title = $json->getDataJson1D($row['product'], $_SESSION['dirlang']);
								?>
								<tr>
									<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_detail']; ?>"></td>
									<td><?= $row['id_detail']; ?></td>
									<td><?=$title?></td> 
									<td>
									<?=
									showImg('../'.DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', 50, 50, "", "", '', '');
									?>												
									</td> 
									<td><div class="img-circle" style="background: <?=$row['color']?>; width:20px; height:20px"></div></td> 
									<td><span class="badge"><?=$row['size']?></span></td> 
									<td><span class="priceFormat"><?=$rprice?></span></td> 
									<td><?=$row['qty']?></td> 
									<td><span class="priceFormat"><?=$subTotal?></span></td>
									<td><a style="font-size:12px; color:#000;" href="<?=@$row['link']?>" target="_blank">Link SP</a></td>
								</tr>
								<?php  
							endforeach;
							?>
							<tfoot class="bg-danger text-right">
								<td colspan="10">Total: <span class="priceFormat"><?=$total?></span></td> 
							</tfoot>
						</table> 
					</div>
				</div>
			</div>
			<script src="<?=TEMPLATE?>js/jquery.price_format.2.0.min.js"></script>  
			<script language="javascript" type="text/javascript">
				$(document).ready(function () { 
					$('.priceFormat').priceFormat({
						clearPrefix: true,
						suffix: ' VNĐ',
						centsLimit: 0,
						centsSeparator: ',',
						thousandsSeparator: '.'
					});  
				});
			</script>
		<?php
		endif;	 
	}
} 

function actDelImgItem()
{
	if(isset($_POST))
	{
		extract($_POST);  
		is_file('../'.DIR_UPLOAD.'/'.$src) ? unlink('../'.DIR_UPLOAD.'/'.$src) : '';	 	 
	}
} 

function resetAll(){
	if($_POST){  
		$arr = explode('-', $_POST['item']); 
		foreach($arr as $key=>$value) 
			unset($_SESSION[$value]);
	}
}

//function common ajax for change status item
function changeStatusItem()
{
	
	global $db;	
	$attr = $_POST['attr'] != '' ? $_POST['attr'] : 'publish';
	if(isset($_SESSION['admin_id']) && $_POST['tbl'] && $_POST['idname'] && $_POST['id'])
	{	
		$db->query("UPDATE #__".$_POST['tbl']." SET ".$attr." = if(".$attr."='1','0','1') WHERE ".$_POST['idname']." = ".$_POST['id']);	
	}
}
//function common ajax for edit Title quick
function changeTextTableItem()
{
		
}

function approveOrder()
{
	
	global $db;	
	
	if(isset($_SESSION['admin_id']) && $_POST['id'])
	{	
		$db->query("UPDATE #__shop_product_orders SET id_status = 1 WHERE id_order = ".$_POST['id']);	
	}
}



//tools
function createAlias()
{	
	if(isset($_POST))
	{
		global $db, $mod, $json;
		switch($_POST['tbl'])
		{
			case 'content':
				//for category
				$rows = $db->loadObjectList('SELECT * FROM #__category WHERE aliasFix = 0');   
				foreach($rows as $row):				
					$title = $json->getDataJson1D($row['title'], 'vn');
					$alias = $mod->Rewrite(strtolower($title));
					// check exists
					$rs = $db->loadObject("SELECT * FROM #__category WHERE alias ='".$alias."'");
					$alias = !empty($rs)? $alias.'-'.$row['id_cat'] : $alias; 
					$db->query('UPDATE #__category SET alias = "'.$alias.'" WHERE id_cat = '.$row['id_cat']);
				endforeach; 	
				
				$rows = $db->loadObjectList('SELECT * FROM #__content WHERE aliasFix = 0');   
				foreach($rows as $row):				
					$title = $json->getDataJson1D($row['title'], 'vn');
					$alias = $mod->Rewrite(strtolower($title));
					// check exists
					$rs = $db->loadObject("SELECT * FROM #__content WHERE alias ='".$alias."'");
					$alias = !empty($rs)? $alias.'-'.$row['id_art'] : $alias;
					
					$db->query('UPDATE #__content SET alias = "'.$alias.'" WHERE id_art = '.$row['id_art']);
				endforeach; 
				break;
			case 'product':
				//for category
				$rows = $db->loadObjectList('SELECT * FROM #__shop_category');   
				foreach($rows as $row):				
					$title = $json->getDataJson1D($row['title'], 'vn');
					$alias = $mod->Rewrite(strtolower($title));
					// check exists
					$rs = $db->loadObject("SELECT * FROM #__shop_category WHERE alias ='".$alias."'");
					$alias = !empty($rs)? $alias.'-'.$row['id_cat'] : $alias; 
					$db->query('UPDATE #__shop_category SET alias = "'.$alias.'" WHERE id_cat = '.$row['id_cat']);
				endforeach; 				
				//for product
				$rows = $db->loadObjectList('SELECT * FROM #__shop_products');   
				foreach($rows as $row):				
					$title = $json->getDataJson1D($row['title'], 'vn');
					$alias = $mod->Rewrite(strtolower($title));
					// check exists
					$rs = $db->loadObject("SELECT * FROM #__shop_products WHERE alias ='".$alias."'");
					$alias = !empty($rs)? $alias.'-'.$row['id_product'] : $alias;

					$db->query('UPDATE #__shop_products SET alias = "'.$alias.'" WHERE id_product = '.$row['id_product']);
				endforeach; 
				break;
			
				break;
			default:
		}
	}
} 
//backup database
function backupDB(){	 
	if(isset($_SESSION['admin_id']))
	{		 
		include('tool.db.php');			
	}
}
//reset data
function resetData(){	 
	if(isset($_SESSION['admin_id']))
	{		 
		global $db;
		//backup data before reset
		include('tool.db.php');
		
		//update image shop
		$db->query('UPDATE #__shop_products SET image = "demo.jpg"');
		//update image news
		$db->query('UPDATE #__content SET image = "demo.jpg"');
		//update image slide
		$db->query('UPDATE #__slide SET image = "demo.jpg"');
		//update image logo
		$db->query('UPDATE #__logo SET image = "demo.jpg"');  
		
	}
}

?>
