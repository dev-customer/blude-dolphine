<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelProducts 
{
	public $sqlModel = '';
	
	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 		
		$jsTitleArray = array(); 
		$jsContent = $jsSummary = '';
		foreach($mod->languages as $lang):
			$jsTitleArray[$lang['code']] = addslashes($_POST['title_'.$lang['code']]);
			$jsContent .= ", description_".$lang['code']." = '".str_replace("'","##", $_POST['description_'.$lang['code']])."'";
			$jsSummary .= ", summary_".$lang['code']." = '".str_replace("'","##", $_POST['summary_'.$lang['code']])."'";
		endforeach;
		  
		$this->sqlModel = " 
						title = '".$json->saveDataJson1D($jsTitleArray)."', 
						meta_keywords = '".$meta_keywords."', 
						meta_description = '".$meta_description."',  
						code = '".$code."', 
						link = '".$link."', 
						price = ".(int)$price.", 
						discount = ".(int)$discount.", 
						publish = ".$publish.",
						size = '".$size."',
						jsLocationGroup = '".json_encode($_POST['jsLocationGroup'])."',
						id_manuafact=".(int)$id_manuafact.", 
						id_location=".(int)$id_location.", 
						id_cat=".(int)$id_cat
						.$jsSummary
						.$jsContent;
						
		
	} 
			
	function insert($image, $imageList, $jsColorGroupJS, $jsSizeGroupJS, $soluongListJS){
		global $db;	
		extract($_POST);
		 	
		$alias = Module::Rewrite($title_vn);			
		// check exists alias
		$rs = $db->loadObject("SELECT * FROM #__shop_products WHERE  alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-2' : $alias;
		 
		$sql = "INSERT INTO #__shop_products SET ".$this->sqlModel.", alias='".$alias."'";
	
		$sql .= !empty($image)? 	",  image 	  = '".$image."'" :'';
		$sql .= !empty($imageList)? ",  imageList = '".$imageList."'" :'';
		$sql .= !empty($jsColorGroupJS)? ",  jsColorGroup = '".$jsColorGroupJS."'" :'';
		$sql .= !empty($jsSizeGroupJS)? ",  jsSizeGroup = '".$jsSizeGroupJS."'" :'';
        $sql .= !empty($soluongListJS)? ", jsSoluong = '".$soluongListJS."'" :'';
		
		$res = $db->query($sql);
		return $res ? true : false;
	}
	
	function update($image, $imageList, $jsColorGroupJS, $jsSizeGroupJS, $soluongListJS){
		global $db;	
		extract($_POST);
		$alias = Module::Rewrite($title_vn);			
	
		//check exists
		$rs = $db->loadObject("SELECT * FROM #__shop_products WHERE  id_product <> ".(int)$id_product." AND alias ='".$alias."'");
		$alias = !empty($rs)? $alias.'-'.$id_product : $alias; 

		$sql = "UPDATE #__shop_products SET ".$this->sqlModel.", alias = '".$alias."'";
					  
		$sql .= !empty($image)? 	 ",  image 	  = '".$image."'" : '';
		$sql .= !empty($imageList)?  ", imageList = '".$imageList."'" : '';
		$sql .= !empty($jsColorGroupJS)? ",  jsColorGroup = '".$jsColorGroupJS."'" :'';
		$sql .= !empty($jsSizeGroupJS)? ",  jsSizeGroup = '".$jsSizeGroupJS."'" :'';
        $sql .= !empty($soluongListJS)? ",  jsSoluong = '".$soluongListJS."'" :'';

		$sql .= " WHERE id_product = ".$id_product; 
		
		$res = $db->query($sql);
		return $res ? true : false;
	}}

?>