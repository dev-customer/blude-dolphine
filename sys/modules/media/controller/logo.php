<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Logo extends Module {

	public $dirUp = '';

	function __construct() {
		global $db, $mod;
		$this->dirUp = '../'.DIR_UPLOAD;
		$this->model($_GET['p'].'/model/logo');
	}

	function index(){
		$rowpage = PAGE_ROWS;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;					
		$sql = "SELECT * FROM #__logo ORDER BY orderring ASC";
		$num = $this->num($sql);
		$query = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
		$data['rows'] = $this->loadObjectList($query);
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=".$_GET['p'].'&q="'.$_GET['q']);

		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
		$this->view($_GET['p'].'/view/logo', $data);
	}	
	
	function add(){		
		
		$this->view($_GET['p'].'/view/logoform');
	}

	function edit() {
		$sql = "SELECT * FROM #__logo WHERE id_logo = ".(int)$_GET['id'];	
		$data['row'] = $this->loadObject($sql);
		$this->view($_GET['p'].'/view/logoform', $data);
	}
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			if(($_POST['method']=='add') && empty($_FILES['image']['name'])) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=media&q=logo&m='.$_GET['m']);
			}
			else {
					$img_type = $_FILES['image']['type'];
					$img_name = time().'_'.substr(Module::Rewrite($_FILES['image']['name']), -80);
					$image_name = '';
					// upload image
					if(Admin::checkType($img_type)){
						$image_name = Admin::upload('image', $img_name, $this->dirUp."/logo/");
						is_file($this->dirUp."/logo/".$old_image) ? unlink($this->dirUp."/logo/".$old_image) : '';
					} 
						
					$model = new Modellogo();

					if($method == 'edit')
					{
							if($model->update($image_name)){
								$_SESSION['message'] = LANG_UPDATE_SUCCESS;
							}else{
								$_SESSION['message'] = LANG_UPDATE_FAILED; 							
								$this->redirect('index.php?p=media&q=logo&m=edit&id='.$_POST['id_logo']);
							} 
					}else{				 
							$model->insert($image_name);
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
							$this->redirect('index.php?p=media&q=logo');
					}
			}
		}	
		
		$this->redirect('index.php?p=media&q=logo');
	}
	
	//publish
	/* 
	function remove(){
		// delete image
		$row = $this->loadObject("SELECT * FROM #__logo WHERE id_logo = ".(int)$_GET['id']); 
		is_file($this->dirUp."/logo/".$row['image']) ? unlink($this->dirUp."/logo/".$row['image']) : '';	
			
		$this->query("DELETE FROM #__logo WHERE id_logo=".$_GET['id']);	
		$this->redirect('index.php?p=media&q=logo');	
	}
	*/

	function orderring(){
		while (list ($key, $val) = @each($_POST['id'])) {
			$this->query( "UPDATE #__logo SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_logo=".$val);
		} 
		$this->redirect('index.php?p=media&q=logo');	
	}
	
}

?>