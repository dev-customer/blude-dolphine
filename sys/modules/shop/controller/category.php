<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Category extends Module 
{
	public $dirUp = '';

	function __construct() {
		global $db, $mod;	
		$this->dirUp = '../'.DIR_UPLOAD.'/shop/';
		$this->model($_GET['p'].'/model/category');
		
	}

	function index(){			
		$data['rows'] = $this->getCategory();
		$this->view($_GET['p'].'/view/category', $data);
	}

	function getCategory($catid=0, $split="_", $list_style="|_")
	{
		global $json;
		$ret=array();
		$result = $this->query("SELECT c.* FROM #__shop_category c WHERE id_parent=$catid ORDER BY orderring");

		while (($row = mysql_fetch_assoc($result)))
		{
		 $ret[]=array($row['id_cat'], ($catid==0?"" : $split). $json->getDataJson1D($row['title'], $_SESSION['dirlang']) , $row['publish'], $row['orderring'], $row['groupname'], $row['image'], $row['alias'], $row['setHome']);
		 $getsub=$this->getCategory($row['id_cat'], $split.$split, $list_style);
		 foreach ($getsub as $sub)
			$ret[]=array($sub[0], $sub[1] , $sub[2], $sub[3], $sub[4], $sub[5], $sub[6], $sub[7]);
		}
		return $ret;
	}		

	function add(){		
		$data['category'] = $this->getCategory();
		$this->view($_GET['p'].'/view/catform', $data);
	}
	function edit(){		
		$data['row'] = $this->loadObject('SELECT * FROM #__shop_category WHERE id_cat = '.(int)$_GET['id']);
		$data['category'] = $this->getCategory();
		$this->view($_GET['p'].'/view/catform', $data);
	}
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if( empty($title_vn)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=shop&q=category&m='.$_POST['method'].'&id='.$_POST['id_cat']); 
			}
			else {
					$img_type = $_FILES['image']['type'];
					$img_name = time().'_'.substr(Module::Rewrite($_FILES['image']['name']), -80);
					$image_name = '';
					// upload image
					if(Admin::checkType($img_type)){
						$image_name = Admin::upload('image', $img_name , $this->dirUp);
						is_file($this->dirUp.$old_img) ? unlink($this->dirUp.$old_img) : '';
					}  
					
					$model = new ModelCategory();

					// update info data
					if($method == 'edit')
					{
						if($model->update($image_name) ) { 
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
						}
						else {
							$_SESSION['message'] = LANG_UPDATE_FAILED;
							$this->redirect('index.php?p=shop&q=category&m='.$_POST['method'].'&id='.$_POST['id_cat']); 
						}
					}else{
						if($model->insert($image_name)) { 
							$_SESSION['message'] = LANG_INSERT_SUCCESS;
						}
						else {
							$_SESSION['message'] = LANG_INSERT_FAILED;
						}
					}
			}
		}	
		
		$this->redirect('index.php?p=shop&q=category'); 
	}
	
	function orderring(){
		extract($_POST);
		$listid = explode('-', $listid);
		array_shift($listid); 
		foreach($listid as $key =>$val):
			$this->query( "UPDATE #__shop_category SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_cat=".$val);
		endforeach;
		
		$this->redirect('index.php?p=shop&q=category'); 
	}

	function delete(){
		$flag = 0;	
		while (list ($key,$val) = @each($_POST['id'])) {
			$check_cat = $this->checkExistsCategory($val);
			$check_pro = $this->checkExistsProducts($val);
			if($check_cat==true || $check_pro==true){
				$flag = 1;
			}else
			{ 
				 
				$row = $this->loadObject("SELECT * FROM #__shop_category WHERE id_cat = ".(int)$val);
				if($row)
				{
					// delete image
					is_file($this->dirUp.$row['image']) ? unlink($this->dirUp.$row['image']) :''; 
					$this->query("DELETE FROM #__shop_category WHERE id_cat = ".$val);  
				} 
			}
		} 
		$_SESSION['message'] = $flag == 0 ? LANG_DELETE_SUCCESS : ERROR_DEL_PARENTS;
		$this->redirect('index.php?p=shop&q=category'); 
	}
	
	/*
	function publish(){
		$this->query("Update #__shop_category Set publish=if(publish='1','0','1') Where id_cat=".(int)$_GET['id']);	
		$this->redirect('index.php?p=shop&q=category'); 
	}
	function remove(){ 
		$check_cat = $this->checkExistsCategory($_GET['id']);
		$check_pro = $this->checkExistsProducts($_GET['id']);
		if($check_cat==true || $check_pro==true)
				$_SESSION['message'] = ERROR_DEL_PARENT;
		else
		{ 
			$row = $this->loadObject("SELECT * FROM #__shop_category WHERE id_cat = ".(int)$val);
			if($row)
			{
				// delete image
				is_file($this->dirUp.$row['image']) ? unlink($this->dirUp.$row['image']) :''; 
				$this->query("DELETE FROM #__shop_category WHERE id_cat=".$_GET['id']);	 
			} 
		}
		$this->redirect('index.php?p=shop&q=category'); 
	}
	*/
	
	function checkExistsCategory($id_cat)
	{	
		$num = $this->num("SELECT * FROM #__shop_category WHERE id_parent = ".(int)$id_cat); 
		return $num>0? true : false;
	}	
	function checkExistsProducts($id_cat)
	{	
		$num = $this->num("SELECT * FROM #__shop_products WHERE id_cat = ".(int)$id_cat); 
		return $num>0? true : false;
	}	
	
}

?>