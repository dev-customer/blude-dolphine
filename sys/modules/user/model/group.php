<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelGroup 
{
	public $sqlModel = '';
	
	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsNameArray = array();
		foreach($mod->languages as $lang):
			$jsNameArray[$lang['code']] = addslashes($_POST['name_'.$lang['code']]);
		endforeach;
		  
		$this->sqlModel = " 
						name = '".$json->saveDataJson1D($jsNameArray)."', 
						publish = ".$publish;
			
	}
	
	function insert(){ 
		global $db;
		$res = $db->query("INSERT INTO #__user_group SET ".$this->sqlModel);
		return $res ? true : false;
	}
	
	function update($id_group){  
		global $db;
		$res = $db->query("UPDATE #__user_group SET ".$this->sqlModel." WHERE id_group = ".$id_group); 
		return $res ? true : false;
	}

}

?>