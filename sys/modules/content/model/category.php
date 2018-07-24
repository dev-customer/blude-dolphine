<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelCategory extends Module 
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
						link = '".$link."',
						meta_keywords = '".$meta_keywords."', 
						meta_description = '".$meta_description."',  
						id_parent=".(int)$id_parent.",
						publish = ".$publish.
						$jsContent;
			
	}

	function insert($image){
		global $json, $db;
		extract($_POST);
		$alias = Module::Rewrite($title_vn);
		// check exists alias
		$rs = $db->loadObject("SELECT * FROM #__category WHERE alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-2' : $alias;
		
		$sql = "INSERT INTO #__category SET ".$this->sqlModel.", alias = '".$alias."'";
		$sql .= !empty($image)? " ,  image = '".$image."'" :'';
		$res = $db->query($sql);
		
		return $res ? true : false;
	}
	
	function update($image){	
		global $json, $db;
		extract($_POST);
		$alias = Module::Rewrite($title_vn);
		$rs = $db->loadObject("SELECT * FROM #__category WHERE id_cat <> ".$id_cat." AND alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-'.$id_cat : $alias;
 		
		$sql = "UPDATE  #__category SET ".$this->sqlModel;   
		$sql .= !empty($image)? " ,  image='".$image."'" :'';
		$sql .=  " WHERE id_cat = ".$id_cat;
		$res = $db->query($sql);
		
		//update alias if right condition
		$sql2 =  "UPDATE #__category SET alias = '".$alias."' WHERE aliasFix = 0 AND id_cat = ".$id_cat; 
		$db->query($sql2);
				
		return $res ? true : false;
	}	

}

?>