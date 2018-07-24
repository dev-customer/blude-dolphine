<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class curlPost{ 
	
	function postCurl($url, $data2D = array()) {
		$hearsArr = get_headers($url);  
		if($url ==''){
			return 'Error: url mail invalid!';
		}
		else if(strpos($hearsArr[0], '200')<=0)
				return 'Error: Server mail error!';			
			 else if(count($data2D)==0)
					return 'Error: data invalid!';
		  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);  
		curl_setopt($ch, CURLOPT_POST, 1);
		$data2DStr = http_build_query($data2D, '', '&');
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $data2DStr);
		curl_exec ($ch);
		curl_close ($ch); 
	}
}
?>