<?php if(!defined('DIR_APP')) die('Your have not permission');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" dir=""><?php ADmin::secAdm()?>
<head>
<base href="<?= BASE_NAME.DIR_APP; ?>/" />
<title><?= ucfirst(LB_TITLE_HOME)?></title>
<link href="favicon.png" rel="icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="<?=TEMPLATE?>js/jquery.min.1.11.3.js"></script>		
<script src="<?=TEMPLATE?>bootstrap/bootstrap.min.js"></script>
<link href="<?=TEMPLATE?>bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="<?=TEMPLATE?>font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
</head>
<body class="bg-sdt1">
<div class="container-fluid">	 
	<div class="container"> 
		<div class="alert text-center bg-danger" style="color:red">Sytem updating...</div>
	</div>
</body>
</html>

            
