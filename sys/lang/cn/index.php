<?php if(!defined('DIR_APP')) die('Your have not permission'); 
define('LB_LANGUAGE', 				' Language');
define('LANG_EN', 				' English');
define('LANG_VN', 				' Vietname');
define('LB_TITLE_HOME', 				' System Manager');
define('LANG_ENDABLE', 	'Endable');
define('LB_ON', 				'On');
define('LB_OFF', 				'Off');

//MENU: Top Right
define('LB_ACCOUNT',				'Account');	
define('LB_LOGOUT',					'Logout');	
define('LB_FONTEND',				'Site');	

//MENU: Module
define('MENU_MANAGE', 	 	'manage');
define('MENU_CONFIG', 	 	'config');
define('MENU_CATALOG', 		'Category');	
define('MENU_CONTENT', 	 	'content');
define('MENU_NEWSLETTER', 		'Newslleter');	
define('MENU_SHOP_CATALOG', 		'Category');	
define('MENU_SHOP_PRODUCT', 		'product');	
define('MENU_SHOP_ORDER', 		'Order');	
define('MENU_SHOP_MANUAFACT', 		'Manuafact');	
define('MENU_SHOP_IMAGE', 		'image');	
define('MENU_USER', 		'user');	
define('MENU_LOCAL', 	'location');	
define('MENU_LANGUAGE', 		'language');	
define('MENU_COMMENT', 	'comment');	
define('MENU_GROUP', 	'group');	
define('MENU_ARTICLE',			'content');
define('MENU_CONTACT',		'contact');
define('MENU_MESSAGE',		'mail');
define('MENU_NESLETTER',		'Newsletter');
define('MENU_PERMISION',		'permission');
define('MENU_MEDIA',		'Media');
define('MENU_SLIDE',		'Slide');
define('MENU_LOGO','Partner');
define('MENU_GALLERY','Gallery');
define('MENU_TOOLS','Tools');

//Action
define('LANG_FILTER',					'Filter');
define('LANG_VIEW', 					'View');
define('LANG_ADD', 						'Add');
define('LANG_DUPLICATE', 				'Copy');
define('LANG_EDIT', 					'Edit');
define('LANG_DELETE', 					'Delete');
define('LANG_INSERT', 					'Insert');
define('LANG_SAVE', 					'Save');
define('LANG_CANCEL', 					'Cancle');
define('LANG_HELP', 					'Help');
define('LANG_UPDATE', 					'Update');
define('LANG_HOT', 					'HOT');

//JS
define('LANG_JS_NUMBER', 				'(*)only number');
define('LANG_JS_ALERT_DEL', 			'(*)Are you delete?');
define('LANG_JS_REQUEST_DEL', 			'Vui lòng chọn một đối tượng !');
define('LANG_JS_REQUEST',				'Trường có dấu (*) là bắt buộc');
define('LANG_NO_RESULT', 				'Không có kết quả nào.');
define('LANG_REQUIRE', 					'* Yêu cầu nhập thông tin');
define('LANG_ERR_UPLOAD_TYPE', 				'Kiểu file không được phép.');
define('LANG_ACTION', 					'Action');
define('LANG_CHOOSE_ID', 				'Chọn ID');

//Message
define('LANG_UPDATE_SUCCESS', 			'Cập nhật thành công.');
define('LANG_UPDATE_FAILED', 			'Cập nhật không thành công');
define('LANG_INSERT_SUCCESS', 			'Thêm thành công.');
define('LANG_INSERT_FAILED', 			'Thêm không thành công.');
define('LANG_DELETE_SUCCESS', 			'Xóa thành công');
define('LANG_DELETE_FAILED', 			'Xóa không thành công');
define('LANG_ERROR_EMAIL', 				'Email invalid');
define('LANG_ERR_ADD_EXISTS', 	 		'Đối tượng đã tồn tại');
define('ERROR_DEL_PARENTS',			'Một trong những đối tượng không thể xóa do đang chứa đối tượng khác');
define('ERROR_DEL_PARENT',			'Đối tượng không thể xóa do đang chứa đối tượng khác');
define('ERROR_ADD_NO_PERMISION', 	'Không được phép thêm');
define('ERROR_DEL_NO_PERMISION', 'Không được phép xóa');

//TABLE title common
define('LANG_TITLE',					'Title');
define('LANG_NAME',						'Name');
define('LANG_META_TITLE', 			'Title');
define('LANG_DESCRIPTION',				'Description');
define('LANG_META_KEWYORDS', 			'Keywords');
define('LANG_META_DESCRIPTION', 		'Description');
define('LANG_INFO', 					'Info');
define('LANG_ALIAS', 					'Alias');
define('LANG_CONTENT', 	 				'Content');
define('LANG_DATE', 					'Date');
define('LANG_IMAGE', 	 				'Image');
define('LANG_UPLOAD', 	 				'Upload');
define('BTN_SUBMIT', 					'Send');
define('BTN_RESET', 					'Reset');
define('LANG_SEARCH', 					'Search');
define('LANG_STATUS', 					'Status');
define('LANG_ALL', 						'All');
define('LANG_HOME', 					'Home');
define('LANG_ORDER', 					'Order');
define('LANG_ENABLE', 					'Enable');
define('LANG_DISABLE', 					'Disable');

//MODULE: Sys
define('LANG_GLOBAL', 	'Global');
define('LANG_SITENAME', 	'Site name');
define('REGISTER_GROUP', 	'Group');

//MODULE: Content
define('LANG_CONTENTS_TYPE', 					'Type');
define('LANG_CONTENTS_TAB_CONTENT', 			'Content');
define('LANG_CONTENTS_TAB_META_DATA', 			'Metadata');
define('LANG_MENU_CONTENTS_MANAGE',				'Tin tức');
define('LANG_CONTENTS_CONTENTSHORT',			'Nội dung ngắn');
define('LANG_PARENT',			'Danh mục cha');
define('LANG_ADD_CATALOG',			'Thêm danh mục');
define('LANG_ADD_ARTICLE',			'Thêm bài viết');
define('LANG_EDIT_ARTICLE',			'Sửa bài viết'); 
define('LANG_PARENT_NO_PARENT',		'Danh mục cha');
define('LANG_INTRO',		'Giới thiệu');
define('LANG_SET_HOME', 	'Hiện trang chủ');	
define('LANG_SET_NEW', 	'Tin mới');	
define('FULNAME_COMMENT', 	'Comment');	
define('LANG_ERROR_EXIST_CATEGORY',		'Lỗi : Không thể xóa phân mục đang chứa Danh mục hoặc Bài viết');
define('LANG_NOTE', 	'Note');	

//MODULE: Contact
define('LANG_ADDRESS', 			'Địa chỉ');
define('LANG_ADDRES_GROUP', 	'Group address');
define('LANG_ADDRES_GROUP', 	'Địa chỉ khu vực');

define('LANG_TEL', 				'Điện thoại');
define('LANG_ADD_CONTACT', 		'Thêm thông tin doanh nghiệp');

//MODULE: User
define('LANG_USER_ERROR_REQUIRE', 		'Please enter username and password');
define('LANG_USER_ERROR_ACCOUNT', 		'Account not exist');
define('LANG_USER_ERROR_USERNAME', 		'Username này đã có');
define('LANG_USER_MANAGER', 			'Users Manager');
define('LANG_USER_GENERAL', 			'General');
define('LANG_USER_PERMISSION', 			'Permission');
define('LANG_USER_REQUIRE', 			'Please enter your login details.');
define('LANG_USER_NAME', 				'Name');
define('LANG_USER_USENAME', 			'Username');
define('LANG_USER_PASSWORD', 			'Password');
define('LANG_USER_LOGIN', 				'Login');
define('LANG_USER_FIRSTNAME', 			'First name');
define('LANG_USER_LASTNAME', 			'Last name');
define('LANG_USER_FULLNAME', 			'Full name');
define('LANG_USER_EMAIL', 				'Email');
define('LANG_USER_ADDRESS', 			'Address');
define('LANG_USER_PHONE', 				'Phone');
define('LANG_USER_PUBLISH', 			'Publish');
define('LANG_USER_GROUP', 				'Group');
define('LANG_USER_INCORRECT', 			'Incorrect username or password. Please try again!');	
define('LANG_ADD_USER',			'Thêm thành viên');
define('LANG_ERR_USRNAME_EXISTS',		'Username exists');

//MODULE: Shop
define('SHOP_CATEGORY_TITLE', 	'Tiêu đề');	
define('SHOP_CATEGORY_PARENT', 	'Cấp độ');
define('SHOP_PRICE', 	'Price');		
define('SHOP_CATEGORY_NO_PARENT', 	'Không thuộc cấp');	
define('SHOP_PRODUCTS', 	'Quản lý Sản phẩm');	
define('LANG_PRODUCTS_NAME', 	'Tên sản phẩm');	
define('SHOP_PRODUCTS_PRICE', 	'Giá');	
define('SHOP_PRODUCTS_MANUAFACT', 	'Nhà sản xuất');	
define('SHOP_PRODUCTS_DATEUP', 	'Ngày đăng');	
define('SHOP_PRODUCTS_DISCOUNT', 	'Giảm giá');	
define('SHOP_PRODUCTS_IMAGE', 	'Ảnh sản phẩm');	
define('SHOP_PRODUCTS_NUM', 	'Số lượng');	
define('LANG_PRODUCT_NEW', 	'Sản phẩm mới');
define('LANG_ORDER_USER', 	'Tên khách hàng');	
define('LANG_TOTAL', 	'Tổng');	
define('LANG_ID_ORDER', 	'Mã đơn hàng');	
define('LANG_ORDER_INFO', 	'Thông tin đơn hàng');	
define('LANG_ORDER_DETAIL', 	'Chi tiết đơn hàng');	
define('LANG_PRODUCTS_IMAGE_ORTHER', 	'Hình ảnh khác');	
define('SHOP_PRODUCTS_CODE', 	'Mã SP');	
define('SHOP_SUMMARY', 	'Summary');	
define('SHOP_PRODUCTS_DAILY', 	'Distributors');	
define('SHOP_PRODUCTS_HELP', 	'Helps');	



?>