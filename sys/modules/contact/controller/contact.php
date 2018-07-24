<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Contact extends Module {

	public $dirUp = '';

	function __construct() {
		global $db, $mod;
		$this->dirUp = '../'.DIR_UPLOAD.'/';
		$this->model('contact/model/contact');
	}

	function index(){
		$rowpage = 500;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;
		
		$sql = "SELECT * FROM #__contact ";

		$num = $this->num($sql);
		$sql = $num > 0 ? $sql ." LIMIT $offset, $rowpage" : $sql;
		
		$data['rows'] = $this->loadObjectList($sql);

		// Load Paging
		$data['paging'] = Paging::load($getpage, $num, $rowpage, $curpage, "index.php?p=".$_GET['p'].'&q='.$_GET['q']);		
		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
		$this->view('contact/view/contact', $data);
	}
	
	function edit() {
		$data['row'] =$this->loadObject('SELECT * FROM #__contact WHERE id_contact = '.(int)$_GET['id']);					
		$this->view('contact/view/conform', $data);
	}
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if( empty($name_vn)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=contact&q=contact&m='.$_GET['m']);
			}
			else 
			{
				
				$img_type = $_FILES['image']['type'];
				$img_name = 'contact-'.time().'_'.substr(Module::Rewrite($_FILES['image']['name']), -40);
				$image_name = '';
				// upload image
				if(Admin::checkType($img_type)){
					$image_name = Admin::upload('image', $img_name , $this->dirUp);
					is_file($this->dirUp.$old_img) ? unlink($this->dirUp.$old_img) : '';
				} 
					
				$model = new ModelContact();
				
				if($method=='edit')
				{
						if($model->update($image_name) ) 
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
						else {
							$_SESSION['message'] = LANG_UPDATE_FAILED;
							$this->redirect('index.php?p=contact&q=contact&m='.$_GET['m'].'&id='.$_POST['id_cont']);
						}							
				}else{
						if($model->insert($image_name) ) 
							$_SESSION['message'] = LANG_INSERT_SUCCESS;
						else 
							$_SESSION['message'] = LANG_INSERT_FAILED;
				}											
			}
		}	
		
		$this->redirect('index.php?p=contact&q=contact');
	}
}

?>