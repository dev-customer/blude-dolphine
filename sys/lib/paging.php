<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Paging {
	function load($getpage, $num, $rowpage, $curpage, $url){
		global $mod;
		
		$nav = '';
		$maxPage = '';
		$maxPage = ceil($num/$rowpage);
		for($page = 1; $page <= $maxPage; $page++){
			if ($page == $getpage)
				$nav .= "<b class=\"module-".$mod->module."\">". $page ."</b>";
			else{
				if( ($getpage + $curpage >= $page) && ($getpage - $curpage <= $page) )
					$nav .= "<a href='".$url.'&page='.$page."'>". $page ."</a>";
			}
		}
		
		if ($getpage > 1){
			$page = $getpage - 1;
			$prev = "<a href='".$url.'&page='.$page."' class=\"module-".$mod->module."\"> PRIVEW </a>";
			$first = "<a href='".$url.'&page=1'."' class=\"module-".$mod->module."\"> FIRST </a>";
		} 
		else{
			$prev  = '&nbsp;';
		}
		if ($getpage < $maxPage){
			$page = $getpage + 1;
			$next = "<a href='".$url.'&page='.$page."' class=\"module-".$mod->module."\"> NEXT </a>";
			$last = "<a href='".$url.'&page='.$maxPage."' class=\"module-".$mod->module."\"> LAST </a>";
		}
		else{
			$next  = '&nbsp;';
		}
		
		//return '<div class="pagination"><div class="links">'.@$first . $prev . $nav . $next . @$last.'</div><div class="results">Showing '.($maxPage ? $getpage : 0).'/'.$maxPage.' (Total: '.$num.')</div></div>';
		return '<div class="pagination"><div class="links">'.@$first . $prev . $nav . $next . @$last.'</div><div class="results">Showing '.($maxPage ? $getpage : 0).'/'.$maxPage.' (Total: '.$num.')</div></div>';
	}
	/*
	* Paging load Ajax
	* Added by Vu
	*/
	function loadAjax($getpage, $num, $rowpage, $curpage, $url, $di){
		global $mod;
		$div = $di;
		$nav = '';
		$maxPage = '';
		$maxPage = ceil($num/$rowpage);
		for($page = 1; $page <= $maxPage; $page++){
			if ($page == $getpage){
				$nav .= "<b><a class='active' href='javascript:void(0)'>". $page ."</a></b>";
			}
			else{
				if( ($getpage + $curpage >= $page) && ($getpage - $curpage <= $page) ){
					$nav .= "<a href='javascript:getContentPage(\"$div\", \"". $url.'&page='.$page ."\",2)'>". $page ."</a>";
				}
			}
		}
		if ($getpage > 1){
			$page = $getpage - 1;
			$prev = "<a href='javascript:getContentPage(\"$div\",\"". $url.'&page='.$page ."\",2)'> &lt; </a>";
			$first = "<a href='javascript:getContentPage(\"$div\",\"". $url.'&page=1' ."\",2)'> |&lt; </a>";
		} 
		else{
			$prev  = '&nbsp;';
		}
		if ($getpage < $maxPage){
			$page = $getpage + 1;
			$next = "<a href='javascript:getContentPage(\"$div\",\"". $url.'&page='.$page ."\",2)'> &gt; </a>";
			$last = "<a href='javascript:getContentPage(\"$div\", \"". $url.'&page='.$maxPage ."\",2)'> &gt;| </a>";
		}
		else{
			$next  = '&nbsp;';
		}
		
		return '<div class="pagination"><div class="links">'.@$first . $prev . $nav . $next . @$last.'</div></div>';
	}		
						 
	function pagingAjax2($type, $base_url ,$num_items, $per_page, $start_item, $add_prevnext_text ) 
	{     
			$page_string = '';
			$total_pages = ceil($num_items/$per_page)+1;
			if ( $total_pages > 0 ) 
			{
				$on_page = floor($start_item / $per_page) + 1; // 
				if ( $add_prevnext_text ) 
				{
					list ($lang_page, $lang_prev, $lang_next) = split ('///', $add_prevnext_text);
					if ( $on_page > 1 ) 
					{
						$page_string = "<div class='pagination'><a href=\"javascript:void(0)\" onclick=\"PagingMore('".$type."','".(( $on_page - 2 ) * $per_page )."' , '".$base_url."')\" >" . $lang_prev . " &nbsp;&nbsp;</a></div>  &nbsp;&nbsp;" . $page_string;
					} 
					if ( $on_page < $total_pages ) 
					{
						$page_string .= "&nbsp;&nbsp;<div  class='pagination'><a href=\"javascript:void(0)\" onclick=\"PagingMore('".$type."','".(( $on_page) * $per_page )."', '".$base_url."')\">" . $lang_next . " &nbsp;&nbsp;</a></div>&nbsp;&nbsp;";
					} 
					$page_string = $lang_page . $page_string;
				}
			}
			return $page_string;
	}
	function pagingAjax($type, $base_url ,$num_items, $per_page, $start_item, $add_prevnext_text ) 
	{     
			$page_string = '';
			$total_pages = ceil($num_items/$per_page);
			if ( $total_pages > 0 ) 
			{
				$on_page = floor($start_item / $per_page) ; // 
				if($start_item % $per_page == 1)
					$on_page + 1;
				if ( $add_prevnext_text ) 
				{
					list ($lang_page, $lang_prev, $lang_next) = split ('///', $add_prevnext_text);
					if ( $on_page >= $total_pages ) 
					{
						$page_string = "<div class='pagination'><a href=\"javascript:void(0)\" onclick=\"PagingMore('".$type."','".$start_item."' , '".$base_url."')\" >" . $lang_prev . " &nbsp;&nbsp;</a></div>  &nbsp;&nbsp;" . $page_string;
					} 
					if ( $on_page < $total_pages ) 
					{
						$page_string .= "&nbsp;&nbsp;<div  class='pagination'><a href=\"javascript:void(0)\" onclick=\"PagingMore('".$type."','".$start_item."', '".$base_url."')\">" . $lang_next . "&nbsp;&nbsp;</a></div>&nbsp;&nbsp;";
					} 
					
					$page_string = $lang_page . $page_string;
				}
			}
			return $page_string;
	}
}

?>
