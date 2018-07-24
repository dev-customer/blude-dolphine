<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelUser 
{	
	public $sqlModel = '';
	
	function __construct(){  
		extract($_POST); 
		global $db, $json, $mod;	
		 
		$jsNameArray = $jsFNameArray = $jsLNameArray = array();
		foreach($mod->languages as $lang):
			$jsNameArray[$lang['code']] = addslashes($_POST['fullname_'.$lang['code']]);
			$jsFNameArray[$lang['code']] = addslashes($_POST['firstname_'.$lang['code']]);
			$jsLNameArray[$lang['code']] = addslashes($_POST['lastname_'.$lang['code']]);
		endforeach;
		
		//security
		if((int)$id_group < $_SESSION['id_group']){
			$_SESSION['message'] = 'Bạn không thể chọn nhóm cao hơn nhóm bạn được phép';
			exit($_SESSION['message']); 
		}
		
		$this->sqlModel = " 
						fullname = '".$json->saveDataJson1D($jsNameArray)."', 
						firstname = '".$json->saveDataJson1D($jsFNameArray)."', 
						lastname = '".$json->saveDataJson1D($jsLNameArray)."', 
						username = '".$username."',
						email = '".$email."',
						id_group = ".$id_group.", 
						publish = ".$publish; 
	}

	function insert(){
		global $db;
		extract($_POST);
		$num = $db->num("SELECT * FROM #__users WHERE username = '".$username."' OR email = '".$email."'");
		if($num <= 0)
		{
			$sql = "INSERT INTO #__users SET ".$this->sqlModel.", password = '".md5(sha1($password))."'";
			$res = $db->query($sql);
			return $res ? true : false;
		}else{
			$_SESSION['message'] = LANG_ERR_USRNAME_EXISTS;
			return  false;
		}
	}
	
	function update(){
		global $db;
		extract($_POST); 
 
		$num = $db->num("SELECT * FROM #__users WHERE id_user <> ".$id_user." AND (username = '".$username."' OR email = '".$email."')");
		if($num<=0)
		{
			$sql = "UPDATE #__users SET ".$this->sqlModel;
			if(!empty($password))
				$sql .= ", password = '".md5(sha1($password))."'";
			$sql .=" WHERE id_user = ".$id_user;
			$res = $db->query($sql);
		}else
			$_SESSION['message'] = LANG_ERR_USRNAME_EXISTS;
		
		return $res ? true : false;
	}
	
}

?>