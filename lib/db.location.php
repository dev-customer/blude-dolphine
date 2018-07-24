<?php if(!defined('DIR_APP')) die('Your have not permission'); 
/*
function loadItemLocation($fieldList = '', $sqlExt = '') {
	global $db;
	$fieldList = $fieldList == '' ? "l.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__location l 
			WHERE l.id_location > 0 ";
	$sql .= " $sqlExt";	
	$info['row'] = $db->loadObject($sql);  
	return !empty($info)? $info : false;
}


function loadListLocation($fieldList='', $sql_ext='', $orderby='', $limit = 500) {
	global $db, $mod;
	$fieldList = $fieldList == '' ? "l.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__location l"; 
	$sql .= " WHERE l.id_location > 0 "; 
	$sql .= " $sql_ext";	
	$sql .= ($orderby=='')? ' ORDER BY l.orderring ' : $orderby;			
	$info['totalRecord'] = $db->num($sql);		
	
	$sql .= " LIMIT $limit"; 
	 
	$info['rows'] = $db->loadObjectList($sql); 	
	return !empty($info['rows'])? $info : false;
}
*/

function getCategoryLocation($catid=0, $split="", $list_style="")
{
	global $json, $db;
	$ret = array();	 		
	$sql = "SELECT * FROM #__location  WHERE id_parent = $catid ORDER BY orderring";	
	$result = $db->query($sql);
	while (($row = mysql_fetch_assoc($result)))
	{
		 $ret[] = array($row['id_location'], ($catid==0?"" : $split). $list_style.$json->getDataJson1D($row['title'], $_SESSION['dirlang']), $row['orderring'] , $row['publish'] , $row['alias'] , $row['id_parent'], $row['image']);
		 $getsub = getCategoryLocation($row['id_location'], $split.$split, $list_style);
		 foreach($getsub as $sub)
			$ret[] = array($sub[0], $sub[1], $sub[2], $sub[3], $sub[4], $sub[5], $sub[6]);
	}
	return $ret;
}		

  
?>