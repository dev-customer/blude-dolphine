<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Location extends Module 
{

	function __construct() {
		global $db, $mod;
		 
		$this->model($_GET['p'].'/model/location');
	}

	function index()
	{
		$filter_cat  = '<div class="input-group"><div class="input-group-addon bg-sdt1"><span class="glyphicon glyphicon-save"></span> '.ucfirst(MENU_CATALOG).':</div>';
		$filter_cat .= '<select name="location" id="location"  onchange="document.frm_list.submit();" class="form-control">';
		$filter_cat .= '<option value="-1">-All---------------</option>';
		foreach($this->getlocation() as $cat){
			if(isset($_POST['location']) && $cat[0]==$_POST['location'])
				$filter_cat .= '<option value="'.$cat[0].'" selected="selected">'.$cat[1].'</option>';
			else
				$filter_cat .= '<option value="'.$cat[0].'">'.$cat[1].'</option>';
		}
		$filter_cat .= '</select></div>';
	
		$data['filter_cat'] = $filter_cat;
		if(isset($_POST['location']) && $_POST['location']!='-1') 
			$data['rows'] = $this->getLocation($_POST['location']); 
		else
			$data['rows'] = $this->getLocation(); 
		$this->view($_GET['p'].'/view/location', $data);
	}
	
	function getLocation($catid="", $split="_", $list_style="|_")
	{
		global $json;
		$ret=array();
		if ($catid=="") 
			$catid=0;
			
		$sql = "SELECT cc.* FROM #__location cc  WHERE id_parent = $catid  ORDER BY orderring";	
		
		$result = $this->query($sql);
		while (($row = mysql_fetch_assoc($result)))
		{
			 $ret[]=array($row['id_location'], ($catid==0?"" : $split). $list_style. $json->getDataJson1D($row['title'], $_SESSION['dirlang']), $row['orderring'] , $row['publish'], $row['image'], $row['setDelete'], $row['setEdit'] );
			 
			 $getsub=$this->getLocation($row['id_location'], $split.$split, $list_style);
			 foreach ($getsub as $sub)
				$ret[]=array($sub[0], $sub[1], $sub[2], $sub[3], $sub[4], $sub[5], $sub[6], $sub[7]);
		}
		return $ret;
	}		
	
	function add() {
		global $mod; 
		$data['location'] = $this->getlocation();		
		$this->view($_GET['p'].'/view/locationform', $data);
	}
	
	function edit() {
		 
		$data['row'] = $this->loadObject('SELECT cat.* FROM #__location cat  WHERE id_location = '.(int)$_GET['id']);
		$data['location'] = $this->getlocation();				
		$this->view($_GET['p'].'/view/locationform', $data);
	}
	
	function save(){		
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if( empty($title_vn)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect('index.php?p='.$_GET['p'].'&q='.$_GET['q'].'&m='.$_GET['m']);
			}
			else{
					 
					$model = new ModelLocation();
					
					if($method=='edit')
					{
						if($model->update() ) 
							$_SESSION['message'] = LANG_UPDATE_SUCCESS;
						else
						{
							$_SESSION['message'] = LANG_UPDATE_FAILED;
							$this->redirect('index.php?p=location&q=location&m=edit&id='.$_POST['id_location']);
						}
					}else
					{
						if($model->insert()) 
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
			$this->query( "UPDATE #__location SET orderring = ".(int)$_POST[$val.'_id']." WHERE id_location=".$val);
		} 
		
		$this->redirect('index.php?p=location&q=location');
	} 
	  	
}

?>