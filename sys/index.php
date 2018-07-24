<?php define('DIR_APP', 'sys');
$t = array(12,13,14);
 
error_reporting(0);
session_start();
if(isset($_POST['post_lang']))
	$_SESSION['dirlang'] =$_POST['post_lang'];
elseif(!isset($_SESSION['dirlang']) || $_SESSION['dirlang']=='')
	$_SESSION['dirlang'] ='vn'; 
//var_dump($_SESSION);
//echo '<span style="text-align:center; width:100%; float:left; background-color:blue">Hệ thống đã cập nhật xong</span>';
include('../config.php');
include('../lib/database.php');
include('../lib/admin.php');
include('../lib/permission.php');
include('../lib/validate.php');
include('../lib/module.php');
include('../lib/class.image.php');
include('lib/paging.php');
include('../lib/func_extend.php');
include('../lib/dateclass.php');
include('../lib/db.info.php');
include('../lib/db.shop.php');
include('../lib/Json.Class.php');
include('../lib/db.location.php');
$json = new JsonData;
$db = new Database;
$db->connect($dbhost, $dbuser, $dbpass, $dbname);
$mod = new Module;  
$perm = new Permission;  
$classImg = new SimpleImage;
$cLocation = getCategoryLocation(0, '', '');

$mod->lang('index'); 
if($mod->config['activeAdmin']==0){$mod->view('home/view/error');	exit('');}		
if(empty($_SESSION['admin_id']) ){ 
	$mod->load('user', 'user', 'login');
} else 
{	
?>    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" dir=""><?php ADmin::secAdm()?>
<head>
<base href="<?= BASE_NAME.DIR_APP; ?>/" />
<title><?= ucfirst(LB_TITLE_HOME)?></title>
<style type="text/css" media="all">
@import url(css/framework.css);
@import url(css/drop-menu-simple.css);
.nav-tabs>li>a{background: #ccc;}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{background:#218c8d !important; color: yellow !important;}
.meta_keyword, .meta_description{background:rgba(236, 163, 99, 0.32) !important}
.form-control{border: 1px solid rgba(0, 150, 136, 0.09) !important; height:30px !important;     background: rgba(247, 247, 247, 0.5) !important;}
.htabs a{    padding: 10px 7px;}
.borderRequest{border:1px solid red !important}
#button_search .glyphicon-search{font-size:11px}
table.tblList tbody tr td{padding:3px}
table.tblList tbody tr td .btn{padding:4px 6px}
</style>
<link href="favicon.png" rel="icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="<?=TEMPLATE?>js/jquery.min.1.11.3.js"></script>		
<script src="<?=TEMPLATE?>bootstrap/bootstrap.min.js"></script>
<link href="<?=TEMPLATE?>bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="<?=TEMPLATE?>font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
<link href="<?=TEMPLATE?>css/bootstrap.extend.css" rel="stylesheet">
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script src="<?=TEMPLATE?>js/jquery.price_format.2.0.min.js"></script>  
<script language="javascript" type="text/javascript">
	$(document).ready(function () {
		//-------------------------------------------------------------------------------------
		$('#post_lang').change(function() { var lang = $(this).val(); $('#lang').val(lang);  document.frm_lang.submit();	 });
		$('.tblForm > tbody > tr').each(function(index, element) { $(this).children('td:first').addClass('tdFormTitle'); });
		//change status public record
		$('img.change-status-record').click(function(){
			$this1  = $(this); $tmp 	= $this1.attr('data-id').split('#'); $tbl 	= $tmp[0]; $idname = $tmp[1]; $id  	= $tmp[2];  $attr 	= $tmp[3];
			$state = $this1.attr('data-state');
			//waiting...
			$this1.attr('src', 'images/loading.gif'); 
			$.post('ajax.php?module=changeStatusItem', {'tbl': $tbl, 'idname': $idname, 'id': $id, 'attr': $attr}, function(data){//alert(data);
				if($state==1){ $this1.attr('data-state', 0);$this1.attr('src', 'images/status-0.png');	$this1.attr('title', 'Unpublish'); }else{	$this1.attr('src',  'images/status-1.png'); $this1.attr('title', 'Publish'); $this1.attr('data-state', 1); }
			});
		}); 
		
		$('.priceFormat').priceFormat({
			clearPrefix: true,
			suffix: ' VNĐ',
			centsLimit: 0,
			centsSeparator: ',',
			thousandsSeparator: '.'
		}); 
		
		$('.txtFormatPhone').text(function(i, text) {  
			return text.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/, '$1-$2-$3');
		});
		
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.deleteAjx').click(function()
		{  
			$elem = $(this);   
			$attr = $elem.attr("data-id").split("#");
			if(confirm('(*)CẢNH BÁO: HÀNH ĐỘNG NÀY CÓ THỂ SẼ XÓA CÁC ĐỐI TƯỢNG CON ĐI KÈM(NẾU CÓ)...?'))
			{ 
				$.post( "ajax.php?module=removeItemRecord", {'tbl': $attr[0], 'idName': $attr[1], 'idValue': $attr[2]}, function(data) {
					if(data == 1) $elem.parent().parent().fadeOut();  else alert(data);	 
				}); 
			}
			
		});
		/*
		$('.editAjx').click(function(){
			//$elem = $(this);
			$(this).attr('contenteditable', 'true').css('background','yellow'); 
			$(this).blur(function() {
				if($(this).text() == ''){
					alert('(*)Type Text');	
				}
				else{
					//alert('done');	
					$(this).css('background','none'); 
				}
				e.preventDefault();
			}); 
			
		});
		*/
		//check maximum file upload 
		/*
		$('.maxFileListUpload').change(function(){
			$max = $(this).attr('data-id'); //alert($max);
			if($(this)[0].files.length > $max){
				alert('Maximum file: '+$max);
				$(this)[0].value = "";
			} 
		});
		*/
	});
</script> 
</head>
<body class="bg-sdt1">
<div class="container-fluid">
	<div class="container" style=" padding: 0px !important;">
		<table class="tbl_main" width="100%" cellpadding="0" cellspacing="0" border="1">
			<tr class="tr_header">
				<td valign="top" class="tdLogo">
					<div class="col-xs-6 col-sm-2 col-md-2 text-left logo"> 
						<img class="" src="<?=BASE_NAME.DIR_APP?>/logo.png" width="200" />
					</div> 
					<div class="col-xs-6 col-sm-3 col-md-3 txtLogo"> 
						<a class="head-title"  href="<?=BASE_NAME.DIR_APP?>"><?=ucfirst(LB_TITLE_HOME)?></a>
					</div>
					<div class="col-xs-12 col-sm-7 col-md-7"></div>
				</td>
			</tr>
			<tr class="tr_header">
				<td height="20" style="background-color:#218c8d">
					<div id="primary_nav_wrap">	
						<ul class="list-inline menuMain" style="margin-left:inherit">
							<?php
							//config 
							 $menu_sys = array(array('config', MENU_CONFIG),  array('func', MENU_MODULE),  array('tools', MENU_TOOLS),);  
							 $perm->loadMenuGroupFunc($_SESSION['id_group'], 'sys', $menu_sys, 'menu_sys', 'backend', MENU_CONFIG);
											
							//user
							 $menu_user = array(array('group', MENU_GROUP), array('user', MENU_USER), array('message', "tin nhắn"));
							 $perm->loadMenuGroupFunc($_SESSION['id_group'], 'user', $menu_user, 'menu_user', 'backend', MENU_USER);
							
							//content
							 $menu_content = array(array('category', MENU_CATALOG), array('article', MENU_ARTICLE));
							 $perm->loadMenuGroupFunc($_SESSION['id_group'], 'content', $menu_content, 'menu_content', 'backend', MENU_ARTICLE);

							//shop
							 $menu_shop = array(array('category', MENU_SHOP_CATALOG),  array('products', MENU_SHOP_PRODUCT), array('manuafact', MENU_SHOP_MANUAFACT), array('orders', MENU_SHOP_ORDER),); // 
							 $perm->loadMenuGroupFunc($_SESSION['id_group'], 'shop', $menu_shop, 'menu_shop', 'backend', MENU_SHOP_PRODUCT);
							 
							//location
							 $menu_location = array(array('location', MENU_LOCATION));
							 $perm->loadMenuGroupFunc($_SESSION['id_group'], 'location', $menu_location, 'menu_location', 'backend', MENU_LOCATION); 

							 //contact
							 $menu_contact = array( array('contact', MENU_CONTACT), array('message', MENU_MESSAGE), array('newsletter', MENU_NEWSLETTER),); // 
							 $perm->loadMenuGroupFunc($_SESSION['id_group'], 'contact', $menu_contact, 'menu_contact', 'backend', MENU_CONTACT);

							//media
							$menu_media = array(array('slide', MENU_SLIDE),  array('logo', MENU_LOGO),); // 
							$perm->loadMenuGroupFunc($_SESSION['id_group'], 'media', $menu_media, 'menu_media', 'backend', MENU_MEDIA);
 
							?>							 						 
						</ul>
						<ul class="list-inline text-right linktop " style="margin-bottom: 3px; padding-top: 6px;">
							<li class="btn bg-sdt2" ><a href="../index.php" target="_blank"><span class="glyphicon glyphicon-globe"></span>Site</a></li>
							<li class="btn bg-sdt2"><a href="index.php?p=user&q=user&m=edit&id=<?=$_SESSION['admin_id']; ?>" title="">[<?=$_SESSION['user']; ?>]</a></li>
							<li class="btn bg-sdt2"><a href="index.php?p=user&q=user&m=logout" title="<?=LB_LOGOUT?>"><?=LB_LOGOUT?></a>   </li>
							<li > 
								<form class="" name="frm_lang" id="frm_lang" action="<?= BASE_NAME.DIR_APP.'/index.php?'.$_SERVER['QUERY_STRING']?>" method="post">									
									<select style="font-size: 12px;" class="form-control" name="post_lang" id="post_lang" <?=($mod->method == 'edit' || $mod->method == 'add') ? ' disabled="disabled"':''?>>
									<?php  
										foreach($mod->languages as $lang):
											$selected = $lang['code'] == $_SESSION['dirlang'] ?  'selected="selected"' : '';
											echo '<option value="'.$lang['code'].'" '.$selected.'>'.$lang['name'].'</option>';
										endforeach; ?>	
									</select>
								</form>
							</li>                                				
						</ul>   

					</div>
				</td>
			</tr>		 
			<tr class="">
				<td valign="top">
					<div id="content"> 
						<?php   
						if($mod->module==''){										
							$mod->module = 'content';
							$mod->control = 'article';
						}	
						//permission
						$perm->checkPermissAccess($_SESSION['id_group'], $mod->module, $mod->control, 'backend');						
						$mod->controller(); ?>
					</div> 
				</td>
			</tr>
			<tr class="tr_footer">
				<td height="35" align="center">
					 © Hệ thống quản trị nội dung web. Được thiết kế &amp; phát triển bởi <a target="_blank" style="color:#fff" href="http://hdigital.vn">HDIGITAL</a>.  ® All rights reserved.
				</td>
			</tr>
		</table> 
	</div>
</div>
<script type="text/javascript">
$.tabs('#tabs a');
</script>
<?php
include("ckeditor/ckeditor.php");
include("ckfinder/ckfinder.php");
$CKEditor = new CKEditor();
$CKEditor->basePath = './ckeditor/';	
$CKEditor->config['height'] = 400;
$ckfinder = new CKFinder();
$ckfinder->BasePath = './ckfinder/';
CKFinder::SetupCKEditor($CKEditor, './ckfinder/');
//$CKEditor->replaceAll('editor');

$CKEditor->replace('editor0');	
$CKEditor->replace('editor1');	
$CKEditor->replace('editor2');	
$CKEditor->replace('editor3');	 
$CKEditor->replace('editor4');	
$CKEditor->replace('editor5');	
$CKEditor->replace('editor6');	
$CKEditor->replace('editor7');	 
$CKEditor->replace('editor8');	 

?>


<style>
#myNav{height:100%;width:0;position:fixed;z-index:9999;left:0;top:0;background:#000;overflow-x:hidden;transition:.5s}#myNav .overlay-content{position:relative;top:10%;width:100%;text-align:center;margin-top:30px}#myNav a{padding:8px;text-decoration:none;font-size:36px;color:#818181;display:block;transition:.3s}#myNav a:hover,.overlay a:focus{color:#f1f1f1}#myNav .closebtn{position:absolute;top:20px;right:45px;font-size:60px}@media screen and (max-height: 450px){#myNav a{font-size:20px}#myNav .closebtn{font-size:40px;top:15px;right:35px}}
</style>
<div id="myNav" class="overlay">  
  <a href="javascript:void(0)" class="closebtn btn btn-item-close" >&times;</a>  
  <div class="overlay-content"></div> 
</div> 
<script type="text/javascript">
	$( document ).ready(function() {  
		/* Close when someone clicks on the "x" symbol inside the overlay */
		$("body").on( "click", ".btn-item-close", function(e){ 
			$("#myNav").css('width',"0%");
		}); 
	}); 
</script>   
<script type="text/javascript">
	//limit media upload
	var file = document.getElementById('imageUpload');
	file.onchange = function(e){
		var ext = this.value.match(/\.([^\.]+)$/)[1];
		switch(ext)
		{
			case 'jpg':
			case 'JPG':
			case 'bmp':
			case 'BMP':
			case 'gif':
			case 'GIF':
			case 'png':
			case 'PNG':
			case 'tif':
				//alert('allowed');
				break;
			default:
				alert('not allowed');
				this.value='';
		}
	};	
</script>   

</body>
</html>
<?php 
} 
?>      
    