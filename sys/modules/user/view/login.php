<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $db;
$contact = $db->loadObject('SELECT * FROM #__contact WHERE publish = 1');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login System</title>
<script type="text/javascript" src="<?=TEMPLATE?>js/jquery.min.1.11.3.js"></script>		
<script src="js/login.js"></script>
<script src="../templates/default/bootstrap/bootstrap.min.js"></script>
<link href="../templates/default/bootstrap/bootstrap.min.css" rel="stylesheet">
<style>
	body{margin:0;padding:0;background:url(images/login/bg.jpg);background-size:cover;background-color:rgba(54,142,162,0.74)}.login-wrap .login-out{border: 1px solid rgba(255, 255, 0, 0.17);width:350px;height:475px;margin:auto;margin-top:8%;padding-top:1.5%;padding-bottom:1.5%;position:relative;box-shadow:rgba(0,0,0,0.74902) 0 0 33px -2px}.login-wrap .login-in{width:90%;height:100%;position:relative;margin:auto;background:url(login-bg-in.png)#2196F3}.login-wrap .login-in-data{width:90%;margin:auto}.login-wrap .login-in-data hr{width:100%;border:1px solid rgba(0,0,0,0.74902)}.login-wrap .login-logo{float:left;margin:10px auto}.login-wrap .login-logo *{float:left}.login-wrap .login-logo span{font-size:20px;font-weight:700;margin-top:7px;color:#2d0b2d}.login-wrap .login-form .data-input{float:left;width:100%;height:30px;margin:10px auto;background-color:#eee;border:none;outline:none;padding:3px;color:#2196F3}.login-wrap .login-form .btn-action{float:left;margin:auto;margin-right:5px;background-color:#009688;border:none;cursor:pointer;color:#f0f8ff;font-size:inherit;padding-left:8px;padding-right:8px}.login-wrap .login-form .btn-action:hover{color:#F69}.login-wrap .login-form-bottom{float:left;width:100%;margin-top:40px}.login-wrap .login-form-bottom > div{width:45%}.login-wrap .login-form-bottom .login-form-bottom-left{float:left}.login-wrap .login-form-bottom .login-form-bottom-right{float:right}.login-wrap .login-form-bottom img.login-logo-b{width:100%;height:50px}.login-wrap .login-form-bottom img.login-logo-b:hover{opacity:.8}.requireRed{background-color:#CCC!important}.loader{border:10px solid #f3f3f3;border-top:10px solid #3498db;border-radius:50%;width:70px;height:70px;animation:spin 2s linear infinite}@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
	.loading_dots{background-color:rgba(0,0,0,0.2);border-radius:5px;box-shadow:inset 0 1px 0 rgba(0,0,0,0.3),0 1px 0 rgba(255,255,255,0.3);font-size:1em;line-height:1;padding:.125em 0 .175em .55em;width:2.75em;margin:20% auto}.loading_dots span{background:transparent;border-radius:50%;box-shadow:inset 0 0 1px rgba(0,0,0,0.3);display:inline-block;height:.6em;width:.6em;-webkit-animation:loading_dots .8s linear infinite;-moz-animation:loading_dots .8s linear infinite;-ms-animation:loading_dots .8s linear infinite;animation:loading_dots .8s linear infinite}.loading_dots span:nth-child(2){-webkit-animation-delay:.2s;-moz-animation-delay:.2s;-ms-animation-delay:.2s;animation-delay:.2s}.loading_dots span:nth-child(1){-webkit-animation-delay:.4s;-moz-animation-delay:.4s;-ms-animation-delay:.4s;animation-delay:.4s}@-webkit-keyframes loading_dots{0%{background:transparent}50%{background:#E4E4E4}100%{background:transparent}}@-moz-keyframes loading_dots{0%{background:transparent}50%{background:#E4E4E4}100%{background:transparent}}@-ms-keyframes loading_dots{0%{background:transparent}50%{background:#E4E4E4}100%{background:transparent}}@keyframes loading_dots{0%{background:transparent}50%{background:#E4E4E4}100%{background:transparent}}
</style>
<script>
	//Disable right click script
	var message=""
	///////////////////////////////////
	function clickIE() {if (document.all) {(message);return false;}}
	function clickNS(e) {if
	(document.layers||(document.getElementById&&!document.all)) {
	if (e.which==2||e.which==3) {(message);return false;}}}
	if (document.layers)
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
	document.oncontextmenu=new Function("return false")
</script> 
</head>
<body> 
<div class="login-wrap">
	<div class="login-out img-rounded">
		<div class="login-in">
        	<div class="login-in-data">
            	<br /> 
                <hr />
                <div class="login-logo">
                	<img src="images/login/website-icon2.png" width="57" title="Technical" />
                    <span>Administrator >> Login</span>
                </div>
                <hr />
                <div class="login-form text-center">
                	<div  id="error_message" style="width:300px; float:left; padding-top:10px;   color:yellow; display:none; margin:0 auto" align="center"></div>
                	<form class="frmLogin"  method="post"> 
						<input type="text" class="requireData alert-info data-input form-control" name="username" id="username" placeholder="<?= LANG_USER_USENAME?>" />
						<input type="password" class="requireData alert-info data-input form-control" name="password" id="password" placeholder="<?=LANG_USER_PASSWORD?>"  />
                    	 
						<center class="text-center">
							<button type="reset" class="btn btn-action"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
							<button type="button" class="btn btn-action btnLogin" id="btnLogin"><span class="glyphicon glyphicon-arrow-right"></span> Login</button>
							<a class="btn btn-action pull-right" href="<?=BASE_NAME?>" target="_blank"><span class="glyphicon glyphicon-globe"></span> Site</a>
						</center>
                    </form>
                </div>
                
                <div class="login-form-bottom">
                	<div class="login-form-bottom-left">
                    	<a href="http://hweb.vn"><img class="login-logo-b" style="background-color:#fff" src="images/login/hweb.vn.png" title="" /></a>
                    </div>
                	<div class="login-form-bottom-right">
                    	<a href="<?=BASE_NAME?>"><img class="login-logo-b" style="background:#fff" src="<?=is_file('../'.DIR_UPLOAD.'/'.$contact['image']) ? URL_UPLOAD.'/'.$contact['image'] : 'images/login/hweb.vn.png'?>" title="" /></a>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>
</body>
</html>
