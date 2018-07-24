<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelLocation extends Module 
{
	public $sqlModel = '';
	
	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsTitleArray = array(); 
		$jsContent = '';
		foreach($mod->languages as $lang):
			$jsTitleArray[$lang['code']] = addslashes($_POST['title_'.$lang['code']]);
		endforeach;
		  
		$this->sqlModel = " 
						title = '".$json->saveDataJson1D($jsTitleArray)."', 
						id_parent=".(int)$id_parent.",
						publish = ".$publish;
			
	}

	function insert(){
		global $json, $db;
		extract($_POST);
		$alias = Module::Rewrite($title_vn);
		// check exists alias
		$rs = $db->loadObject("SELECT * FROM #__location WHERE alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-2' : $alias;
		
		$sql = "INSERT INTO #__location SET ".$this->sqlModel.", alias = '".$alias."'";
		$sql .= !empty($image)? " ,  image = '".$image."'" :'';
		$res = $db->query($sql);
		
		return $res ? true : false;
	}
	
	function update(){	
		global $json, $db;
		extract($_POST);
		$alias = Module::Rewrite($title_vn);
		$rs = $db->loadObject("SELECT * FROM #__location WHERE id_location <> ".$id_location." AND alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-2' : $alias;
 		
		$sql = "UPDATE  #__location SET ".$this->sqlModel;   
		$sql .=  " WHERE id_location = ".$id_location;
		$res = $db->query($sql);
		 
		return $res ? true : false;
	}	

}

?>