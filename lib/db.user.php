<?php if(!defined('DIR_APP')) die('Your have not permission'); 

function loadUserFrontend($fieldList = "", $idUser = '', $sqlExt = '') {
	global $db;
	$fieldList = $fieldList == '' ? "u.*" : $fieldList; 
	$sql = "SELECT $fieldList
			FROM #__users u
				JOIN #__user_group ug ON( u.id_group = ug.id_group)
			WHERE ug.id_group > 0 AND id_user = ".(int)$idUser; //require any user
	$sql .= " $sqlExt";
	$info['row'] = $db->loadObject($sql); 		
	return !empty($info)? $info : false;
}
 
function loadListUserFrontend($fieldList = "", $sqlExt = '', $orderby='',  $limit = '', $chkLoadMore = false) {
	global $db;
		
	$fieldList = $fieldList == '' ? "u.*" : $fieldList; 
	$sql = "SELECT $fieldList
			FROM #__users u
				JOIN #__user_group ug ON( u.id_group = ug.id_group)
			WHERE ug.id_group > 0 "; //require any user
	$sql .= " $sqlExt";
	$sql .= ($orderby=='')? ' ORDER BY p.id_user DESC ' : $orderby;  
	$info['totalRecord'] = $db->num($sql);		
	$sql .= $limit != '' ? " LIMIT $limit" : '';
	$info['rows'] =  $db->loadObjectList($sql); 		
	return !empty($info['rows'])? $info : false;
} 

function encryptPwdUser($str='') {
	 return md5(sha1(addslashes($str)));
}
 
 
?>