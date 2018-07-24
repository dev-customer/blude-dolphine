<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class News extends Module{
	var $cNewsM = array();
	
	function __construct(){
		
		$tempList = getCategoryInfo(69);
		foreach($tempList as $value)
			$this->cNewsM[] = $value[0];
		
	}
	function index(){ 
		global $db, $mod;	
		$rowpage = 10;
		$curpage = CUR_ROWS;
		$getpage = empty($_GET['page']) ? 1 : $_GET['page']; 
		$offset = ($getpage - 1) * $rowpage;	
		$limit = $offset.','.$rowpage;
		
		$layout = 'news';
		
		$sqlExt = " AND c.publish = 1";
		if($_GET['alias'] != '')
		{
			$cate = $this->loadObject('SELECT * FROM #__category WHERE alias = "'.$_GET['alias'].'"');
			if(!empty($cate)){ 
				$cListID = getCategoryInfo($cate['id_cat'], '', '');
				$cList = categoryToArray($cListID);
				$cList[] = $cate['id_cat'];
				$sqlExt .= " AND c.id_cat IN (".implode(',', $cList).")";	
			
				/*
				if($cate['id_cat'] != '')
				{
					switch($cate['id_cat'])
					{
						case 140: $layout = 'news2'; break; 
							
						default: 
							  
					}  
				} 
				*/
			}else{
				$this->redirect(BASE_NAME); 
			}
		} 				

		$key = isset($_POST['keyword'])? addslashes($_POST['keyword']) : '';
		$sqlExt .= !empty($key)? " AND  c.title LIKE '%".$key."%'" : '';		 
		 				
		$data = loadListInfo('', $sqlExt, '', $limit); 
		
		$url = '';
		$url .=  $_GET['alias'] != '' ? LINK_INFO_LIST.$_GET['alias'].'.html' : LINK_INFO_ALL; 
		
		$data['paging'] = PagingFront::load($getpage, $data['totalRecord'], $rowpage, $curpage, $url);
		//$data['countrows'] = ($rowpage * $getpage)- $rowpage + 1;
		
		$this->view('info/view/'.$layout, $data);		
	}
	 
	
	function home(){
		$this->view('info/view/home');				
	}
	
	function category(){
		$this->view('info/view/category');				
	}	
	 		 
	function newsSide(){
		$this->view('info/view/newsSide');				
	}
		 
	function detail(){
		global $db, $mod;			
		$sqlExt = " AND c.publish = 1 AND c.alias = '".$mod->id."'";		
		$data = loadItemInfo('c.*, cc.id_parent AS catParent', $sqlExt); 
		$layout = 'detail';
		
		/*
		if($data['row']['catParent'] != '')
		{
			switch($data['row']['catParent'])
			{
				case 130: $layout = 'detail2'; break; 
					
				default: 
					  
			}  
		} 
		*/
		if($data['row']){
			$this->view('info/view/'.$layout, $data);
		}else{
			$this->redirect(BASE_NAME);
		} 
	}
}
?>	
