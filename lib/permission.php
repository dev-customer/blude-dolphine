<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Permission {
	function __construct(){

	}
	
	function loadMenuFunc($group='', $module='', $control='', $method='', $id='', $type='', $label=""){
		global $db;
		//check permistion
		$sql = "SELECT id_permis, image, setAdmin 
		 		FROM #__permission 
		 		WHERE id_group >= ".(int)$group." AND module = '".$module."' AND controller = '".$control."' AND type='".$type."'";
		$row = $db->loadObject($sql); 
		if(!empty($row) && $row['setAdmin'] == 1)
			echo '<li><span class="glyphicon glyphicon-'.($row['image']!=''? $row['image']:'th-large').'"></span>&#160;&#160;<span><a href="index.php?p='.$module.'&q='.$control.'">'.$label.'</a></span></li>';
	}

	function loadMenuGroupFunc($group='', $module='', $array_func='', $class="", $type='', $label=''){
		global $db;
	 	//check permistion
		$sql = "SELECT id_permis, image, setAdmin 
			 	FROM #__permission 
			 	WHERE id_group >= ".(int)$group." AND module = '".$module."' AND controller ='' AND type='".$type."'";
		$row = $db->loadObject($sql);
		if(!empty($row) && $row['setAdmin'] == 1)
		{
			echo '<li class="dropdown '.$class.'" style="'.($_GET['p']==$module? "background:#297eb1":"").'"><span class="glyphicon glyphicon-'.$row['image'].'"></span>&#160;&#160;<a class="dropdown-toggle" data-toggle="dropdown">'.$label.'<span class="caret hidden"></span></a>
					<ul class="dropdown-menu sub_submenu">';
					foreach($array_func as $func)
						$this->loadMenuFunc($group, $module, $func[0], '', '', $type, $func[1]);											
			echo    '</ul>
				  </li>';			
		}
	}	

	function checkPermissMethod($group='', $module='', $control='', $method='', $type=''){
		 
	}	

	function checkPermissID($group='', $module='', $control='', $method='', $id='', $type=''){
		 
	}	
	
	function checkPermissAccess($group='', $module='', $control='', $type='')
	{
		global $db;
	 	//check permistion
		$sql = "SELECT * 
			 	FROM #__permission 
			 	WHERE id_group >= ".(int)$group." AND module = '".$module."' AND controller ='".$control."' AND type='".$type."' AND setAdmin = 1";		
		$row = $db->num($sql);
		if($row==0){
			exit('<div class="alert bg-danger">Access denied: You can not access this function(*)</div>');
			//return false;
		}
	}	

}
?>