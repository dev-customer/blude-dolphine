<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelCategory 
{
	public $sqlModel = '';
	
	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsTitleArray = array(); 
		$jsContent = '';
		foreach($mod->languages as $lang):
			$jsTitleArray[$lang['code']] = addslashes($_POST['title_'.$lang['code']]);
			$jsContent .= ', content_'.$lang['code'].' = "'.str_replace("'","##", $_POST['content_'.$lang['code']]).'"';
		endforeach;
		  
		$this->sqlModel = " 
						title = '".$json->saveDataJson1D($jsTitleArray)."', 
						meta_keywords = '".$meta_keywords."', 
						meta_description = '".$meta_description."',  
						id_parent=".(int)$id_parent.",
						publish = ".$publish.",
						setHome = ".$setHome.
						$jsContent;
			
	} 
		
	function insert($image){
		global  $db;	
		extract($_POST);
		$alias = Module::Rewrite($title_vn);			
		// check exists alias
		$rs = $db->loadObject("SELECT * FROM #__shop_category WHERE alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-2' : $alias;
		
		$sql  = "INSERT INTO #__shop_category SET ".$this->sqlModel.", alias = '".$alias."'";   
		$sql .= !empty($image)? " ,  image='".$image."'" :'';
		$res  = $db->query($sql);
		return $res ? true : false;
	}
	
	function update($image){	
		global $db;	
		extract($_POST);
		$alias=Module::Rewrite($title_vn);			
		// check exists alias
		$rs = $db->loadObject("SELECT * FROM #__shop_category WHERE id_cat <> ".$id_cat." AND alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-'.$id_cat : $alias;
		
		$sql  = "UPDATE #__shop_category SET ".$this->sqlModel.", alias = '".$alias."'";    						
		$sql .= !empty($image)? " ,  image='".$image."'" :'';
		$sql .= " WHERE id_cat = ".$id_cat; 
		$res  = $db->query($sql); 
		return $res ? true : false;
	}
	
}

?>