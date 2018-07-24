<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Home extends Module { 
	function __construct() {
		global $db, $mod;
	}

	function index(){ 
		$this->view('home/view/home');
	}	 
}

?>