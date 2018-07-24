<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Slide extends Module {

	public $dirUp = '';

	function __construct() {
		global $db, $mod;
		$this->dirUp = '../'.DIR_UPLOAD;
		$this->model($_GET['p'].'/model/slide');
	}

	function index(){
		$rowpage = PAGE_ROWS;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;					
		$sql = "SELECT * FROM #__slide ORDER BY orderring ASC";
		$num = $this->num($sql);
		$query = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
		$data['rows'] = $this->loadObjectList($query);
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=".$_GET['p'].'&q="'.$_GET['q']);

		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
		$this->view($_GET['p'].'/view/slide', $data);
	}	
	
	function add(){		
		
		$this->view($_GET['p'].'/view/slideform');
	}

	function edit() {
		$sql = "SELECT * FROM #__slide WHERE id_slide = ".(int)$_GET['id'];	
		$data['row'] = $this->loadObject($sql);
		$this->view($_GET['p'].'/view/slideform', $data);
	}
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			if(($_POST['method']=='add') && empty($_FILES['image']['name'])) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=media&q=slide&m='.$_GET['m']);
			}
			else {
					$img_type = $_FILES['image']['type'];
					$img_name = time().'_'.substr(Module::Rewrite($_FILES['image']['name']), -80);
					$image_name = '';
					// upload image
					if(Admin::checkType($img_type)){
						$image_name = Admin::upload('image', $img_name, $this->dirUp."/slide/");
						is_file($this->dirUp."/slide/".$old_image) ? unlink($this->dirUp."/slide/".$old_image) : '';
					} 

					$model = new ModelSlide();
	
					if($method == 'edit')
					{
							if($model->update($image_name)){
								$_SESSION['message'] = LANG_UPDATE_SUCCESS;
							}else{
								$_SESSION['message'] = LANG_UPDATE_FAILED; 							
								$this->redirect('index.php?p=media&q=slide&m=edit&id='.$_POST['id_slide']);
							} 
					}else{				 
							$model->insert($image_name);
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
							$this->redirect('index.php?p=media&q=slide');
					}
			}
		}	
		
		$this->redirect('index.php?p=media&q=slide');
	}
	
	//publish
	/* 
	function remove(){
		// delete image
		$row = $this->loadObject("SELECT * FROM #__slide WHERE id_slide = ".(int)$_GET['id']); 
		is_file($this->dirUp."/slide/".$row['image']) ? unlink($this->dirUp."/slide/".$row['image']) : '';	
			
		$this->query("DELETE FROM #__slide WHERE id_slide=".$_GET['id']);	
		$this->redirect('index.php?p=media&q=slide');	
	}
	*/
	function orderring(){
		while (list ($key, $val) = @each($_POST['id'])) {
			$this->query( "UPDATE #__slide SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_slide=".$val);
		} 
		$this->redirect('index.php?p=media&q=slide');	
	}
	
}

?>