<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Useronline extends Module{
	
	function index(){
		
		
		$data['counter']=  $_SESSION['counter_hit'];
		
		$visitors_online = new usersOnline();	
		if (count($visitors_online->error) == 0) {	
			$data['user_online'] = $visitors_online->count_users();
		}	
		
		$this->view('useronline/view/useronline', $data);		
	}
	
}
?>