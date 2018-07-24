<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Category extends Module 
{
	public $dirUp = '';

	function __construct() {
		global $db, $mod;
		$this->dirUp = '../'.DIR_UPLOAD.'/content/';
		$this->model($_GET['p'].'/model/category');
	}

	function index()
	{
		$filter_cat  = '<div class="input-group"><div class="input-group-addon bg-sdt1"><span class="glyphicon glyphicon-save"></span> :</div>';
		$filter_cat .= '<select name="category" id="category"  onchange="document.frm_list.submit();" class="form-control">';
		$filter_cat .= '<option value="-1">-'.ucfirst(MENU_CATALOG).'-</option>';
		$cates = getCategoryInfo();
		foreach($cates as $cat){
			if(isset($_POST['category']) && $cat[0]==$_POST['category'])
				$filter_cat .= '<option value="'.$cat[0].'" selected="selected">'.$cat[1].'</option>';
			else
				$filter_cat .= '<option value="'.$cat[0].'">'.$cat[1].'</option>';
		}
		$filter_cat .= '</select></div>';
	
		$data['filter_cat'] = $filter_cat;
		if(isset($_POST['category']) && $_POST['category']!='-1') 			
			$data['rows'] = getCategoryInfo($_POST['category']);   
		else
			$data['rows'] = getCategoryInfo(); 
		$this->view($_GET['p'].'/view/category', $data);
	} 
	 
	function add() {
		global $mod;
		if(!$mod->checkPermision(2)) {
			$_SESSION['message'] = ERROR_ADD_NO_PERMISION;		
			$this->redirect('index.php?p=content&q=category');
		}		

		$data['category'] = getCategoryInfo();		
		$this->view($_GET['p'].'/view/catform', $data);
	}
	
	function edit() {
		 
		$data['row'] = $this->loadObject('SELECT cat.* FROM #__category cat  WHERE id_cat = '.(int)$_GET['id']);
		$data['category'] = getCategoryInfo();				
		$this->view($_GET['p'].'/view/catform', $data);
	}
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if( empty($title_vn)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p='.$_GET['p'].'&q='.$_GET['q'].'&m='.$_GET['m']);
			}
			else{
					$img_type = $_FILES['image']['type'];
					$img_name = 'cate-'.time().'_'.substr(Module::Rewrite($_FILES['image']['name']), -80);
					$image_name = '';
					//upload image
					if(Admin::checkType($img_type)){
						$image_name = Admin::upload('image', $img_name , $this->dirUp);
						is_file($this->dirUp.$old_img) ? unlink($this->dirUp.$old_img) : '';
					} 
					
					$model = new ModelCategory();
					
					if($_POST['method']=='edit')
					{
						if($model->update($image_name) ) 
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
						else
						{
							$_SESSION['message'] = LANG_UPDATE_FAILED;
							$this->redirect('index.php?p=content&q=category&m=edit&id='.$_POST['id_cat']);
						}
					}else
					{
						if($model->insert($image_name)) 
							$_SESSION['message'] = LANG_INSERT_SUCCESS;
						else 
							$_SESSION['message'] = LANG_INSERT_FAILED;
					}
			}
		}	
		
		$this->redirect('index.php?p='.$_GET['p'].'&q='.$_GET['q']);
	}

	function orderring(){
		extract($_POST);
		$listid = explode('-', $listid);
		array_shift($listid); 
		foreach($listid as $key =>$val){
			$this->query( "UPDATE #__category SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_cat=".$val);
		} 
		
		$this->redirect('index.php?p=content&q=category');
	}
	/*
	function remove()
	{	
		global $mod;
		if(!$mod->checkPermision(1)) {
			$_SESSION['message'] = ERROR_DEL_NO_PERMISION;		
			$this->redirect('index.php?p=content&q=category');
		}

		$check_cat = $this->checkExistsCategory($_GET['id']);
		$check_art = $this->checkExistsContent($_GET['id']);
		if($check_cat==true || $check_art==true)
				$_SESSION['message'] = ERROR_DEL_PARENT;
		else{			
				// check status delete
				$row = $this->loadObject("SELECT * FROM #__category WHERE id_cat = ".(int)$_GET['id']);
				if($row)
				{
					// delete image
					is_file($this->dirUp.$row['image']) ? unlink($this->dirUp.$row['image']) :'';	

					$this->query("DELETE FROM #__category WHERE id_cat =".$_GET['id']);
					
				}else{
					$_SESSION['message'] = 'Bài viết không tồn tại';
				} 
			
		}
				
		$this->redirect('index.php?p=content&q=category');
	}
	
	//publish
	function publish(){
		$this->query("UPDATE #__category SET publish=if(publish='1','0','1') WHERE id_cat=".$_GET['id']);	
		$this->redirect('index.php?p=content&q=category');
	}
	*/
		
	function checkExistsCategory($id_cat)
	{	
		$num = $this->num("SELECT * FROM #__category WHERE id_parent = ".(int)$id_cat); 
		return $num>0? true : false;
	}	
	
	function checkExistsContent($id_cat)
	{	
		$num = $this->num("SELECT * FROM #__content WHERE id_cat = ".(int)$id_cat); 
		return $num>0? true : false;
	}	
}

?>