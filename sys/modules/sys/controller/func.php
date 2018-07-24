<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Func extends Module 
{

	function __construct() {
		global $db, $mod; 
		if(!$mod->checkPermision(1)) {
			$_SESSION['message'] = ERROR_ADD_NO_PERMISION;		
			$this->redirect('index.php');
		}		
	}

	function index(){
		$sql = "SELECT * 
				FROM #__permission 
				WHERE id_group >= ".$_SESSION['id_group']."  
				ORDER BY module ASC, controller ASC ";
		$data['rows'] = $this->loadObjectList($sql); 
		$this->view($_GET['p'].'/view/func', $data);
	}

	function tools(){
		
		$this->view($_GET['p'].'/view/tools');
	}
	
}

?>