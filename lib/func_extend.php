<?php if(!defined('DIR_APP')) die('Your have not permission'); 
	//stripslashes custom: have in module.php
	function stripslash($str){
		$rstr = trim($str);
		$rstr = strip_tags($rstr);
		return str_replace(array("\\","'", "$","#"),"", $rstr);
	} 
	 
	function timeReal($format="Y-m-d H:i:s")
	{
		global $timezone;
		return  gmdate($format, time() + 3600*($timezone+date("0"))); 		
	}
	
	function showImg($chkdir='', $srcImg='', $srcDefault='', $width=50, $height=50, $alt="", $title="", $class='', $param='') {
		$src = '';
		$default = '';
		if(is_file($chkdir))
			$src = $srcImg;
		else
		{
			$src = $srcDefault;
			$default = "brd-no-img";
		}
		return '<img src="'.URL_UPLOAD.$src.'" width="'.$width.'"  height="'.$height.'" alt="'.$alt.'" title="'.$title.'" class="'.$default.' '.$class.'" '.$param.' />';
	}
	
	function convertYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"<iframe src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>", $string
		);
	}	
	function showAttrActive($attrName = '', $value = '', $txtGroup = ''){ ?>
		<div style="padding-right:3px" class="input-group optionPublish bg-sdt1 img-rounded"><span style="border:none" class="input-group-addon bg-sdt2"><?= $txtGroup ?></span>
			<input type="radio" name="<?=$attrName?>" value="1" <?= $value==1 ? 'checked' : ''; ?> /> <span class="txtPublish"><?= LB_ON ?></span>
			<input type="radio" name="<?=$attrName?>" value="0" <?= $value==0 ? 'checked' : ''; ?> /> <span class="txtPublish"><?= LB_OFF ?></span>
		</div>
		<style>
		    .optionPublish .txtPublish{ margin-top: 2px; float: left;}
		    .optionPublish input{ margin: 6px; float: left;} 
		</style>
	<?php	
	}
	 
	function tabsLanguageAdmin() 
	{  
		global $mod;
		echo '<div id="tabs" class="htabs">';
		foreach($mod->languages as $lang)
			echo '<a tab="#tab_'.$lang['code'].'"><img height="13"  src="images/flags/'.$lang['code'].'.png" /> '.$lang['name'].'</a>';  
		echo '</div>';
	 
	} 
	 
	function dropDown($nameHtml = '', $data = array(), $id = '', $name = '', $selected = '', $param = ' class="form-control"', $opDefault = 'All') 
	{  	
		global $json;
		$html = '<select name="'.$nameHtml.'" '.$param.'>';
		$html .='<option value="">-'.$opDefault.'-</option>'; 
			foreach($data as $value):
				$select = ($selected == $value[$id]) ? ' selected="selected"' : '';
				$html .= '<option  value="'.$value[$id].'" '.$select.' >'.$json->getDataJson1D($value[$name], $_SESSION['dirlang']).'</option>';						 							
			endforeach; 
		$html .='</select>';
		return $html;
	} 
	
	function categoryToArray($dataCate = array()){
		$tmp = array();
		foreach($dataCate as $value)
			$tmp[] = $value[0];
			
		return $tmp;
	}
	
	function viewError(){ ?>
		<script type="text/javascript" src="<?=TEMPLATE?>js/jquery.min.1.11.3.js"></script>		
		<script src="<?=TEMPLATE?>bootstrap/bootstrap.min.js"></script>
		<link href="<?=TEMPLATE?>bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="<?=TEMPLATE?>font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
		</head>
		<body style="background-color: #d6cccc;">
		<div class="container-fluid">	 
			<div class="container"> 
				<br/><div class="alert text-center bg-danger" style="color:red">Site updating...</div>
				<script>
					$(document).ready(function(){
						//wating...
						setInterval(function() {   				
							 window.location = "index.php";
						}, 10000);   
					});
				</script>
			</div>
		</body> 
	<?php	
	}
	
?>
