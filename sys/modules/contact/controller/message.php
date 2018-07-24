<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Message extends Module {

	function __construct() {
		global $db, $mod;
	}
 
	function index(){
		$rowpage = PAGE_ROWS;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;
		$sql = "SELECT * FROM #__contact_msg ORDER BY id_msg DESC ";

		$num = $this->num($sql);
		$query = $num > 0 ? $sql ." LIMIT $offset, $rowpage" : $sql;
		$data['rows'] = $this->loadObjectList($query);

		// Load Paging
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=".$_GET['p'].'&q='.$_GET['q']);
		
		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
		$this->view($_GET['p'].'/view/message', $data);
	}
	
	function viewDetail() {
		$data['row'] = $this->loadObject('SELECT * FROM #__contact_msg WHERE id_msg = '.(int)$_GET['id']);					
		$this->view('contact/view/messagedetail', $data);
	}
	
	//publish
	function publish(){
		$this->query("UPDATE #__contact_msg SET status=if(status='1','0','1') WHERE id_msg =".(int)$_GET['id']);	
		$this->redirect('index.php?p=contact&q=message');	
	}
	
	function delete(){
		$array_id = array();
		while (list ($key,$val) = @each($_POST['id'])) {
			$array_id[] = $val;
		} 

		$sql = "DELETE FROM #__contact_msg WHERE id_msg IN (".implode(',',$array_id).")"; 
		$res = $this->query($sql);
		$this->redirect('index.php?p=contact&q=message');	
	}
	
	//publish
	function remove(){
		$this->query("DELETE FROM #__contact_msg WHERE id_msg=".(int)$_GET['id']);	
		$this->redirect('index.php?p=contact&q=message');	
	}
}

?>