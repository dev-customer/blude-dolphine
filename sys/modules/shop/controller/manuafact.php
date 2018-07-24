<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Manuafact extends Module {
	public $dirUp = '';

	function __construct() {
		global $db, $mod;	
		$this->dirUp = '../'.DIR_UPLOAD.'/shop/';
		$this->model($_GET['p'].'/model/manuafact');
		
	}

	function index(){			
		$rowpage = PAGE_ROWS;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;					
		$sql = "SELECT pm.*, COUNT(p.id_product) AS products 
				FROM #__shop_manuafact pm 
				LEFT JOIN #__shop_products p ON(pm.id_manuafact = p.id_manuafact)
				GROUP BY pm.id_manuafact
				ORDER BY pm.id_manuafact";				
		$num = $this->num($sql);
		$query = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
		$data['rows'] = $this->loadObjectList($query);
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=".$_GET['p'].'&q='.$_GET['q']);
		
		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
		$this->view($_GET['p'].'/view/manuafact', $data);
	}

	function add(){		
		
		$this->view($_GET['p'].'/view/manuafactform', $data);
	}
	function edit(){		

		$data['row'] = $this->loadObject('SELECT * FROM #__shop_manuafact WHERE id_manuafact = '.(int)$_GET['id']);
		
		$this->view($_GET['p'].'/view/manuafactform', $data);
	}
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if( empty($name_vn)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=shop&q=manuafact&m='.$_POST['method'].'&id='.$_POST['id_manuafact']); 
			}
			else
			{ 
				$img_type = $_FILES['image']['type'];
				$img_name = 'manuafact-'.time().'_'.substr(Module::Rewrite($_FILES['image']['name']), -80);
				$image_name = '';
				// upload image
				if(Admin::checkType($img_type)){
					$image_name = Admin::upload('image', $img_name , $this->dirUp);
					is_file($this->dirUp.$old_img) ? unlink($this->dirUp.$old_img) : '';
				} 

				$model = new ModelManuafact();

				if($method == 'edit')
				{
					if($model->update($image_name))  
						$_SESSION['message'] = LANG_UPDATE_SUCCESS; 
					else{
						$_SESSION['message'] = LANG_UPDATE_FAILED;
						$this->redirect('index.php?p=shop&q=manuafact&m='.$_POST['method'].'&id='.$_POST['id_manuafact']); 
					}
				}else{
					if($model->insert($image_name)) 
						$_SESSION['message'] = LANG_INSERT_SUCCESS; 
					else {
						$_SESSION['message'] = LANG_INSERT_FAILED;
					}
				}
			}
		}	
		
		$this->redirect('index.php?p=shop&q=manuafact'); 
		
	}
		
	//publish
	function publish(){
		$this->query("UPDATE #__shop_manuafact SET publish=if(publish='1','0','1') WHERE id_manuafact=".$_GET['id']);	
		$this->redirect('index.php?p=shop&q=manuafact'); 
	}
	
	function orderring(){
		extract($_POST);
		$listid = explode('-', $listid);
		array_shift($listid); 
		foreach($listid as $key =>$val)
			$this->query( "UPDATE #__shop_manuafact SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_manuafact=".$val);
	 
		$this->redirect('index.php?p='.$_GET['p'].'&q='.$_GET['q']);
	}
 	
	
	function delete(){
		$flag = 0;	
		while (list ($key,$val) = @each($_POST['id'])) 
		{
			$check_pro = $this->checkExistsProducts($val);
			if($check_pro==true){
				$flag = 1;
			}else{
				
				// delete image
				$row = $this->loadObject("SELECT image FROM #__shop_manuafact WHERE id_manuafact = ".$val);
				is_file($this->dirUp.$row['image']) ? unlink($this->dirUp.$row['image']) : '';
				$this->query("DELETE FROM #__shop_manuafact WHERE id_manuafact = ".$val);
			}
		} 
		$_SESSION['message'] = $flag == 0 ? LANG_DELETE_SUCCESS : ERROR_DEL_PARENTS;
		$this->redirect('index.php?p=shop&q=manuafact'); 
	}
	function checkExistsProducts($id_manuafact)
	{	
		$num = $this->num("SELECT * FROM #__shop_products WHERE id_manuafact = ".(int)$id_manuafact); 
		return $num>0? true : false;
	}	
	/* 
	function remove(){
		$check_pro = $this->checkExistsProducts($_GET['id']);
		if($check_pro==true)
				$_SESSION['message'] = ERROR_DEL_PARENT;
		else{
				// delete image
				$row = $this->loadObject("SELECT image FROM #__shop_manuafact WHERE id_manuafact = ".(int)$_GET['id']); 
				if(!empty($row))
				{
					is_file($this->dirUp.$row['image']) ? unlink($this->dirUp.$row['image']) : '';	 
					
					$this->query( "DELETE FROM #__shop_manuafact WHERE id_manuafact=".$_GET['id']);
				} 
					
		}
			
		$this->redirect('index.php?p=shop&q=manuafact'); 
	}
	*/
	
}

?>