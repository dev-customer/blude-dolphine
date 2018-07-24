<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Group extends Module 
{
	function __construct() { 
	
		$this->model('user/model/group');
	}

	function index(){  
		$rowpage = PAGE_ROWS;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;
		$sql = "SELECT ug.* FROM #__user_group ug WHERE id_group >= ".$_SESSION['id_group'];
		$num = $this->num($sql);
		$query = $num > 0 ? $sql ." LIMIT $offset, $rowpage" : $sql;
		$data['rows'] = $this->loadObjectList($query);
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=group&q=group");
		$this->view('user/view/group', $data);
	} 
	
	function add() {
		$this->view('user/view/gform');
	}
	
	function edit() {
		extract($_POST);
		if($_GET['id']=='') 
			$_GET['id'] = $_SESSION['admin_id'];		
		$data['row'] = $this->loadObject('SELECT * FROM #__user_group WHERE id_group = '.$_GET['id'].' AND id_group >= '.$_SESSION['id_group']);
		$this->view('user/view/gform', $data);
	}
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			if(empty($name_vn))
			{
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=user&q=user&m='.$_GET['m'].'&id='.$_GET['id']);
			}
			else{		
			
					$model = new ModelGroup();
					
					if($method=='edit'){ 
						if($model->update($id_group)) 
							$_SESSION['message'] = LANG_UPDATE_SUCCESS; 
						else{
							$_SESSION['message'] = LANG_UPDATE_FAILED;
							$this->redirect('index.php?p=user&q=group&m=edit&id='.$_POST['id_group']);
						}
					}
					else{
						if($model->insert()) 
							$_SESSION['message'] = LANG_INSERT_SUCCESS;
						else{
							$_SESSION['message'] = LANG_INSERT_FAILED;
							$this->redirect('index.php?p=user&q=group&m=add');
						}							
					}
				}
		}	
		
		$this->redirect('index.php?p=user&q=group');	
	}	
	//publish
	/*
	function publish(){
		$this->query("Update #__user_group Set publish=if(publish='1','0','1') WHERE id_group =".$_GET['id'].' AND id_group >= '.$_SESSION['id_group']);	
		$this->redirect('index.php?p=user&q=group');	
	}

	function delete(){
		while (list ($key,$val) = @each($_POST['id'])) {
			$check_user = $this->checkExistsUser($val);
			if($check_user==true)
				$_SESSION['message'] = ERROR_DEL_PARENTS;
			else
				$this->query("DELETE FROM #__user_group WHERE id_group = ".$val.' AND id_group >= '.$_SESSION['id_group']);
		} 
		$this->redirect('index.php?p=user&q=group');	
	}
	
	function remove(){
		$check_user = $this->checkExistsUser($_GET['id']);
		if($check_user==true)
			$_SESSION['message'] = ERROR_DEL_PARENT;
		else
			$this->query("DELETE FROM #__user_group WHERE id_group = ".$_GET['id'].' AND id_group >= '.$_SESSION['id_group']);	
		$this->redirect('index.php?p=user&q=group');	
	}
	*/
	
	function checkExistsUser($id_group)
	{	
		$num = $this->num("SELECT * FROM #__users WHERE id_group = ".(int)$id_group); 
		return $num>0? true : false;
	}	

}

?>