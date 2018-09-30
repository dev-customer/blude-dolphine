<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Products extends Module {
	public $dirUp = '';
	
	function __construct() {
		global $db, $mod;
		$this->dirUp = '../'.DIR_UPLOAD.'/shop/';
		$this->model('shop/model/products');
	}
 	 

	function index(){			
		global $json;
		$rowpage = 50;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
		$offset = ($getpage - 1) * $rowpage;		
		$limit = $offset.','.$rowpage;
		
		$fieldList = "p.*, c.title AS category, m.name AS manuafact";		

		$_SESSION['category']  = (isset($_POST['category'])  && $_POST['category'] != -1) ? $_POST['category']: -1;	
		$_SESSION['publish']  = (isset($_POST['publish'])  && $_POST['publish'] != -1) ? $_POST['publish']: -1;	
		$_SESSION['manuafact']  = (isset($_POST['manuafact'])  && $_POST['manuafact'] != -1) ? $_POST['manuafact']: -1;	
			
		$sqlExt .= $_SESSION['category']!='-1'? " AND p.id_cat = ".(int)$_SESSION['category'] : '';
		$sqlExt .= $_SESSION['publish']!='-1'? " AND p.publish = ".(int)$_SESSION['publish'] : '';
		$sqlExt .= $_SESSION['manuafact']!='-1'? " AND p.id_manuafact = ".(int)$_SESSION['manuafact'] : '';

		$key = isset($_POST['search'])? addslashes($_POST['search']) : '';
		$sqlExt .= !empty($key)? " AND p.title LIKE '%".$key."%'" : '';
						
		// filter publish box
		$pub_select = isset($_POST['publish']) && $_POST['publish']>=0? ' selected="selected"' : '';
		$filter_publish  = '<div class="input-group"><div class="input-group-addon bg-sdt1"><span class="glyphicon glyphicon-save"></span></div>';
		$filter_publish .= '<select name="publish" id="publish" onchange="document.frm_list.submit();" class="form-control">';
		$filter_publish .= '<option value="-1">-'.ucfirst(LANG_STATUS).'-</option>';
		if(isset($_POST['publish']) && $_POST['publish']==1){
			$filter_publish .= '<option value="1" '.$pub_select.' >'.LANG_ENABLE.'</option>';
			$filter_publish .= '<option value="0" >'.LANG_DISABLE.'</option>';
		}else{
			$filter_publish .= '<option value="1" >'.LANG_ENABLE.'</option>';
			$filter_publish .= '<option value="0" '.$pub_select.' >'.LANG_DISABLE.'</option>';		
		}
		$filter_publish .= '</select></div>';

		// filter category
		$filter_cat  = '<div class="input-group"><div class="input-group-addon bg-sdt1"><span class="glyphicon glyphicon-save"></span> </div>';
		$filter_cat .= '<select name="category" id="category" onchange="document.frm_list.submit();" class="form-control">';
		$filter_cat .= '<option value="-1">-'.ucfirst(MENU_SHOP_CATALOG).'-</option>';
		foreach($this->getCategory() as $cat) 
		{	
			$select = (isset($_POST['category']) && $_POST['category']==$cat[0]) ? 'selected="selected"' : '';
			$filter_cat .= '<option value="'.$cat[0].'" '.$select.' >'.$cat[1].'</option>';
		}	
		$filter_cat .= '</select></div>';

		// filter manuafact
		$manList = $this->loadObjectList('SELECT * FROM #__shop_manuafact');
		$filter_man  = '<div class="input-group"><div class="input-group-addon bg-sdt1"><span class="glyphicon glyphicon-save"></span> </div>';
		$filter_man .= '<select name="manuafact" id="manuafact" onchange="document.frm_list.submit();">';
		$filter_man .= '<option value="-1">-'.ucfirst(MEBU_MANUAFACT).'-</option>';
		foreach($manList as $row) 
		{	
			$select = (isset($_POST['manuafact']) && $_POST['manuafact'] == $row['id_manuafact']) ? 'selected="selected"' : '';
			$filter_man .= '<option value="'.$row['id_manuafact'].'" '.$select.' >'.$json->getDataJson1D($row['name'], $_SESSION['dirlang']).'</option>';
		}	
		$filter_man .= '</select></div>';
		
		$orderby = ' ORDER BY p.id_product DESC';
		$data 	= loadListShop($fieldList, $sqlExt, $orderby, $limit);  
		$data['paging'] = Paging::load($getpage, $data['totalRecord'], $rowpage, $curpage, "index.php?p=shop&q=products");
		$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;

		$data['filter_publish'] = $filter_publish;
		$data['filter_cat'] = $filter_cat;
		$data['filter_man'] = $filter_man;
		$this->view('shop/view/products', $data);
	}

	function getCategory($catid="", $split="_", $list_style="|_")
	{
		global $json;
		$ret=array();
		if ($catid=="") $catid=0;
		$result = $this->query("SELECT id_cat, title  FROM #__shop_category  WHERE publish=1 AND id_parent=$catid");
				
		while (($row = mysql_fetch_assoc($result)))
		{
			 $ret[] = array($row['id_cat'], ($catid==0?"" : $split). $list_style.$json->getDataJson1D($row['title'], $_SESSION['dirlang']));
			 $getsub = $this->getCategory($row['id_cat'], $split.$split, $list_style);
			 foreach($getsub as $sub)
				$ret[] = array($sub[0], $sub[1]);
		}
		return $ret;
	}		
	
	function add() {
		$data['category'] = $this->getCategory();	
		$data['manuafacts'] = $this->loadObjectList('SELECT * FROM #__shop_manuafact');	
		$this->view('shop/view/productsform', $data);
	}
	
	function edit() {	
		$fieldList = "p.*, c.title AS category ";	
		$sqlExt = ' AND id_product = '.(int)$_GET['id'];
	 	$data = loadItemShop($fieldList, $sqlExt); 	
		
		$data['category'] = $this->getCategory();
		$data['manuafacts'] = $this->loadObjectList('SELECT * FROM #__shop_manuafact');	
		
		$this->view('shop/view/productsform', $data);
	}
 
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			if( empty($title_vn) || $id_cat=='') {
				$_SESSION['message'] = LANG_REQUIRE; 
				$this->redirect('index.php?p=shop&q=products&m='.$_POST['method'].'&id='.$_POST['id_product']); 
			}
			else{   					
					
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
						$file_nameNew = 'gallery-'.Module::Rewrite($file_name);						
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

					//COLOR + IMAGE  
					$colorList = array(); 
					if($numberRowDyn >= 1) 
					{ 
						for($i=1; $i < $numberRowDyn; $i++ ):
						
							//check new
							if(!empty($_FILES['colorImage'.$i]['name'])){	
								//upload image
								$fileName = $_FILES['colorImage'.$i]["name"];
								$ext = pathinfo($fileName, PATHINFO_EXTENSION);
								$fileNameRe = 'color-'.Module::Rewrite($fileName);						
								$filename = basename($fileNameRe, $ext);
								$fileNameNew = $filename.'-'.time().".".$ext;												
								
								move_uploaded_file($_FILES['colorImage'.$i]["tmp_name"], $this->dirUp.$fileNameNew);
								//remove Old Image old
								is_file($this->dirUp.$_POST['jsColorImageItem'.$i]) ? unlink($this->dirUp.$_POST['jsColorImageItem'.$i]) : '';
								
								//combine data
								$colorList[]  = array(
									'color'  => $_POST['color'.$i],  
									'image'  => $fileNameNew 
								);
							}else{
								if(is_file($this->dirUp.$_POST['jsColorImageItem'.$i])){  
									$colorList[]  = array(
										'color'  => $_POST['color'.$i],  
										'image'  => $_POST['jsColorImageItem'.$i] 
									);
								}
							}
						endfor; 
					}  
					if(!empty($colorList))
					{
						$colorListJS = json_encode($colorList); 
					} 
	 
					//Size
					$sizeList = array(); 
					if($numberRowDynSize >= 1) 
					{ 
						for($i=1; $i < $numberRowDynSize; $i++ ):   
								$sizeList[]  = array(
									'size'  => $_POST['size'.$i],  
									'image'  => '' 
								);  
						endfor; 
					}  
					if(!empty($sizeList))
					{
						$sizeListJS = json_encode($sizeList); 
					}


                    //Soluong
                    $soluongList = array();
                    if($numberRowDynSoluong >= 1)
                    {
                        for($i=1; $i < $numberRowDynSoluong; $i++ ):
                            $soluongList[]  = array(
                                    'soluong'  => $_POST['soluong'.$i],
                                    'gia'  => $_POST['gia'.$i],
                            );
                        endfor;
                    }

                    if(!empty($soluongList))
                    {
                        $soluongListJS = json_encode($soluongList);
                    }


                    $model = new ModelProducts();

					if($method == 'add')
					{ 	
						if($model->insert($image_name, $imageListJS, $colorListJS, $sizeListJS, $soluongListJS) )
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
						else{
							$_SESSION['message'] = LANG_UPDATE_FAILED; 							
							$this->redirect('index.php?p=shop&q=products&m='.$_POST['method'].'&id='.$_POST['id_product']);
						}
					}else if($method == 'edit')
					{ 	
						if($model->update($image_name, $imageListJS, $colorListJS, $sizeListJS, $soluongListJS) )
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
						else{
							$_SESSION['message'] = LANG_UPDATE_FAILED; 							
							$this->redirect('index.php?p=shop&q=products&m='.$_POST['method'].'&id='.$_POST['id_product']);
						}
					} 
			}
		}	
		 
		$this->redirect('index.php?p='.$_GET['p'].'&q='.$_GET['q']);
	}  
	
	function orderring(){
		extract($_POST);
		$listid = explode('-', $listid);
		array_shift($listid); 
		foreach($listid as $key =>$val)
			$this->query( "UPDATE #__shop_products SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_product=".$val);
	 
		$this->redirect('index.php?p='.$_GET['p'].'&q='.$_GET['q']);
	}
 	
	function delete()
	{
		$array_id = array();
		while (list ($key,$val) = @each($_POST['id'])) 
		{  
			$array_id[] = $val; 
		}
				
		$rows = $this->loadObjectList("SELECT * FROM #__shop_products WHERE id_product IN (".implode(',', $array_id).")");
		foreach($rows as $v)
		{		
			//delete
			is_file($this->dirUp.$v['image']) ? unlink($this->dirUp.$v['image']) :'';
			
			//delete imageList
			$tmp = json_decode($v['imageList']);
			foreach($tmp as $key=>$value)
				is_file($this->dirUp.$value) ? unlink($this->dirUp.$value) : ''; 
			//delete colorList
			$tmp2 = json_decode($v['jsColorGroup']);
			foreach($tmp2 as $key=>$value)
				is_file($this->dirUp.$value) ? unlink($this->dirUp.$value) : ''; 
		}		
		
		$res = $this->query("DELETE FROM #__shop_products WHERE id_product IN (".implode(',', $array_id).")"); 
		$this->redirect('index.php?p=shop&q=products');
	}

	/*
	function remove(){
		// delete image
		$row = $this->loadObject("SELECT image, imageList FROM #__shop_products WHERE id_product = ".(int)$_GET['id']); 
		if(!empty($row))
		{
			is_file($this->dirUp.$row['image']) ? unlink($this->dirUp.$row['image']) : '';	
			$tmp = json_decode($row['imageList']);
			foreach($tmp as $key=>$value)
				is_file($this->dirUp.$value) ? unlink($this->dirUp.$value) : '';	
			
			$this->query("DELETE FROM #__shop_products WHERE id_product = ".(int)$_GET['id']);
		}
		$this->redirect('index.php?p=shop&q=products');
	}
	*/
}

?>