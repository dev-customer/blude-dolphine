<?php if(!defined('DIR_APP')) die('Your have not permission'); 

function loadItemShop($fieldList = '', $sql_ext = '') {
	global $db;
	$fieldList = $fieldList == '' ? "p.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__shop_products p
				JOIN #__shop_manuafact m ON(p.id_manuafact = m.id_manuafact)
				JOIN #__shop_category c ON(p.id_cat = c.id_cat)  
				LEFT JOIN #__shop_category cc2 ON(cc2.id_parent = c.id_cat) 
				LEFT JOIN #__shop_category cc3 ON(cc3.id_parent = cc2.id_cat)
			WHERE c.publish = 1 ";
	$sql .= " $sql_ext";	
	$info['row'] = $db->loadObject($sql); 		
	return !empty($info)? $info : false;
}
	
function loadListShop($fieldList='', $sql_ext='', $orderby='', $limit = '') {
	global $db, $mod;
	$fieldList = $fieldList == '' ? "p.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__shop_products p
				JOIN #__shop_manuafact m ON(p.id_manuafact = m.id_manuafact)   
				JOIN #__shop_category c ON(p.id_cat = c.id_cat)  
				LEFT JOIN #__shop_category cc2 ON(cc2.id_parent = c.id_cat) 
				LEFT JOIN #__shop_category cc3 ON(cc3.id_parent = cc2.id_cat)"; 
	$sql .= " WHERE c.publish = 1 AND p.id_product > 0 ";	//safe query if not WHERE
	$sql .= " $sql_ext";	
	$sql .= ($orderby=='')? ' ORDER BY p.orderring ASC ' : $orderby;  
	$info['totalRecord'] = $db->num($sql);		
	$sql .= $limit != '' ? " LIMIT $limit" : '';
	//echo '<noscript>'.$sql.'</noscript>';
	$info['rows'] = $db->loadObjectList($sql);  

	return !empty($info['rows'])? $info : false;
}

function getProductsCategory($id_cat){
	$rowpage = 10;
	$curpage = CUR_ROWS;
	$getpage = empty($_GET['page']) ? 1 : $_GET['page']; 
	$offset = ($getpage - 1) * $rowpage;	
	$limit = $offset.','.$rowpage;
	$fieldList = " p.*, c.title AS category";
	
	$cListID = getCategoryInfo($id_cat, '', '');
	$cList 	 = categoryToArray($cListID);
	$cList[] = $id_cat;
	$sqlExt .= " AND p.id_cat IN (".implode(',', $cList).")";
	$data = loadListShop($fieldList, $sqlExt, '', $limit); 
	return $data['rows'];
}

function getCategoryShop($catid=0, $split="", $list_style="")
{
	global $json, $db;
	$ret=array();	 		
	$sql = "SELECT * FROM #__shop_category  WHERE id_parent = $catid ORDER BY orderring";		
	 
	$result = $db->query($sql);
	while (($row = mysql_fetch_assoc($result)))
	{
		 $ret[]=array(
				$row['id_cat'], 
				($catid==0?"" : $split). $list_style.$json->getDataJson1D($row['title'], $_SESSION['dirlang']), 
				$row['orderring'] , 
				$row['publish'] , 
				$row['alias'], 
				$row['id_parent'], 
				$row['image'], 
				$row['setHome'] 
		);
				
		$getsub = getCategoryShop($row['id_cat'], $split.$split, $list_style);
		 
		foreach($getsub as $sub){
			$ret[]= array(
				$sub[0], 
				$sub[1], 
				$sub[2], 
				$sub[3], 
				$sub[4], 
				$sub[5], 
				$sub[6], 
				$sub[7], 
				$sub[8]
			);			
		}
	}
	return $ret;
}		


function loadItemShopOrder($fieldList = '', $id = '' ,$sql_ext = '', $orderby='', $limit=50) {
	global $db;
	$fieldList = $fieldList == '' ? "o.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__shop_product_orders_detail od
				JOIN #__shop_product_orders o ON(od.id_order = o.id_order)  
				JOIN #__shop_products p ON(od.id_product = p.id_product) 
			WHERE od.id_order > 0 AND od.id_order = ".(int)$id;
	$sql .= " $sql_ext";	
	$sql .= ($orderby=='')? ' ORDER BY od.id_detail ASC ' : $orderby;  
	$info['totalRecord'] = $db->num($sql);		
	$sql .= " LIMIT $limit";
	$info['rows'] = $db->loadObjectList($sql); 	 
	return !empty($info)? $info : false;
}
	
function loadListShopOrder($fieldList='', $sql_ext='', $orderby='', $limit = 100) {
	global $db, $mod;
	$fieldList = $fieldList == '' ? "o.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__shop_product_orders o
			JOIN #__shop_product_payment op ON(op.id_payment = o.id_payment) 
			JOIN #__shop_product_orders_status os ON(os.id_status = o.id_status)"; 
	$sql .= " WHERE  o.id_order > 0 ";	//safe query if not WHERE
	$sql .= " $sql_ext";	
	$sql .= ($orderby=='')? ' ORDER BY o.id_order ASC ' : $orderby;  
	$info['totalRecord'] = $db->num($sql);		
	$sql .= " LIMIT $limit";
	$info['rows'] = $db->loadObjectList($sql); 	
	return !empty($info['rows'])? $info : false;
}
 
function loadItemManuafact($fieldList = '', $id='', $sql_ext = '') {
	global $db;
	$fieldList = $fieldList == '' ? "m.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__shop_manuafact m 
			WHERE m.id_manuafact = ".(int)$id;
	$sql .= " $sql_ext";	
	$info['row'] = $db->loadObject($sql); 		
	return !empty($info)? $info : false;
}
	
function loadListManuafact($fieldList='', $sql_ext='', $orderby='', $limit = 100) {
	global $db, $mod;
	$fieldList = $fieldList == '' ? "m.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__shop_manuafact m"; 
	$sql .= " WHERE m.id_manuafact > 0 ";	//safe query if not WHERE
	$sql .= " $sql_ext";	
	$sql .= ($orderby=='')? ' ORDER BY m.orderring ASC ' : $orderby;  
	$info['totalRecord'] = $db->num($sql);		
	$sql .= " LIMIT $limit";
	$info['rows'] = $db->loadObjectList($sql); 	
	return !empty($info['rows'])? $info : false;
} 

function discountPrice($price=0, $percent=0){
	return $price - $price/100*$percent;
}

function showHtmlItemProduct($row = array(), $md = 3, $param = '') {
	if(!empty($row)){
		global $json,$mod;
		$link  = LINK_SHOP_ITEM.$row['alias'].'.html';
		$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);  
		?>
		<div class="col-md-<?=$md?>"> 
			<div class="">
				<div class="thumbnail">
					<a href="<?=$link?>">
					<?=
					showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:'.$mod->config['imageShop'].'px"');
					?>
					</a>   
				</div> 	
				<div class="caption text-center">
					<h5><a class="text-uppercase" href="<?=$link?>"><?=$title?></a></h5>
					<p>
						<span class="<?=$row['price'] >0 ? 'priceFormat':''?>"><?=$row['price'] >0 ? $row['price'] : MENU_CONTACT?></span>											
					</p> 
					<p class="">
						<a class="btn bg-sdt1 btn-addcart " data-id="<?=$row['id_product']?>" href="#"><?=LB_ORDER?> <i class="fa fa-cart-plus" aria-hidden="true"></i></a>									
					</p>
				</div>
			</div>									
		</div>	 
	<?php	
	}
}  
 
?>