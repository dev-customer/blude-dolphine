<?php
$dbhost   = "localhost";
$dbname   = "bluedavu_data";
$dbuser   = "bluedavu_user";
$dbpass   = "zr482HJD]GHm";
define('BASE_NAME', 'http://'.$_SERVER['HTTP_HOST'].'/');

define('SMTP_HOST','mail.domain.com'); //Dia chi mail server
define('ADMIN_EMAIL','info@domain.com'); //User duoc khai bao tren mail server
define('SMTP_USERNAME','info@domain.com'); //User duoc khai bao tren mail server
define('SMTP_PASSWORD','info123'); //Pass cua email nay

$folderLocal   = "dfl";
$dbprefix = "tbl_";
//define('LANGS', 0); 
define('PAGE_ROWS',10);
define('CUR_ROWS',2);

define('BASE_ADMIN', BASE_NAME.'/'.DIR_APP);
define('TEMPLATE', BASE_NAME.'templates/default/');

//Config Link 
define('LINK_CONTACT',   BASE_NAME.'contact.html');

define('LINK_USER_REG', BASE_NAME.'user/register.html'); 
define('LINK_USER_LOGIN', BASE_NAME.'user/login.html'); 
define('LINK_USER_LOGOUT', BASE_NAME.'user/logout.html'); 
define('LINK_USER_ACCOUNT', BASE_NAME.'user/account.html'); 
define('LINK_USER_ACCOUNT_RESET', BASE_NAME.'user/reset-pwd.html');  
  
define('LINK_INFO_LIST', BASE_NAME.'category-info/');
define('LINK_INFO_ALL',  BASE_NAME.'tin-tuc.html');
define('LINK_INFO_ITEM', BASE_NAME.'detail/'); 

define('LINK_SHOP_SEARCH', BASE_NAME.'search-products.html');
define('LINK_SHOP_LIST', BASE_NAME.'category-products/');
define('LINK_SHOP_ALL',  BASE_NAME.'products.html');
define('LINK_SHOP_ITEM', BASE_NAME.'product/');
define('LINK_SHOP_CART', BASE_NAME.'products/cart.html');
define('LINK_SHOP_CART_PAYMENT', BASE_NAME.'products/payment.html');
define('LINK_SHOP_MANUFACT_ITEM', BASE_NAME.'manuafact/');

$mod_rewrite = true;
//$arrPath = explode('/', @$_GET['p']);
//define('PATH_CLASS_MODEL','modules/'.$arrPath[0].'/model/');
define('PATH_CAPTCHA_PHOTO','lib/captcha/');;
define("DEBUG",1);
$secret = false;

define('DIR_UPLOAD','slave');
define('URL_UPLOAD', BASE_NAME.DIR_UPLOAD.'/');
/* 
define('DEFAULT_MOD_ADM', 'content');
define('DEFAULT_MOD_FRONT', 'content');
define('DEFAULT_CTRL_ADM', 'content');
define('DEFAULT_CTRL_FRONT', 'content');
 */

 
?>