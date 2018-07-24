<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class ModelProducts {
	function insertOrder(){
		global $db;
		extract($_POST);
		$sql = 'INSERT INTO #__shop_product_orders SET 
					id_status = 2, 
					id_payment = "'.(int)$id_payment.'", 
					fullname = "'.$fullname.'", 
					phone = "'.$phone.'", 
					email = "'.$email.'", 
					address = "'.$address.'", 
					date = NOW(),
					jsProduct = "'.base64_decode($jsProduct).'", 
					description = "'.$description.'"';
		$res = $this->query($sql);
		$lastid = $db->id();

		//update detail
		foreach($_SESSION['cart'] as $key => $value){
			$sql = "INSERT INTO #__shop_product_orders_detail SET 
						id_product = ".$key.", 
						color = '".$_SESSION['cart'][$key]['color']."', 
						size = '".$_SESSION['cart'][$key]['size']."', 
						qty = ".$_SESSION['cart'][$key]['number'].", 
						id_order = ".$lastid;
			$this->query($sql);
			//update count
			$this->query("UPDATE #__shop_products SET numBuy = numBuy + 1 WHERE id_product = ".$key);
			
		}
		
		return true;
	}		
	
}

?>