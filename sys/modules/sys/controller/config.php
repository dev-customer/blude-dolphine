<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Config extends Module 
{

	function __construct() {
		global $db, $mod;

		if(!$mod->checkPermision(1)) {
			$_SESSION['message'] = ERROR_ADD_NO_PERMISION;		
			$this->redirect('index.php');
		}	

		$this->model($_GET['p'].'/model/config');
	}

	function index(){
		$data['row'] = $this->loadObject("SELECT * FROM #__config");
		$data['groups'] = $this->loadObjectList("SELECT id_group, name FROM #__user_group WHERE id_group >= ".$_SESSION['id_group']);
		$this->view($_GET['p'].'/view/configform', $data);
	}
	
	function save(){
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$model = new ModelConfig();
			
			if($model->update()) {
				$_SESSION['message'] = LANG_UPDATE_SUCCESS;
				$this->redirect('index.php?p=sys&q=config');
			}
			else{
				$_SESSION['message'] = LANG_UPDATE_FAILED;
				$this->redirect('index.php?p=sys&q=config');
			}
		}	
		
		$this->redirect('index.php?p=sys&q=config');
	}
}

?>