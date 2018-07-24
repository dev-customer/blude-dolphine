<?php if(!defined('DIR_APP')) die('Your have not permission'); 
function loadItemInfo($fieldList = '', $sqlExt = '') {
	global $db;
	$fieldList = $fieldList == '' ? "c.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__content c
				JOIN #__category cc ON(c.id_cat = cc.id_cat) 
				LEFT JOIN #__category cc2 ON(cc2.id_parent = cc.id_cat) 
				LEFT JOIN #__category cc3 ON(cc3.id_parent = cc2.id_cat)
				JOIN #__users u ON(c.user_add = u.id_user) 
			WHERE c.id_art > 0 ";
	$sql .= " $sqlExt";	
	$info['row'] = $db->loadObject($sql);  
	return !empty($info)? $info : false;
} 

function loadListInfo($fieldList='', $sql_ext='', $orderby='', $limit = '') {
	global $db, $mod;
	$fieldList = $fieldList == '' ? "c.*" : $fieldList;
	$sql = "SELECT $fieldList
			FROM #__content c
				JOIN #__category cc ON(c.id_cat = cc.id_cat) 
				LEFT JOIN #__category cc2 ON(cc2.id_parent = cc.id_cat) 
				LEFT JOIN #__category cc3 ON(cc3.id_parent = cc2.id_cat)
				JOIN #__users u ON(c.user_add = u.id_user)"; 
	$sql .= " WHERE c.id_art > 0 ";	// Safe query if not WHERE
	$sql .= " $sql_ext";	
	$sql .= ($orderby=='')? ' ORDER BY c.orderring ' : $orderby;			
	$info['totalRecord'] = $db->num($sql);		
	$sql .= $limit != '' ? " LIMIT $limit" : '';
	$info['rows'] = $db->loadObjectList($sql); 	
	return !empty($info['rows'])? $info : false;
} 

function getCategoryInfo($catid=0, $split="_", $list_style="|_")
{
	global $json, $db;
	$ret=array(); 
	if ($catid=="") $catid=0;
	$sql = "SELECT * FROM #__category  WHERE id_parent = $catid ORDER BY orderring";		
	$result = $db->query($sql);
	while (($row = mysql_fetch_assoc($result)))
	{
		$ret[] = array(
						$row['id_cat'], 
						($catid==0?"" : $split).$list_style.$json->getDataJson1D($row['title'], $_SESSION['dirlang']), 
						$row['orderring'] , 
						$row['publish'] , 
						$row['alias'] , 
						$row['id_parent'], 
						$row['image'], 
						$row['link'], 
						$row['setMenu'], 
						$row['setViewGroup'], 
						$row['setDelete'], 
						$row['setEdit'],
						$row['aliasFix'],
						$row['setDisplayAdmin']
					); 		  		
		$getsub = getCategoryInfo($row['id_cat'], $split.$split, $list_style); 		
		foreach($getsub as $sub):
		$ret[]=array(
						$sub[0], 
						$sub[1], 
						$sub[2], 
						$sub[3], 
						$sub[4], 
						$sub[5], 
						$sub[6], 
						$sub[7], 
						$sub[8], 
						$sub[9], 
						$sub[10], 
						$sub[11], 
						$sub[12],
						$sub[13]
					);
		endforeach;
	} 	
	return $ret; 
}		  
function showHtmlItemInfo($row = array(), $md = 3, $param = '') 
{ 	
	if(!empty($row))
	{ 		
		global $json,$mod; 		
		$link  = LINK_INFO_ITEM.$row['alias'].'.html'; 		
		$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);   		
		?> 		<div class="col-md-<?=$md?>">  			
		<div class=""> 				
			<div class="thumbnail"> 					
				<a href="<?=$link?>"> 					
				<?=
				showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', "", "", '', ' style="height:'.$mod->config['imageNews'].'px"'); 					
				?> 					
				</a>    				
			</div> 	 				
			<div class="caption text-center"> 					
				<h5><a class="text-uppercase" href="<?=$link?>"><?=$title?></a></h5>  				
			</div> 			
		</div>   	
		<?php	 	
	} 
}      
?>
