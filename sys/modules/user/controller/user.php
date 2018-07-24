<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class User extends Module 
{
	public $dirUp = '';

	function __construct() {
		$this->dirUp = '../'.DIR_UPLOAD.'/user/';
		$this->model('user/model/user');
	}
	function index(){
				
		$rowpage = PAGE_ROWS;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage; 

		$sql = "SELECT u.*, g.name AS groups, CONCAT(firstname,' ', lastname) AS fullname, COUNT(c.user_add) AS numArticle
				FROM #__users u
					JOIN #__user_group g ON(g.id_group = u.id_group)
					LEFT JOIN #__content c ON(c.user_add = u.id_user)
				WHERE g.id_group = u.id_group AND u.id_group >= ".(int)$_SESSION['id_group'].'
				GROUP BY c.user_add, u.id_user
				ORDER BY u.id_user DESC ';
				
		$num = $this->num($sql);
		$query = $num > 0 ? $sql ." LIMIT $offset, $rowpage" : $sql;
		$data['rows'] = $this->loadObjectList($query); 
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=user&q=user");
		$this->view('user/view/user', $data);
	}		
	
	function add() {	
		$data['group'] = $this->rows('SELECT * FROM #__user_group WHERE  publish = 1 AND id_group >='.$_SESSION['id_group']); // var_dump($data['group']);
		$this->view('user/view/add', $data);
	}
	
	function edit() {
		
		extract($_POST);
		if($_GET['id']=='') $_GET['id'] = $_SESSION['admin_id'];
		$data['group'] = $this->loadObjectList("SELECT id_group, name FROM #__user_group WHERE id_group >=".(int)$_SESSION['id_group']." ORDER BY id_group");
		$data['row'] = $this->loadObject('SELECT * FROM #__users where id_user = "'.(int)$_GET['id'].'"');
		$this->view('user/view/add', $data);
	}
	
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			if( empty($username)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=user&q=user&m='.$_GET['m'].'&id='.$_GET['id']);
			}
			else if( !empty($email) && Validate::email($email) ) {
				$_SESSION['message'] = LANG_ERROR_EMAIL;
				$this->redirect('index.php?p=user&q=user&m='.$_GET['m'].'&id='.$_GET['id']);
			}
			else
			{			
				$model = new ModelUser();

				if($method=='edit'){
					if($model->update() )  
						$_SESSION['message'] = LANG_UPDATE_SUCCESS;
					else 
						$this->redirect('index.php?p=user&q=user&m=edit&id='.$_POST['id_user']);
				}
				else{
					if($model->insert()) 
						$_SESSION['message'] = LANG_INSERT_SUCCESS;
					else
						$this->redirect('index.php?p=user&q=user&m=add');
				}
			}
		}	
		
		$this->redirect('index.php?p='.$_GET['p'].'&q='.$_GET['q']);
	}
	 
	function login() {
		if($_SERVER['REQUEST_METHOD']=='POST') 
		{
			$row = $this->row('SELECT * FROM #__users WHERE username = "'.addslashes($_POST['username']) .'" AND publish = 1');
			
			if($row) {						
				if(md5(sha1(addslashes($_POST['password'])))==$row['password']){
					$_SESSION['isLoggedIn'] = true;
					$_SESSION['user'] = $row['username'];
					$_SESSION['fullname'] = $row['fullname'];
					$_SESSION['admin_id'] = $row['id_user'];
					$_SESSION['id_group'] = $row['id_group'];
					$this->query("UPDATE #__users SET last_connection=NOW(), ip='".$_SERVER['REMOTE_ADDR']."' WHERE id_user = ".$row['id_user']);
					$this->redirect('index.php');
				}else{
					$this->aRedirect(LANG_USER_INCORRECT,Module::url('index.php?p='.$_GET['p']));
				}
			}
			else{
				$this->aRedirect(LANG_USER_INCORRECT, Module::url('index.php?p='.$_GET['p']));
			}
		}
	
		$this->view('user/view/login');
	}
	 
	function logout() {		
		unset($_SESSION['isLoggedIn']);
		unset($_SESSION['user']);
		unset($_SESSION['id_group']);
		unset($_SESSION['fullname']);
		unset($_SESSION['admin_id']);
		unset($_SESSION['admin_view']);
		unset($_SESSION['admin_add']);
		unset($_SESSION['admin_edit']);
		unset($_SESSION['admin_delete']);
		session_destroy();
		$this->redirect('index.php');
	}
	/*
	function publish(){
		$this->query("Update #__users Set publish=if(publish='1','0','1') Where id_user=".$_GET['id']."");	
		$this->redirect('index.php?p=user&q=user');	
	}
	
	function delete(){
		$array_id = array();
		while (list ($key,$val) = @each($_POST['id'])) {
			//SECURITY: check exists data bind
			$flag = $this->checkExistsBinding($_GET['id'], array('content', 'shop_products'));
			if($flag==1)
				$_SESSION['message'] = 'Một trong những user không thể xóa do có ràng buộc dữ liệu';
			else			
				$this->query("DELETE FROM #__users WHERE id_user IN (".implode(',',$array_id).") AND id_group >= ".$_SESSION['id_group']);
		} 

		$this->redirect('index.php?p=user&q=user');	
	}
	
	function remove(){
		//SECURITY: check exists data bind
		$flag = $this->checkExistsBinding($_GET['id'], array('content', 'shop_products'));
		if($flag==1)
			$_SESSION['message'] = 'Không thể xóa user này do có ràng buộc dữ liệu';
		else
			$this->query("DELETE FROM #__users WHERE id_group >= ".$_SESSION['id_group']." AND id_user=".(int)$_GET['id']);		
		$this->redirect('index.php?p=user&q=user');	
	}
	*/
	function checkExistsBinding($id_user, $tblList = array('content'))
	{	
		foreach($tblList as $tbl): 
			$numTbl = $this->num("SHOW TABLES LIKE '#__".$tbl."'"); 
			if($numTbl){ 
				$num = $this->num("SELECT * FROM #__".$tbl." WHERE user_add = ".(int)$id_user);   
				return $num > 0 ? true : false;
			}
		endforeach;
	}	
	
}

?>