<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelLogo 
{
	public $sqlModel = '';

	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	 
		$jsTitleArray = array();  
		foreach($mod->languages as $lang) 
			$jsTitleArray[$lang['code']] = addslashes($_POST['title_'.$lang['code']]);
		 
		$this->sqlModel = "  
						link = '".$link."',   
						title = '".$json->saveDataJson1D($jsTitleArray)."', 
						publish = ".$publish;
			
	}

	function insert($image){	
		global $db;	
		extract($_POST); 
		$sql = "INSERT INTO #__logo SET ".$this->sqlModel;

		$sql .= !empty($image)? ",  image = '".$image."'" :'';
					
		$res = $db->query($sql);
		return $res ? true : false;
	}
	
	function update($image){	
		global $db;	
		extract($_POST);
		
		$sql = "UPDATE #__logo SET ".$this->sqlModel; 

		$sql .= !empty($image)? ",  image='".$image."'" :'';
		$sql .=" WHERE id_logo = ".$id_logo;
		$res = $db->query($sql);
		return $res ? true : false;
	}
}

?>