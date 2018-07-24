<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class JsonData {

	  
	// give data 1 dim
	function saveDataJson1D($arrayJson = array()){
		
		//$objJs = utf8_encode($arrayJson, JSON_UNESCAPED_UNICODE);
		
		$tmp = array();
		foreach($arrayJson as $key => $value){
			//$tmp[$key] = base64_encode($value);
			$tmp[$key] = $value;
		}
		$objJs = json_encode($tmp, JSON_UNESCAPED_UNICODE);
		return $objJs;
		
	}
	// get data 1 dim
	function getDataJson1D($rowJs = '', $key = ''){ 
		$obj = json_decode($rowJs);
		if(count($obj)>0){
			//return base64_decode($obj->$key);
			return $obj->$key;
		}		
	}
	 
	
	function saveDataJson1D2($optn){
		$options = json_encode($optn);
        $arr = explode("\u", $options);
        foreach($arr as $key => $arr1){
            if($arr1[0] == '0'){
                $ascCode = substr($arr1, 0, 4);
                $newCode = html_entity_decode('&#x' .$ascCode. ';', ENT_COMPAT, 'UTF-8');
                $arr[$key] = str_replace($ascCode, $newCode, $arr[$key]);
            }
        }
        return $options = implode('', $arr);
	}
	// remove item data 2 dim
	function popArrayJson2D($array_2d = array(), $idKey, $idValue){
		if(is_array($array_2d) && !empty($idKey) && !empty($idValue))
		{
			foreach($array_2d as $key => $value)
				if($value->$idKey == (int)$idValue)
					unset($array_2d[$key]);
			return 	$array_2d;
		}
	}
	
	// insert data 2 dim
	function pushArrayJson2D($array_2d = array(), $array_1d_element){
		if(is_array($array_1d_element))
		{	
			$array_2d[] = $array_1d_element;
			return $array_2d;
		}		
	}
	// insert data 3 dim
	function pushArrayJson3D($array_3d = array(), $keyParent = '', $keyNameChild = '', $array_1d_element){
		if(is_array($array_1d_element))
		{				
			foreach($array_3d as $key => $value){
				if($keyParent != '')
					$array_3d[$keyParent][$keyNameChild] = $array_1d_element;
				else
					$array_3d[$key][$keyNameChild] = $array_1d_element;
			}
			
			return $array_3d;
		}		
	}
	
	// filter data 2 dim
	function filterArrayJson2D($array_2d = array(), $idKey, $idValue){
		if(is_array($array_2d) && !empty($idKey) && !empty($idValue))
		{		
			$arrRespone = array();
			foreach($array_2d as $key => $value)
			{	
				$keys = array_keys((array)$value);			 
				$dataItem = $value->$keys[0];
				if($dataItem->$idKey == $idValue)
					$arrRespone[] = $array_2d[$key];
			}
			return $arrRespone;
		}
	}
		
	// remove data
	function removeItemArrayJson2D($array_2d = array(), $keyValue){
		if(is_array($array_2d) && !empty($keyValue))
		{		
			$arrRespone = array();
			foreach($array_2d as $key => $value)
			{	
				$keys = array_keys((array)$value);			 				
				if($keys[0] != $keyValue){
					$arrRespone[] = $array_2d[$key];
				}
			}
			 
			return $arrRespone;
		}
	}
		
	// update data
	function updateArrayJson2D($array_2d = array(), $idKey, $valueOld=NULL, $valueNew=NULL){
		//if(is_array($array_2d) && !empty($idKey) && !empty($valueOld) && !empty($valueNew))
		if(is_array($array_2d) && !empty($idKey))
		{		
			$arrTmp = array();
			foreach($array_2d as $key => $value)
			{	
				$keys = array_keys((array)$value);			 
				$dataItem = $value->$keys[0];
				
				if($dataItem->$idKey === $valueOld){
					$dataItem->$idKey = $valueNew; //change value if new
				}
				$arrTmp[][$keys[0]] = $dataItem;
			}
			//var_dump($arrTmp);
			return $arrTmp;
		}
	}
	
	
}

?>