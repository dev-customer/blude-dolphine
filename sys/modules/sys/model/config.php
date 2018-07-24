<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class ModelConfig 
{
	public $sqlModel = '';
	
	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsSitenameArray = array();
		foreach($mod->languages as $lang):
			$jsSitenameArray[$lang['code']] = addslashes($_POST['sitename_'.$lang['code']]);
		endforeach;
		
		//update language
		if(count($languageActive) > 0)
		{	 
			$db->query('UPDATE #__language SET publish = 0');
			$db->query('UPDATE #__language SET publish = 1 WHERE id_lang IN('.implode(',', $languageActive).')');
		} 
		
		$this->sqlModel = " 
						sitename = '".$json->saveDataJson1D($jsSitenameArray)."', 
						meta_title = '".$meta_title."', 
						meta_keyword = '".$meta_keyword."', 
						meta_description = '".$meta_description."', 
						googleAnalyticsID = '".$googleAnalyticsID."', 
						facebookAppID = '".$facebookAppID."', 
						chatboxZopim = '".base64_encode($chatboxZopim)."', 
						imageShop = '".$imageShop."', 
						imageNews = '".$imageNews."', 
						colorMain1 = '".($colorMain1Code!=''? $colorMain1Code : $colorMain1)."', 
						colorMain2 = '".($colorMain2Code!=''? $colorMain2Code : $colorMain2)."', 
						colorMain3 = '".($colorMain3Code!=''? $colorMain3Code : $colorMain3)."', 
						colorMain4 = '".($colorMain4Code!=''? $colorMain4Code : $colorMain4)."', 
						id_group=".$id_group;
		
		if($_SESSION['id_group'] <= 0)
			$this->sqlModel .= ", activeSite = ".(int)$activeSite;
		if($_SESSION['id_group'] <= 1)
			$this->sqlModel .= ", activeSEO = ".(int)$activeSEO;
	}
	
	function update(){	 
		global $db;
		extract($_POST); 
		$sql = "UPDATE #__config SET ".$this->sqlModel.' WHERE id_config = '.$id_config;
		$res = $db->query($sql);
		return $res ? true : false;
	}
}

?>