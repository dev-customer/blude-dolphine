<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Article extends Module 
{
	public $dirUp = '';
	
	function __construct() {
		global $db, $mod;
		$this->dirUp = '../'.DIR_UPLOAD.'/content/';
		$this->model('content/model/article');
	}

	function index(){
		 
		extract($_POST);
		$rowpage = 50;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;
		$limit = $offset.','.$rowpage;
			
		$fieldList = "c.*, cc.title AS category, u.fullname AS user";	

		$_SESSION['category']  = (isset($_POST['category'])  && $_POST['category'] != -1) ? $_POST['category']: $_SESSION['category'];	
		
		
		$_SESSION['publish']  = (isset($_POST['publish'])  && $_POST['publish'] != -1) ? $_POST['publish']: $_SESSION['publish'];	
		//$sql .= isset($_POST['post_lang'])? " AND c.lang='".$_POST['post_lang']."'" : " AND c.lang='".$_SESSION['dirlang']."'";

		$sqlExt .= $_SESSION['category'] != ''? " AND c.id_cat=".(int)$_SESSION['category'] : '';
		$sqlExt .= $_SESSION['publish'] != ''? " AND c.publish=".(int)$_SESSION['publish'] : ''; 
		
		$key = isset($_POST['search'])? addslashes($_POST['search']) : '';
		$sqlExt .= !empty($key)? " AND c.title LIKE '%".$key."%'" : '';
	   
		$data 	= loadListInfo($fieldList, $sqlExt, '', $limit);  
		
		$data['paging'] = Paging::load($getpage, $data['totalRecord'], $rowpage, $curpage, "index.php?p=content&q=article");
		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
 	
		// filter publish
		$pub_select = isset($_POST['publish']) && $_POST['publish']>=0? ' selected="selected"' : '';
		$filter_publish  = '<div class="input-group"><div class="input-group-addon bg-sdt1"><span class="glyphicon glyphicon-save"></span></div>';
		$filter_publish .= '<select name="publish" id="publish" onchange="document.frm_list.submit();" class="form-control">';
		$filter_publish .= '<option value="-1">-'.ucfirst(LANG_STATUS).'-</option>';
		if(isset($_POST['publish']) && $_POST['publish']==1){
			$filter_publish .= '<option value="1"'.$pub_select.' >'.LANG_ENABLE.'</option>';
			$filter_publish .= '<option value="0" >'.LANG_DISABLE.'</option>';
		}else{
			$filter_publish .= '<option value="1" >'.LANG_ENABLE.'</option>';
			$filter_publish .= '<option value="0" '.$pub_select.' >'.LANG_DISABLE.'</option>';		
		}
		$filter_publish .= '</select></div>';
				
		//filter category
		$filter_category	=	$this->drawnSelectBox($this->getCategory());
		
		$data['filter_cat'] = $filter_category;
		$data['filter_publish'] = $filter_publish;
		$this->view('content//view/article', $data);
	}
	
	function drawnSelectBox($category)
	{
		$filter_cat  = '<div class="input-group"><div class="input-group-addon bg-sdt1"><span class="glyphicon glyphicon-save"></span> </div>';
		$filter_cat .= '<select name="category" id="category" onchange="document.frm_list.submit();" class="form-control">';
		$filter_cat .= '<option value="-1">-'.ucfirst(MENU_CATALOG).'-</option>';
		foreach($category as $k1=>$v1):
			$selected = ($_SESSION['category']!='' && $v1[0]==$_SESSION['category']) ? 'selected="selected"' : '';
			$filter_cat .= '<option value="'.$v1[0].'" class="level1" '.$selected.'>'.$v1[1].'</option>';
		endforeach;
		$filter_cat .= '</select></div>';
		return $filter_cat;
	}		
	
	function getCategory($catid="", $split="--", $list_style="|_")
	{
		global $json;
		$ret=array();
		if ($catid=="") $catid=0;
		$sql ="SELECT * FROM tbl_category WHERE id_parent=$catid ORDER BY orderring";
		$result = mysql_query($sql);
		while (($row = mysql_fetch_assoc($result)))
		{
			$ret[]=array($row['id_cat'], ($catid==0?"" : $split).$list_style.$json->getDataJson1D($row['title'], $_SESSION['dirlang']) );
			$getsub=$this->getCategory($row['id_cat'], $split.$split);
			foreach ($getsub as $sub)
				$ret[]=array($sub[0], $sub[1]);
		}
		return $ret;
	}		
	
	function add() {
		$data['category'] = $this->getCategory();		
		$this->view('content/view/artform', $data);
	}
	 
	
	function edit() {	
		$fieldList = "c.*, cc.title AS category ";	
		$sqlExt = ' AND id_art = '.(int)$_GET['id'];
	 	$data = loadItemInfo($fieldList, $sqlExt);  				
		$data['category'] = $this->getCategory();
		$this->view('content/view/artform', $data);
	}
	
	function save(){
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if( empty($category)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p=content&q='.$_GET['q'].'&m='.$_GET['m']);
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
						
					$extension = array("jpeg", "JPG", "jpg", "PNG", "png", "gif");

					//imageList----------------------				
					$imageList = array();
					foreach($_FILES["imageList"]["tmp_name"] as $key => $tmp_name)
					{
						$file_name = $_FILES["imageList"]["name"][$key];
						$ext = pathinfo($file_name, PATHINFO_EXTENSION);
						$file_nameNew = 'img-list-'.time().'-'.Module::Rewrite($file_name);						
						$filename = basename($file_nameNew, $ext);
						$file_nameNew = $filename.'-'.time().".".$ext;												
						if(in_array($ext, $extension))
						{	
							//upload.....
							move_uploaded_file($_FILES["imageList"]["tmp_name"][$key], $this->dirUp.$file_nameNew);
							array_push($imageList, "$file_nameNew");
						}
					} 
					if(!empty($imageList))
					{
						//unlink all image old
						$oldImageList = json_decode(base64_decode($_POST["imageListOld"]));
						foreach($oldImageList as $value)
							is_file($this->dirUp.$value) ? unlink($this->dirUp.$value) : '';				
	
						$imageListJS = json_encode($imageList);
					} 
					//END----------------------	  
					 
					$model = new ModelArticle();
					
					if($method == 'edit')
					{ 	
							if($model->update($image_name, $imageListJS) ) 
								$_SESSION['message'] = LANG_UPDATE_SUCCESS;
							else{
								$_SESSION['message'] = LANG_UPDATE_FAILED;
								$this->redirect('index.php?p=content&q=article&m=edit&id='.$_POST['id_art']);
							}
					}
					else
					{
							if($model->insert($image_name, $imageListJS) ) 
								$_SESSION['message'] = LANG_INSERT_SUCCESS;
							else{
								$_SESSION['message'] = LANG_INSERT_FAILED;
								$this->redirect('index.php?p=content&q=article&m=add');
							}
					}
			}
		}	
		
		$this->redirect('index.php?p=content&q=article');
	}	
	
	function orderring(){
		extract($_POST);
		$listid = explode('-', $listid);
		array_shift($listid); 
		foreach($listid as $key =>$val){
			$this->query("UPDATE #__content SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_art=".(int)$val);
		} 

		$this->redirect('index.php?p=content&q=article');	
	}

	function set_home(){
		$this->query("Update #__content Set set_home=if(set_home='1','0','1') WHERE id_art=".$_GET['id']);	
		$this->redirect('index.php?p=content&q=article');	
	}
	
	function delete(){
		$array_id = array();
		while (list ($key,$val) = @each($_POST['id'])) {
			$array_id[] = $val;
		} 
		// delete image
		$rows = $this->loadObjectList("SELECT * FROM #__content WHERE id_art IN (".implode(',', $array_id).")");
		foreach($rows as $v)
		{		
			//delete
			is_file($this->dirUp.$v['image']) ? unlink($this->dirUp.$v['image']) :'';
			
			//delete imageList
			$tmp = json_decode($v['imageList']);
			foreach($tmp as $key=>$value)
				is_file($this->dirUp.$value) ? unlink($this->dirUp.$value) : ''; 
		}
		
		$res = $this->query("DELETE FROM #__content WHERE id_art IN (".implode(',', $array_id).")");
		
		$this->redirect('index.php?p=content&q=article');
	}

	 
	/*
	function publish(){
		if(isset($_POST['id'])){
			while (list ($key, $val) = @each($_POST['id'])) 
				$this->query( "UPDATE #__content SET publish=if(publish='1','0','1') WHERE id_art=".$val);	
		}else if(isset($_GET['id'])){
			$this->query("Update #__content Set publish=if(publish='1','0','1') WHERE id_art=".$_GET['id']);	
		}

		$this->redirect('index.php?p=content&q=article');	
	}
	function remove(){
		// check status delete
		$row = $this->loadObject("SELECT statusDelete, image, imageList, tabGallery FROM #__content WHERE id_art = ".(int)$_GET['id']);
		if($row){
			if($row['statusDelete']==1)
			{
				// delete image
				is_file($this->dirUp.$row['image']) ? unlink($this->dirUp.$row['image']) :'';	
				
				// delete imageList
				$tmp = json_decode($row['imageList']);
				foreach($tmp as $key=>$value)
					is_file($this->dirUp.$value) ? unlink($this->dirUp.$value) : '';	 
				 
				$this->query("DELETE FROM #__content WHERE id_art=".$_GET['id']);
			}else{
				$_SESSION['message'] = 'Bài viết này thuộc mục thông tin không được xóa. Bạn chỉ có thể sửa';
			}
		}else{
			$_SESSION['message'] = 'Bài viết không tồn tại';
		} 
						
		$this->redirect('index.php?p=content&q=article');
	}
	*/
}

?>