<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Tools extends Module 
{

	function __construct() {
		global $db, $mod; 
		if(!$mod->checkPermision(1)) {
			$_SESSION['message'] = ERROR_ADD_NO_PERMISION;		
			$this->redirect('index.php');
		}		
	}

	function index(){ 
		$this->view($_GET['p'].'/view/tools');
	} 
	
}

?>