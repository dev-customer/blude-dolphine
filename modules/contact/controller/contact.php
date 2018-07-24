<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Contact extends Module{
	function __construct() {
		global $db, $mod;	 

	}

	function index(){
		global $db, $mod;	
		if($_POST)
		{	  
			 
			extract($_POST); 			
			$_SESSION['message_flag'] = $_SESSION['message'] = ''; 
			$cf = $db->loadObject('SELECT email FROM #__contact WHERE publish = 1 LIMIT 1');
			
			if(empty($name) || empty($email) || empty($content)) {
				$_SESSION['message'] 		= "Các thông tin bắt buộc cần được cung cấp. <br />";
				$_SESSION['message_flag'] 	= 1; 
			}
			
			$valid = new Validate(); 
			if($valid->email($email)){
				$_SESSION['message'] .= "Email không đúng định dạng. <br />";
				$_SESSION['message_flag'] = 1; 
			}			 
  
			//Check and send mail
			if($_SESSION['message_flag']=='')
			{			
				
				$sql = "INSERT INTO #__contact_msg SET 
								name='".$name."', 
								email='".$email."', 
								subject='".$subject."', 
								content='".$content."',
								date = '".timeReal()."'";
 				$db->query($sql);
				//include("lib/PA.smtp.php");
				//send mail				 
				
			}
			
			//redirect
			$this->redirect($mod->curPageURL());

		}else{
			$this->view('contact/view/contactform');		
		}
 
	}
	 
}
?>