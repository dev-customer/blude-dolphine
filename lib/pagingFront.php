<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class PagingFront {
	function load($getpage, $num, $rowpage, $curpage, $url){
		global $mod; 
			
		$nav = '';
		$maxPage = '';
		$maxPage = ceil($num/$rowpage);
		for($page = 1; $page <= $maxPage; $page++)
		{
			$active = ($page == $getpage) ? 'active':'';
			//if($page == $getpage){ 
			//	$nav .= '<li class="active"><a href="'.$url.'&page='.$page.'">'.$page.'</a></li>';
			//}else{  
			//if( ($getpage + $curpage >= $page) && ($getpage - $curpage <= $page) )					
				$nav .= '<li class="'.$active.'"><a href="'.$url.'&page='.$page.'">'.$page.'<span class="sr-only">('.$page.')</span></a></li>';
			//}
		}
		
		if ($getpage > 1){
			$page  = $getpage - 1;
			$prev  = '<li><a href="'.$url.'&page='.$page.'" aria-label="Previous"><span aria-hidden="true">Previous</span></a></li>';
			$first = '<li><a href="'.$url.'&page=1'.'" >First</a></li>';		
		} 
		else{
			$prev  = '&nbsp;';
		}
		if ($getpage < $maxPage){
			$page = $getpage + 1;
			$next = '<li><a href="'.$url.'&page='.$page.'" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
			$last = '<li class=""><a href="'.$url.'&page='.$maxPage.'">Last <span class="sr-only">('.$maxPage.')</span></a></li>'; 
		}
		else{
			$next  = '&nbsp;';
		}	
		//return '<nav class="text-center"><ul class="pagination">'.@$first . $prev . $nav . $next . @$last.'</ul></nav>';
		//return '<nav class="text-center"><ul class="pagination">'.@$first . $nav . @$last.'</ul></nav>';
		return '<nav class="text-center"><ul class="pagination">'.$nav.'</ul></nav>';
	}
	    
}

?>
