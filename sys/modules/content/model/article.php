<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelArticle 
{
	public $sqlModel = '';

	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsTitleArray = array(); 
		$jsContent = $jsSummary ='';
		foreach($mod->languages as $lang):
			$jsTitleArray[$lang['code']] = addslashes($_POST['title_'.$lang['code']]);
			$jsContent .= ", content_".$lang['code']." = '".str_replace("'","##", $_POST['content_'.$lang['code']])."'";
			$jsSummary .= ", summary_".$lang['code']." = '".str_replace("'","##", $_POST['summary_'.$lang['code']])."'";
		endforeach;
		  
		$this->sqlModel = " 
						id_cat=".(int)$category.",
						date = NOW(),
						link = '".$link."', 
						price = '".$price."', 
						title = '".$json->saveDataJson1D($jsTitleArray)."',  
						meta_keywords = '".$meta_keywords."', 
						meta_description = '".$meta_description."', 
						setHome=".(int)$setHome.",
						publish = ".$publish
						.$jsSummary
						.$jsContent;
			
	}

	function insert($image, $imageList){
		global $json, $db;
		extract($_POST);
		$alias = Module::Rewrite(trim(strtolower($title_vn)));
		// check exists
		$rs = $db->loadObject("SELECT * FROM #__content WHERE alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-2' : $alias;
			
		$sql = "INSERT INTO #__content SET  ".$this->sqlModel.", 
							alias = '".$alias."', 
							user_add = ".$_SESSION['admin_id'];
		$sql .= !empty($image)? 	  ",  image='".$image."'" :'';
		$sql .= !empty($imageList)? ", imageList='".$imageList."'" :'';
		$res = $db->query($sql); 
		return $res ? true : false;
	}
	
	 
	function update($image, $imageList){	
		global $json, $db;
		extract($_POST);
		$alias = Module::Rewrite(trim(strtolower($title_vn))); 
		// check exists
		$rs = $db->loadObject("SELECT * FROM #__content WHERE id_art <> ".(int)$id_art." AND alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-'.$id_art : $alias;
		 
		$sql = "UPDATE  #__content SET ".$this->sqlModel.", 
							dateUpdate = NOW(),    
							user_modify = ".$_SESSION['admin_id'];

		$sql .= !empty($image)? 	  ",  image='".$image."'" :'';
		$sql .= !empty($imageList)? ",  imageList='".$imageList."'" :'';
		$sql .=  " WHERE id_art = ".$id_art; 
		$res = $db->query($sql);

		//update alias if right condition
		$sql2 =  "UPDATE #__content SET alias = '".$alias."' WHERE aliasFix = 0 AND id_art = ".$id_art; 
		$db->query($sql2);
		
		return $res ? true : false;
	}
	 
}

?>