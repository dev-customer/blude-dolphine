<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Newsletter extends Module {

	function __construct() {
		global $db, $mod;
	}
 
	function index(){
		$rowpage = 300;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;
		$sql = "SELECT * FROM #__contact_newsletter ORDER BY id_news DESC ";

		$num = $this->num($sql);
		$query = $num > 0 ? $sql ." LIMIT $offset, $rowpage" : $sql;
		$data['rows'] = $this->loadObjectList($query);

		// Load Paging
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=".$_GET['p'].'&q='.$_GET['q']);
		
		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
		$this->view($_GET['p'].'/view/newsletter', $data);
	}
	
	function delete(){
		$array_id = array();
		while (list ($key,$val) = @each($_POST['id'])) {
			$array_id[] = $val;
		} 

		$sql = "DELETE FROM #__contact_newsletter WHERE id_news IN (".implode(',',$array_id).")"; 
		$res = $this->query($sql);
		$this->redirect('index.php?p=contact&q=newsletter');	
	}
		
	function remove(){
		$this->query("DELETE FROM #__contact_newsletter WHERE id_news=".(int)$_GET['id']);	
		$this->redirect('index.php?p=contact&q=newsletter');	
	}
}

?>