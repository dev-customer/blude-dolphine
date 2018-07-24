<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelContact extends Module
{
	public $sqlModel = '';

	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsNameArray = $jsAddressArray = array(); 
		$jsDesc = $jsAddGroup1 = $jsAddGroup2 = $jsAddGroup3 = '';
		foreach($mod->languages as $lang):
			$jsNameArray[$lang['code']] = addslashes($_POST['name_'.$lang['code']]);
			$jsAddressArray[$lang['code']] = addslashes($_POST['address_'.$lang['code']]);
			$jsAddGroup1 .= ', address_1_'.$lang['code'].' = "'.str_replace("'","##", $_POST['address_1_'.$lang['code']]).'"';
			$jsAddGroup2 .= ', address_2_'.$lang['code'].' = "'.str_replace("'","##", $_POST['address_2_'.$lang['code']]).'"';
			$jsAddGroup3 .= ', address_3_'.$lang['code'].' = "'.str_replace("'","##", $_POST['address_3_'.$lang['code']]).'"';
			$jsDesc 	.= ', description_'.$lang['code'].' = "'.htmlspecialchars(str_replace("'","##", $_POST['description_'.$lang['code']])).'"';
		endforeach;
		  
		$this->sqlModel = "   
						name = '".$json->saveDataJson1D($jsNameArray)."',
						address = '".$json->saveDataJson1D($jsAddressArray)."', 
						email = '".$email."',  
						phone='".$phone."',	
						tel='".$tel."', 
						fax='".$fax."', 
						gpkd = '".$gpkd."', 
						website='".$website."', 
						skyper='".$skyper."',
						linkMaps='".$linkMaps."', 
						linkFb='".$linkFb."', 
						linkTw='".$linkTw."', 
						linkGg='".$linkGg."', 
						linkInstergram='".$linkInstergram."', 
						linkPinterest='".$linkPinterest."', 
						linkYu='".$linkYu."',  
						publish=".$publish
						.$jsDesc
						.$jsAddGroup1
						.$jsAddGroup2
						.$jsAddGroup3;
			
	} 

	function update($image){	
		global $db;
		extract($_POST);  
		$sql = "UPDATE  #__contact SET ".$this->sqlModel;
  
		$sql .= !empty($image)? " ,  image='".$image."'" :''; 
		$sql .= " WHERE id_contact = ".$id_contact;
		$res = $db->query($sql);		
		return $res ? true : false;
	}	

}

?>