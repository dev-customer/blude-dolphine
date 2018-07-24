<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class ModelUser {
	
	public $sqlModel = '';

	function __construct(){  
		extract($_POST); 
		global $db, $mod;	 
		$this->sqlModel = "   
							id_group = ".$mod->config['id_group'].",
							firstname = '".$firstname."',
							lastname = '".$lastname."', 
							email 	= '".$email."'";
	} 
	function insert($image){
		global $db, $mod; 
		extract($_POST);

		$username = Module::Rewrite(trim(strtolower($firstname.'.'.$lastname)));
		// check exists username
		$rs = $db->loadObject("SELECT * FROM #__users WHERE username = '".$username."'");
		$username = !empty($rs)? $username.'-2' : $username;		
		 
		$sql = "INSERT INTO #__users SET ".$this->sqlModel.",
										password = '".encryptPwdUser($password)."',
										publish = 1, 
										username = '".$username."',
										date = NOW() ";
		$sql .= !empty($image)? ", image='".$image."'" : ''; 
		$res = $db->query($sql);  
		return $res ? true : false;
	}
	
	function update($image){
		extract($_POST);  
		global $db, $mod; 

		$username = Module::Rewrite(trim(strtolower($firstname.'.'.$lastname)));
		// check exists username
		$rs = $db->loadObject("SELECT * FROM #__users WHERE id_user <> ".$_SESSION['id_user_frontend']." AND username = '".$username."'");
		$username = !empty($rs)? $username.'-2' : $username;		
		
		$sql = "UPDATE #__users SET  ".$this->sqlModel.", 
										username = '".$username."', 
										dateup = NOW() ";
		
		$sql .= !empty($password)? ", password = '".encryptPwdUser($password)."'" : "";
		$sql .= !empty($image)? " ,  image='".$image."'" :'';
		$sql .= " WHERE id_user = ".$_SESSION['id_user_frontend'];
		$res  = $db->query($sql); 
		return $res ? true : false;
	}
	
}

?>