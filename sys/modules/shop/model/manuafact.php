<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelManuafact 
{
	public $sqlModel = '';
	
	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsNameArray = array(); 
		$jsDescription = '';
		foreach($mod->languages as $lang):
			$jsNameArray[$lang['code']] = addslashes($_POST['name_'.$lang['code']]);
			$jsDescription .= ', description_'.$lang['code'].' = "'.str_replace("'","##", $_POST['description_'.$lang['code']]).'"';
		endforeach;
		  
		$this->sqlModel = " 
						name = '".$json->saveDataJson1D($jsNameArray)."',   
						publish = ".$publish.",
						id_manuafact=".(int)$id_manuafact
						.$jsDescription;
			
	} 

	function insert($image){	
		global $db;	
		extract($_POST);
		$alias = Module::Rewrite($name_vn);			
		// check exists alias
		$rs = $db->loadObject("SELECT * FROM #__shop_manuafact WHERE  alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-2' : $alias;
		
		$sql = "INSERT INTO #__shop_manuafact SET ".$this->sqlModel.", alias='".$alias."'";  
		$sql .= !empty($image)? ",  image='".$image."'" :'';
		$res = $db->query($sql);
		return $res ? true : false;
	}
	
	function update($image){	
		global $db;	
		extract($_POST);
		$alias = Module::Rewrite($name_vn);			
		// check exists alias
		$rs = $db->loadObject("SELECT * FROM #__shop_manuafact WHERE id_manuafact <> ".$id_manuafact." AND alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-'.$id_manuafact : $alias;
		
		$sql = "UPDATE #__shop_manuafact SET ".$this->sqlModel.", alias = '".$alias."'";  
		$sql .= !empty($image)? " ,  image='".$image."'" :'';

		$sql .= " WHERE id_manuafact = ".$id_manuafact;
		$res = $db->query($sql);
		return $res ? true : false;
	}
	
}

?>