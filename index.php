<?php define('DIR_APP', 'TBL'); 
if (version_compare(PHP_VERSION, '5.4.0') <= 0) {
    exit('The Website requires PHP version 5.4 or higher.');
}
error_reporting(0);
session_start(); 
if(isset($_GET['lang']))
	$_SESSION['dirlang'] = $_GET['lang'];
elseif(!isset($_SESSION['dirlang']) || $_SESSION['dirlang']=='')
	$_SESSION['dirlang'] = 'vn'; 
include('config.php'); 
include('lib/database.php');
include('lib/validate.php');
include('lib/module.php');
include('lib/pagingFront.php');
include('lib/function.php');
include('lib/func_extend.php');
include('lib/PA.smtp.php');
include('lib/db.info.php');
include('lib/db.shop.php');
include('lib/db.location.php');
include('lib/db.user.php');
include('lib/Json.Class.php');
include('lib/usersOnline.class.php');
$json = new JsonData;
$db = new Database;
$db->connect($dbhost, $dbuser, $dbpass, $dbname);
$contact = $db->loadObject('SELECT * FROM #__contact WHERE publish = 1');
//$langExt = $db->loadObjectList('SELECT code, title FROM #__language_extend');

$mod = new Module;
$mod->lang('index'); 
$mod->getPage();
if($mod->config['activeSite']==0){viewError();exit('');}		
$cShop = getCategoryShop(0, '', ''); 
$cNews = getCategoryInfo('', '', ''); //only news
$cLocation = getCategoryLocation(0, '', '');  
 
if(!empty($_SESSION['id_user_frontend'])){
	$account = loadUserFrontend("u.*", $_SESSION['id_user_frontend'], ' AND u.publish = 1'); 
	$account = $account['row'];
}

$buffer = @ob_get_contents();
@ob_end_clean();
@ob_start('ob_gzhandler');
print $buffer; 
?>  
<!DOCTYPE html>
<html lang="en">
<head>
<base href="<?=BASE_NAME?>" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="robots" content="index, follow" />
<meta name="Googlebot" content="index" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="<?= $mod->meta_keywords?>" />
<meta name="description" content="<?= $mod->meta_description?>" />
<meta property="og:title" content="<?=$mod->meta_title?>" />
<meta property="og:image" content="<?=$mod->meta_fbimage!=''? $mod->meta_fbimage : URL_UPLOAD.$contact['image']?>" />
<meta property="og:url" content="<?=$mod->curPageURL()?>" />
<meta property="og:site_name" content="<?=$json->getDataJson1D($contact['name'], $_SESSION['dirlang'])?>" />
<meta property="og:description" content=" <?=$mod->meta_description?>" />

<meta property="fb:app_id" content="<?=$mod->config['facebookAppID']?>" />
<meta property="fb:admins" content="100001272738872"/> 

<title><?=$mod->meta_title?></title>
<link rel="shortcut icon"  href="<?=TEMPLATE?>images/favicon.png" type="image/x-icon"/>
<link rel="canonical" href="<?=$mod->curPageURL()?>" />
<!--
<link href="<?=TEMPLATE?>webfonts/UTM/styles.css" rel="stylesheet">
<link href="<?=TEMPLATE?>webfonts/UTM-Bold/styles.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed" rel="stylesheet">
-->
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
<style>
body{font-family: 'Roboto', sans-serif  !important;}
</style>

<script src="<?=TEMPLATE?>js/jquery.min.1.11.3.js"></script> 
<script src="<?=TEMPLATE?>bootstrap/bootstrap.min.js"></script>
<link href="<?=TEMPLATE?>bootstrap/bootstrap.min.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="<?=TEMPLATE?>bootstrap/html5shiv.min.js"></script>
      <script src="<?=TEMPLATE?>bootstrap/respond.min.js"></script>
<![endif]-->
<script src="<?=TEMPLATE?>bootstrap/validator.min.js"></script>
<link href="<?=TEMPLATE?>js/mmenu/jquery.mmenu.all.css" rel="stylesheet">
<script src="<?=TEMPLATE?>js/mmenu/jquery.mmenu.all.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {
	// Only loads mmenu if less than 768 px
	if (parseInt(jQuery(window).width()) < 667) {
		// Initializes mmenu
		$('#navbar').mmenu({
			slidingSubmenus: false
		}); 
		// Rewires the default bootstrap hamburger to point to mmenu.
		$(".navbar-header button").removeAttr("data-toggle data-target").removeClass('collapsed').wrap( "<a href='#navbar'></a>" );
		// Pulls removes classes for dropdown menus/submenus
		// TODO: toggle classes instead of remove to make development easier
		$("#navbar li.dropdown").removeClass('dropdown');
		$("#navbar ul.dropdown-menu").removeClass('dropdown-menu');
		$("#navbar .caret").toggleClass('caret');
	}
});
</script>
<link href="<?=TEMPLATE?>css/main.css" rel="stylesheet">
<link href="<?=TEMPLATE?>css/bootstrap.extend.css" rel="stylesheet">
<link href="<?=TEMPLATE?>css/effect.css" rel="stylesheet">
<link href="<?=TEMPLATE?>css/hover-min.css" rel="stylesheet">
<script src="<?=TEMPLATE?>js/jquery.price_format.2.0.min.js"></script>  
<script src="<?=TEMPLATE?>js/global.js"></script>
<script src="<?=BASE_NAME?>js/global.js"></script>
<link href="<?=TEMPLATE?>font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
<link href="<?=TEMPLATE?>css/bootstrap-social.circle.css" rel="stylesheet">
<script src='<?=TEMPLATE?>js/jquery.elevatezoom.js'></script>
<script src="<?=TEMPLATE?>js/Sticky-Anything/jq-sticky-anything.min.js"></script>
<script>
	$( document ).ready(function() {
		$('.side-menu').stickThis({
			top:            0,		    // top position of sticky element, measured from 'ceiling'
			minscreenwidth: 0,		    // element will not be sticky when viewport width smaller than this
			maxscreenwidth: 999999,		// element will not be sticky when viewport width larger than this 
			zindex:         1,		    // z-index value of sticky element
			debugmode:      false,      // when true, errors will be logged to console
			pushup:         ''          // another (unique) element on the page that will 'push up' the sticky element
		});
	});
</script>

<style>
/* Base Color */
.bg-sdt1{ background-color:<?=$mod->config['colorMain1']?> !important; color: #fff !important; } .clr-sdt1{ color:<?=$mod->config['colorMain1']?> !important}
.bg-sdt2{ background-color:<?=$mod->config['colorMain2']?> !important;  color:#fff !important}.clr-sdt2{ color:<?=$mod->config['colorMain2']?> !important}
.bg-sdt3{ background-color:<?=$mod->config['colorMain3']?> !important; color: #fff !important}.clr-sdt3{ color:<?=$mod->config['colorMain3']?> !important}
.bg-sdt4{ background-color:<?=$mod->config['colorMain4']?>; color:#000}.clr-sdt4{ color:<?=$mod->config['colorMain4']?> }
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6{ /* font-weight:bold */}
a:focus, a:hover{ color: inherit}
.boxShadowNice{ box-shadow: 0px 0px 19px 1px rgba(0, 0, 0, 0.08);}
	 
.carousel-indicators li{ margin:0 1px !important; background-color:<?=$mod->config['colorMain1']?> !important; border:none !important}
.carousel-indicators .active{ background-color:<?=$mod->config['colorMain2']?> !important; border:none !important}

.btn{border-radius:0}
.btn:hover {/* box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); */}
.priceFormat{ color:<?=$mod->config['colorMain1']?>; font-weight: bold}

.carousel-fade .carousel-inner .item {-webkit-transition-property: opacity;  transition-property: opacity;}
.carousel-fade .carousel-inner .item,.carousel-fade .carousel-inner .active.left,.carousel-fade .carousel-inner .active.right {  opacity: 0;}
.carousel-fade .carousel-inner .active, .carousel-fade .carousel-inner .next.left, .carousel-fade .carousel-inner .prev.right {  opacity: 1;}
.carousel-fade .carousel-inner .next,.carousel-fade .carousel-inner .prev,.carousel-fade .carousel-inner .active.left,.carousel-fade .carousel-inner .active.right {  left: 0;  -webkit-transform: translate3d(0, 0, 0);          transform: translate3d(0, 0, 0);}
.carousel-fade .carousel-control {  z-index: 2;} 

.mfp-close{    border-radius: 50%;    font-size: 15px !important;    padding-right: 0 !important;    margin-right: -20px;}

.img-effect:hover .img-class:before{	opacity: 0.35;    visibility: visible;    transform: scale(1) rotateY(0deg);    -webkit-transform: scale(1) rotateY(0deg);    -moz-transform: scale(1) rotateY(0deg);}
.img-effect .img-class:before{	position: absolute;    content: "";    width: 100%;    height: 100%;    visibility: hidden;    left: 0;    top: 0;    opacity: 0;    background: url(../images/heo2.png) no-repeat center center #222222;    transform: scale(0.5) rotateY(180deg);    -webkit-transform: scale(0.5) rotateY(180deg);    -moz-transform: scale(0.5) rotateY(180deg);    transition: 0.4s;    -moz-transition: 0.4s;    -webkit-transition: 0.4s;    z-index: 99;}	
.txtPrice{color:red; font-weight:bold}
.bxShadow{ box-shadow: 0px 0px 19px 1px rgba(0, 0, 0, 0.08); }
.slick-slide img{margin:auto}
.footer *, .side-footer-txt *{ color:#fff}
.footer .list-group{ text-transform:uppercase; font-size:14px}

.footer .social-network li{border-radius: 50%; padding-top:8px; padding-bottom:8px; background:<?=$mod->config['colorMain1']?>}
.discountPrice{color:#ccc !important}
.caption >h5{ font-weight:bold}

.icoSpec {
    position: absolute;
    z-index: 1;
    color: red;
    right: 10px;
    font-size: 64px;
}
.icoSpec label {
    left: 30%;
    position: absolute;
    color: #fff;
    top: 35%;
    font-size: 15px;
}

/* Responsive Mobile */
@media only screen and (min-width: 768px) {	
	.container{max-width: 1170px;}
	 
	.side-breadcrumb +.container-fluid .container{min-height:300px}
	#carousel-example-generic1 .carousel-control .fa{top:40%;     position: absolute;     font-size: 64px;  }

	/*.side-head > div > div:nth-child(1), .side-head > div > div:nth-child(2){ margin-top:20px;}*/
	
	.category-home{  position: relative; padding: 2px 15px 3px; background:#FFF; /*box-shadow: 2px 3px 5px #ddd;*/}
	.category-home > .list-group-item{padding:3px; border-radius:0}
	.category-home > .list-group-item > h5{margin:3px auto; text-transform: uppercase; font-size: 13px;}
	.category-home > .list-group-item > h5 img{ height:20px; width:20px}
	.category-home > .list-group-item .dropdown-menu{border: 1px solid #ccc; width:688px; height:310px;  margin-left:
            -7px; overflow: hidden;}
	.category-home > .list-group-item .dropdown-menu .col-md-3{padding: 3px 5px;}
	.category-home > .list-group-item .dropdown-menu .panel-title{color:<?=$mod->config['colorMain1']?>;     min-height: 30px; font-weight:bold; text-transform: uppercase; font-size: 14px; margin-bottom: 5px;}
	.category-home > .list-group-item .dropdown-menu .list-group-item{ padding: 5px;   padding-left:0;  font-size:12px  }
	
	.c-product-home >.container >.panel >.panel-heading{padding:0}
	.c-product-home .p-category-home .list-group{ border:1px solid #ccc; height:213px}
	.c-product-home .p-category-home .list-group-item{ border:0; padding: 5px; border-radius:0}
	.c-product-home .p-category-home .list-group-item h5{margin: 3px auto; }
	.c-product-home  p{margin-bottom:0}
	
	.category-menu .dropdown-menu{ min-width:260px; margin-top: 5px !important}
	.category-menu .dropdown-menu>li:first-child{ border-radius:0}
	.category-menu .dropdown-menu .list-group-item{ padding:5px}
	.category-menu .dropdown-menu .list-group-item >h5{margin:4px auto}
	.category-menu .dropdown-menu > .list-group-item .dropdown-menu{border: 1px solid #ccc; width:800px; height:500px;  margin-left: 1px;}
	.category-menu .dropdown-menu > .list-group-item .dropdown-menu .col-md-3{padding: 5px;}
	.category-menu .dropdown-menu > .list-group-item .dropdown-menu .panel-title{color:<?=$mod->config['colorMain1']?>;     min-height: 30px; font-weight:bold; text-transform: uppercase; font-size: 14px; margin-bottom: 5px;}
	.category-menu .dropdown-menu > .list-group-item .dropdown-menu .list-group-item{ padding: 5px;   padding-left:0;  font-size:12px  }
	
	.category-menu .dropdown-menu a{color:#000 !important}
	
	.footer > div{padding:2px}
	.footer > div > div{padding:2px}
	
	.menu-li-right{width: 70%;}
}
@media only screen and (min-width: 992px)  and (max-width: 1024px)  {
	.container{min-width:960px}
	.navbar-default .navbar-nav>li>a, .navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand{  padding:15px 8px; }

}
@media only screen and (min-width: 768px)  and (max-width: 768px) {
	.navbar-default .navbar-nav>li>a{  padding:15px 10px; font-size:13px } 
 
} 
 
@media only screen and (max-width: 768px) {
	.modal-backdrop{display:none}
	.side-head .container >div:first-child{ text-align:center}
	.mm-vertical{background-color: <?=$mod->config['colorMain2']?> !important}
	.navbar-toggle .icon-bar{background-color: #fff !important}
	.slick-slide img{margin:auto}
	
	#carousel-example-generic1 .wow img{height:inherit !important}
	
	.c-product-home .item-product >div:first-child img{ height:100px  !important}
	.c-product-home .item-product .caption .btn-home{ width:90%; float:right}
}
</style>
<?= base64_decode($mod->config['chatboxZopim'])?>
<?php
if($mod->config['googleAnalyticsID'] !=''):?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', '<?= $mod->config['googleAnalyticsID']?>', 'auto');
  ga('send', 'pageview');
</script>
<?php
endif?>
<script>
$( document ).ready(function() {
	//on close remove
	$('#youtubeModal').on('hidden.bs.modal', function () {
	   $('#youtubeModal .modal-body').empty().html('<div id="videoModalContainer"></div>');
	});
	$(document).ready(function() {setTimeout(function(){$("#pre-loader").fadeOut(1000);},500);});
});
</script> 

<script>
	$(document).ready(function() {
		$('.category-home > li').each(function(index){
			if(index>0)
			{
				$pos = (index*50)-6;
				if(index > 1)
					$pos = $pos - index*7+7;
				
				$(this).children('.dropdown-menu').css('margin-top', '-'+$pos+'px');
			}
		});
	});
</script>

</head> 
<body id="wrap">

<?php
if($mod->config['facebookAppID'] !=''):?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=<?=$mod->config['facebookAppID']?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> 
<?php
endif?>

<div class="navbar-default navbar-header bg-sdt1 navbar-static-top" style="color:#fff; width:100%">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand hidden" style="color:#fff" href="#navbar"> MENU</a>
</div> 
<!--
<div class="container-fluid side-top hidden-mobile" style="height:65px; border-bottom: 1px solid #999;">
	<div class="container"> 
		<div class="col-md-4"> 
			<ul class="list-inline" style="font-size: 16px;">
				<li><img src="<?=TEMPLATE?>images/top-bar.png" /></li>
			</ul> 
		</div>
		<div class="col-md-5">
			 
		</div>
		<div class="col-md-3" style="padding: 10px;"> 

		</div> 
	</div>  	
</div>
-->
<div class="container-fluid side-head" style="padding-top:15px; padding-bottom:15px">	 
	<div class="container">    	 
        <div class="col-md-3 text-center">  		
			<a href="./" title="<?=$json->getDataJson1D($contact['name'], $_SESSION['dirlang'])?>"><img class="logo" src="<?=URL_UPLOAD.$contact['image']?>" alt="logo" title="<?=$json->getDataJson1D($contact['name'], $_SESSION['dirlang'])?>" height="100px;"/></a>
        </div>  
		<div class="col-md-9"> 
			<div class="col-md-10 form-search">
				<form class="navbar-form from-Search" role="search" method="post" action="<?=LINK_SHOP_SEARCH?>" style="margin:inherit; padding-right:0; margin-top:3px">
					<div class="input-group" style="width:100%">					 
						<input style="box-shadow:none" class="form-control keyword" name="keyword" placeholder="<?=LB_SEARCH?>..." required />
						<!--
						<div class="input-group-addon" style="width:100px"> 
							<select name="categorySearch" id="categorySearch" style="width:100%    width: 100%;    border: 0;    padding: 0;    height: 30px;" class="form-control">
								<option value="">Tất cả</option>
								<?php  
								foreach($cShop as $cat):
									if($cat[5]==0)
										echo '<option value="'.$cat[0].'">'.$cat[1].'</option>';						 							
								endforeach; 
								?>
							</select> 
						</div>
						-->
						<span class="input-group-btn">
							<button class="btn bg-sdt1"><span class="glyphicon glyphicon-search"></span></button>
						</span>
					</div>
				</form>	 	
			</div>
			<div class="col-md-2 view-cart">
				<a href="<?=LINK_SHOP_CART?>"><i style="font-size:25px" class="fa fa-cart-plus clr-sdt2" aria-hidden="true"></i> (<?=count($_SESSION['cart'])?>) GIỎ HÀNG </a>
			</div> 			
		</div>
		<!--
		<div class="col-md-3 text-center hidden-mobile">
			<div class="col-md-2" style="padding:0">
				<img class="" src="<?=TEMPLATE?>images/icon-phone.png" alt="..." title="" /> 
			</div>
			<div class="col-md-10 text-left text-uppercase" style="line-height:20px">
				<h5>Hỗ trợ khách hàng 24/7<br/>
					<a href="tel:<?=filter_var($contact['tel'], FILTER_SANITIZE_NUMBER_INT)?>"> <?=$contact['tel']?></a>
				</h5>
			</div>
		</div>
		-->
	</div>  
</div>

<div class="container-fluid side-head header">
	<div class="container">    	 

			<nav id="navbar-main" class="navbar navbar-default navbar-static-top" style="">
				<div>
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						<span class="navbar-brand hidden" href="./">
                            <a href="/products/mparent.html">
                                <img class="btn-home" src="<?php echo TEMPLATE . 'images/btn-home.jpg' ?>" />
                            </a>
                            <?=MENU_HOME?>
                        </span>
					</div>
		
					<div id="navbar" class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li class=""><a href="./" title="<?=MENU_HOME?>"><span class="glyphicon glyphicon-home hidden"></span> <?=MENU_HOME?></a></li>
                            <li class="dropdown" class="">
                                <a class="dropdown-toggle" role="button" aria-haspopup="true"  aria-expanded="false">
                                    <?=MENU_brand?><span class="caret"></span></a>
                                <ul class="dropdown-menu bg-sdt1">
                                <?php
                                global $json;
                                $brand = loadListManuafact();
                                foreach ($brand['rows'] as $value){
                                    $brandlink = LINK_SHOP_MANUFACT_ITEM.$value['alias'].'.html';
                                    $brandlname = $json->getDataJson1D($value['name'], $_SESSION['dirlang']);
                                    echo'<li><a href="'.$brandlink.'">'.$brandlname.'</a></li>';
                                }
                                ?>
                                </ul>
                            </li>
							<?php
							foreach($cNews as $value1):
								if($value1[3] == 1 && $value1[5] == 69):

									$link1 = ($value1[7] != '') ? $value1[7] : LINK_INFO_LIST.$value1[4].'.html';
									$title1 = $value1[1];

									$rows = loadListInfo('', " AND c.publish = 1 AND c.id_cat = ".$value1[0])['rows'];
									if(count($rows)==1)
									{
										$link1  = ($rows[0]['link'] != '')? $rows[0]['link'] : LINK_INFO_ITEM.$rows[0]['alias'].'.html';
										 echo '<li class=""><a href="'.$link1.'" title=""> '.$title1.'</a></li>';
									}
									else
									{

										$cNews2 = getCategoryInfo($value1[0], '', '');
										if(count($cNews2)>0)
										{	?>
											<li class="dropdown">
												<a class="dropdown-toggle" role="button" aria-haspopup="true"  aria-expanded="false"> <?=$title1?><span class="caret"></span></a>
												<ul class="dropdown-menu bg-sdt1">
												<?php
												foreach($cNews2 as $value2):
													if($value2[3] == 1 && $value2[5] == $value1[0]):
														$link3  = ($value2[7] != '') ? $value2[7] : LINK_INFO_LIST.$value2[4].'.html';
														$cNews3 = getCategoryInfo($value2[0], '', '');
														if(count($cNews3)>0){
														?>
														<li class="dropdown-submenu">
															<a class="dropdown-toggle" href="<?=$link3?>"> <?=$value2[1]?></a>
															<ul class="dropdown-menu bg-sdt1">
																<?php
																foreach($cNews3 as $value3):
																	$link4  = ($value3[7] != '') ? $value3[7] : LINK_INFO_LIST.$value3[4].'.html';
																	echo '<li><a href="'.$link4.'"> '.$value3[1].'</a></li>';
																endforeach;
																?>
															</ul>
														</li>
														<?php
														}else
															echo '<li><a href="'.$link3.'"> '.$value2[1].'</a></li>';
													endif;
												endforeach; ?>
												</ul>
											</li>
											<?php
										}
										else
											echo '<li><a class="" href="'.$link1.'" title=""> '.$title1.'</a></li>';
									}

								endif;
							endforeach;
							?>

							<li><a href="<?=LINK_CONTACT?>" title="<?=MENU_CONTACT?>"> <?=MENU_CONTACT?></a></li>
						</ul>
					</div>
					<!-- /.navbar-collapse --> 
				</div>
			</nav>   	
	</div>  
</div> 

<?php
	if($mod->module ==''){
		$mod->load('shop', 'products', 'home');
	}else{	?>
		<div class="container-fluid side-breadcrumb">
			<div class="container" style=""> 
				<ol class="breadcrumb" style="background:none; margin-bottom:0">
					<?=$mod->breadcrumb?>
				</ol> 
			</div>	 
		</div> 
		<?php		
		$mod->controller();   
	}
?> 
 
<div class="container-fluid side-footer bg-sdt1"> 
	<div class="container footer-info">	
		<footer class="footer">
			<div class="col-md-6">
				<div class="col-md-6">
					<?php
					foreach($cNews as $key => $value): 
					if($value[0] == 145):
						$cListID = getCategoryInfo($value[0], '', '');
						$cList 	 = categoryToArray($cListID);
						$cList[] = $value[0];  ?> 
						<h3><?=$value[1]?></h3>
						<ul class="list-group">
							<?php  
							$sqlExt = " AND c.publish = 1 AND c.id_cat IN (".implode(',', $cList).")"; 
							$rows = loadListInfo('', $sqlExt, '')['rows']; 
							foreach($rows as $key => $row):  
								$link = LINK_INFO_ITEM.$row['alias'].'.html';
								$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);   
								if($row['title']): ?>
									<li><a href="<?=$link?>"> <?=$title?></a></li>
								<?php
								endif;							
							endforeach; 
							?>	
						</ul>
						<?php
					endif;
					endforeach;
					?>
				</div>	
				<div class="col-md-6">
					<?php
					foreach($cNews as $key => $value): 
					if($value[0] == 43):
						$cListID = getCategoryInfo($value[0], '', '');
						$cList 	 = categoryToArray($cListID);
						$cList[] = $value[0];   ?> 
						<h3><?=$value[1]?></h3>
						<ul class="list-group">
							<?php  
							$sqlExt = " AND c.publish = 1 AND c.id_cat IN (".implode(',', $cList).")"; 
							$rows = loadListInfo('', $sqlExt, '')['rows']; 
							foreach($rows as $key => $row):  
								$link = LINK_INFO_ITEM.$row['alias'].'.html';
								$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);   
								if($row['title']): ?>
									<li><a href="<?=$link?>"> <?=$title?></a></li>
								<?php
								endif;							
							endforeach; 
							?>	
						</ul>
						<?php
					endif;
					endforeach;
					?>
				</div>
			</div>				
			<div class="col-md-6">
				<div class="col-md-4">
					<?php
					foreach($cNews as $key => $value): 
					if($value[0] == 53):
						$cListID = getCategoryInfo($value[0], '', '');
						$cList 	 = categoryToArray($cListID);
						$cList[] = $value[0];   ?> 
						<h3><?=$value[1]?></h3>
						<ul class="list-group">
							<?php  
							$sqlExt = " AND c.publish = 1 AND c.id_cat IN (".implode(',', $cList).")"; 
							$rows = loadListInfo('', $sqlExt, '')['rows']; 
							foreach($rows as $key => $row):  
								$link = LINK_INFO_ITEM.$row['alias'].'.html';
								$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);   
								if($row['title']): ?>
									<li><a href="<?=$link?>"> <?=$title?></a></li>
								<?php
								endif;							
							endforeach; 
							?>	
						</ul>
						<?php
					endif;
					endforeach;
					?>
				</div>
				<div class="col-md-4">
					<h3>KẾT NỐI</h3>
					<ul class="list-inline social-network social-circle">
						<li><a href="<?=$contact['linkFb']?>" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li><a href="<?=$contact['linkGg']?>" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
						<li><a href="<?=$contact['linkTwitter ']?>" class="icoTwitter " title="Twiter"><i class="fa fa-twitter"></i></a></li>
					</ul>
				</div>
				<div class="col-md-4">			
					<h3>Địa chỉ văn phòng</h3>
					<ul class=" list-unstyled">
						<li><a href="tel:<?=filter_var($contact['tel'], FILTER_SANITIZE_NUMBER_INT)?>"><i class="fa fa-phone clr-sdt4"></i> <?=$contact['tel']?></a></li>
						<li><i class="fa fa-map-marker clr-sdt4"></i> <?=$json->getDataJson1D($contact['address'], $_SESSION['dirlang'])?></li>
						<li><a href="mailto:<?=$contact['email']?>"><i class="fa fa-envelope clr-sdt4"></i> <?=$contact['email']?></a></li>
					</ul>  					
				</div>
			</div>
        </footer>		 
	</div> 
</div> 
 
<div class="container-fluid side-footer-txt bg-sdt1">
	<div class="container text-center">	
		<div>
			Copyright @ 2017 <?=$json->getDataJson1D($contact['name'], $_SESSION['dirlang'])?>. All Rights Reserved - 
			Design By <a style="color:#fff" href="http://hdigital.vn">www.hdigital.vn</a>
		</div>
	</div>	
</div> 

<!-- Trigger the modal with a button -->
<!-- Modal -->
<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog"> 
    <div class="modal-content"></div>
  </div>
</div>

<script>$('.carousel').carousel({interval: 3000})</script>		

<link href="<?=TEMPLATE?>js/animate/animate.min.css" rel="stylesheet">
<link href="<?=TEMPLATE?>js/animate/animate.customer.css" rel="stylesheet">
<script src="<?=TEMPLATE?>js/animate/animate.effect.js" type="text/javascript"></script>

<!-- side-->
<link href="<?=TEMPLATE?>js/jssorSlider/slider.css" rel="stylesheet">
<script type="text/javascript" src="<?=TEMPLATE?>js/jssorSlider/jssor.slider.mini.js"></script>
<!-- use jssor.slider.debug.js instead for debug -->
<!--<script type="text/javascript" src="<?=TEMPLATE?>js/jssorSlider/jssor.slider.js"></script>-->
  
<div class="footer"><a class="btn-top" href="javascript:void(0);" title="Top" style="display: inline;"><span class="fa fa-angle-double-up bg-sdt1" style="font-size:30px; padding:5px; color:#fff"></span></a> </div>
<script>
	jQuery(document).ready(function($){ 	
		if($(".btn-top").length > 0){
			$(window).scroll(function () { var e = $(window).scrollTop(); if (e > 300) {$(".btn-top").show()} else {$(".btn-top").hide()} });
			$(".btn-top").click(function () {$('body,html').animate({scrollTop: 0})})
		}		
	});
</script>
<style>.btn-top { border: medium none;    bottom: 20px;    cursor: pointer;    display: none;    height: 50px;    outline: medium none;    padding: 0;    position: fixed;    right: 20px;    width: 50px;    z-index: 9999;}</style> 

<script> 
	if ( $(window).width() > 768) 
	{   
		$('.fadeElem').css('opacity','0');
		
		$(window).on("load",function() {
		  $(window).scroll(function() {
			$(".fadeElem").each(function() {
			  /* Check the location of each desired element */
			  var objectBottom = $(this).offset().top + $(this).outerHeight();
			  var windowBottom = $(window).scrollTop() + $(window).innerHeight();
			  
			  /* If the element is completely within bounds of the window, fade it in */
			  if (objectBottom < windowBottom) { //object comes into view (scrolling down)
				if ($(this).css("opacity")==0) 
				{
					$(this).fadeTo(300,1);
					$(this).find('.zoomElementInit').addClass('zoomElement'); 				  
				}
				
			  } else { //object goes out of view (scrolling up)
				/* 
				if ($(this).css("opacity")==1) {
					$(this).fadeTo(300,0);
					$(this).find('.zoomElementInit').removeClass('zoomElement'); 
					
				} 
				*/
			  }
			});
		  }); $(window).scroll(); //invoke scroll-handler on page-load
		});	
		
	} 
	else
	{
		
		//alert('Add your javascript for small screens here ');
		$(".fadeElem").show(); 
		$(".zoomElementInit").removeClass('zoomElementInit'); 
		
		//$(".dropdown-submenu").removeClass('dropdown-submenu').addClass('dropdown');
	}		

</script> 
<?= base64_decode($mod->config['chatboxFB'])?>

<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>js/slick-slide/slick.css">
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>js/slick-slide/slick-theme.css">
<script src="<?=TEMPLATE?>js/slick-slide/slick.js" type="text/javascript" charset="utf-8"></script> 
<style>
.slick-dots li{ margin:0; }
.slick-dots li button::before{font-size:21px}
.slick-dots li.slick-active button::before{color:<?=$mod->config['colorMain1']?>}
.slick-dots li button::before { font-size: 11px;}
.slick-arrow::before{color:<?=$mod->config['colorMain1']?>} 
</style>

<!-- wow-->
<script type="text/javascript" src="<?=TEMPLATE?>js/wow/wow.min.js"></script>  
<script>
wow = new WOW(
                    {
                      boxClass:     'wow',      // default
                      animateClass: 'animated', // default
                      offset:       0,          // default
                      mobile:       true,       // default
                      live:         true        // default
                    }
            )
wow.init(); 
</script>
<!--
<div class="promotion-fixed hidden-mobile">
<div class="promotion-left">
<span style="font-size: 10pt;"> </span>
<p class="title-pr"><span style="font-size: 16px;">HOT LINE</span></p>
<ul class="list-promostion">
<li><span style="font-size: 16px;><a href="tel:<?=filter_var($contact['tel'], FILTER_SANITIZE_NUMBER_INT)?>">
</a><a href="tel:<?=filter_var($contact['tel'], FILTER_SANITIZE_NUMBER_INT)?>"><?=filter_var($contact['tel'], FILTER_SANITIZE_NUMBER_INT)?></a></span></li>
</ul>
<div class="clear"><span style="font-size: 10pt; font-family: 'times new roman', times, serif;"> </span></div>
<p class="title-pr" style="margin-top: 23px;"><span style="font-size: 16px;">EMAIL</span></p>
<ul class="calender">
<li><span style="font-size: 16px;"><a href="mailto:<?=$contact['email']?>" target="_blank"><span style=""><?=$contact['email']?></span></a>
</span>
</li>
</ul>
</div>
</div>
-->

<?php
if($mod->method !== 'menuParent' && $mod->method !=='menuChild') {
?>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5ad409e2227d3d7edc23f4c8/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <?php
}
?>
<!--End of Tawk.to Script-->

</body>
</html>