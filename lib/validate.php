<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Validate {
	//check email
	function email($email){
		return !eregi("^[a-z0-9_-]+[a-z0-9_.-]*@[a-z0-9_-]+[a-z0-9_.-]*\.[a-z]{2,5}$", $email) ? true : false;
	}
	//check number
	function checkNumber(){
		
	}
}

?>