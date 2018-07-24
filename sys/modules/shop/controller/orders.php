<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Orders extends Module {
	public $dirUp = '';
	
	function __construct() {
		global $db, $mod;
		 
		//$this->model('shop/model/orders');
	}
 	 

	function index(){			
		$rowpage = 10;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;		
		$limit = $offset.','.$rowpage;
		
		$fieldList = "o.*, os.title AS status, op.title AS ptitle";		
		
		$orderby = ' ORDER BY o.id_order DESC';
		$data 	= loadListShopOrder($fieldList, $sqlExt, $orderby, $limit);  
		$data['paging'] = Paging::load($getpage, $data['totalRecord'], $rowpage, $curpage, "index.php?p=shop&q=orders");
		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;

		$this->view('shop/view/orders', $data);
	}
 
	function remove(){

		// delete detail
		$this->query("DELETE  FROM #__shop_product_orders_detail WHERE id_order = ".(int)$_GET['id']); 
		// delete order
		$this->query("DELETE  FROM #__shop_product_orders WHERE id_order = ".(int)$_GET['id']); 
		 
		$this->redirect('index.php?p=shop&q=orders');
	}
}

?>