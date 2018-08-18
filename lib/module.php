<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Module extends Database {
	var $config = array(); 
	var $meta_title 	= '';
	var $meta_keywords 	= '';
	var $meta_description = '';
	var $module 		=	'';
	var $control 		=	'';
	var $method 		=	'';
	var $id 			=	'';
	var $page 			=	'';
	var $languages 		= '';
	var $breadcrumb 	=	'';
	var $meta_fbimage 	=	'';

	function __construct(){
		global $json, $contact; 
		$this->module 		=	@$_GET['p'];
	 	$this->control 		=	@$_GET['q'];
		$this->method 		=	@$_GET['m'];
		$this->id 			=	@$_GET['id'];
		$this->page 		=	@$_GET['page'];
		$this->config  		= 	$this->loadObject("SELECT * FROM #__config ");
		$this->languages  	= 	$this->loadObjectList("SELECT * FROM #__language WHERE publish = 1");
		$this->meta_title 	= 	$json->getDataJson1D($contact['name'], $_SESSION['dirlang']);
		$this->meta_keywords = 	$this->config['meta_keyword'];
		$this->meta_description = $this->config['meta_description'];//$this->secMod();
	}
	
	function load($module, $control='', $method=''){ 
		//---------------------------
		$file = 'modules/'.$module.'/controller/'.$control.'.php';

		if( is_file($file) ) {
			include_once($file);
			if(class_exists(ucfirst($control))) { 
				$name = new $control;
				if(method_exists($name, $method) && !empty($method)) 
					$name->$method();
				else 
					if(method_exists($name, "index"))
						$name->index();
					else
						$this->redirect(BASE_NAME);
			}
		}
		else {
			if(DEBUG==1)
				//echo @file_get_contents(BASE_NAME.'respond.html');
				echo 'Function not exists';
			else 
				$this->redirect(BASE_NAME);
		}
	}
	
	function controller(){
		$p = !empty($this->module) ?  $this->module : 'info';
		$q = !empty($this->control) ? $this->control : $this->module; 
		$m = !empty($this->method) ? $this->method : 'index';
		if(isset($_POST['task']) && $_POST['task']!='') {
			$m = $_POST['task'];
		}
		//echo '<br />p='.$p.'::q='.$q.'::m='.$m.'::id='.$this->id.'::page='.$this->page.'<br />';
		$this->load($p, $q, $m);
	}
	
	function model($filepath) {
		$path = 'modules/'.$filepath.'.php';
		if( is_file($path) ) {
			include_once($path);
		}
		else {			
			if(DEBUG==1)
				die('<h2>Error: File ['.$path.'] not exist.</h2>');
			else 
				$this->redirect(BASE_NAME);
		}
	}
	

	function view($filepath, $data=array()){
		global $db, $mod;
	
		extract($data);
		$path = 'modules/'.$filepath.'.php';
		if( is_file($path) ) { 
			include_once($path);
		}
		else {			
			if(DEBUG==1)
				die('<h2>Error: File ['.$path.'] not exist.</h2>');
			else 
				$this->redirect(BASE_NAME);
		}
		
	}
	//
	function viewContent($filepath, $data=array()){
		global $db, $mod;
		extract($data);
		ob_start(); 
		$path = 'modules/'.$filepath.'.php';
        include($path);
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
        return $contents;
	}

    function viewPage($filepath, $data=array()){
        global $db, $mod;
        extract($data);
        ob_start();
        $path = 'modules/'.$filepath.'.php';
        include($path);
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
        return $contents;
    }



    function lang($file, $dir) {
	
		if( !empty($_POST['dirlang']) ) {
			$_SESSION['dirlang'] = $_POST['dirlang'];
		}
		
		$path = $dir.'lang/'.$_SESSION['dirlang'].'/'.$file.'.php'; 
		if( is_file($path) ) {
			include_once($path);
		}
		else {
			if(DEBUG==1){
				//die('<h2>Error: File ['.$path.'] not exist.</h2>');
				$_SESSION['dirlang'] ='vn';
				$this->redirect(BASE_NAME);
			}else 
				$this->redirect(BASE_NAME);			
		}
	}
	
	function url($str, $title='') {
		global $mod_rewrite;
		
		$arr = array('/p=/', '/q=/', '/m=/', '/id=/', '/page=/');
		
		$dir = DIR_APP=='sys' ? 'sys/' : '';
		
		$title = empty($title) ? '' : '/'. strtolower(str_replace(' ', '-', $title));
		
		$url = explode('?', $str);
		$url = str_replace('&', '/', @$url[1]);
		$url = preg_replace($arr, '', $url) . $title;
		
		return $mod_rewrite == true ? BASE_NAME . $dir . $url : $str;
	}

	//get title
	function getPage($p="", $id=""){		
		global $json;
		$p =  $this->module ;
		$q =  $this->control ;
		$m =  $this->method ;
		$id = $this->id;
		$this->breadcrumb 	=	'<li><span class="glyphicon glyphicon-home clr-sdt1"></span> <a href="'.BASE_NAME.'">'.MENU_HOME.'</a></li>';
		switch($p){
			case 'contact':
				$this->meta_title= $this->meta_keywords = $this->meta_description = MENU_CONTACT;
				$this->breadcrumb .= '<li><a href="'.LINK_CONTACT.'">'.MENU_CONTACT.'</a></li>';
				break; 		
			case 'info': 
				if($m != 'detail')
				{					
					$row = parent::loadObject("SELECT * FROM #__category WHERE alias = '".$_GET['alias']."'");
					if($row){
						$this->meta_title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);			
						$this->meta_keywords =  $json->getDataJson1D($row['meta_keywords'], $_SESSION['dirlang']);
						$this->meta_description =  $json->getDataJson1D($row['meta_description'], $_SESSION['dirlang']);
						
						$this->breadcrumb .= '<li><a href="'.LINK_INFO_LIST.$row['alias'].'.html">'.$json->getDataJson1D($row['title'], $_SESSION['dirlang']).'</a></li>';
					}
				}
				else if($m == 'detail')
				{ 
					$row= parent::loadObject("SELECT c.*, cc.alias AS calias, cc.title AS ctitle FROM #__content c, #__category cc WHERE c.id_cat = cc.id_cat AND c.alias = '".$id."'");
					if($row)
					{
						$this->meta_title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);			
						$this->meta_keywords =  $json->getDataJson1D($row['meta_keywords'], $_SESSION['dirlang']);
						$this->meta_description =  $json->getDataJson1D($row['meta_description'], $_SESSION['dirlang']);
						$this->meta_fbimage =  URL_UPLOAD.'content/'.$row['image'];
						
						$num = $this->num('SELECT * FROM #__content WHERE id_cat = '.$row['id_cat']); 
						if($num > 1)
							$this->breadcrumb .= '<li><a href="'.LINK_INFO_LIST.$row['calias'].'.html">'.$json->getDataJson1D($row['ctitle'], $_SESSION['dirlang']).'</a></li>';
						$this->breadcrumb .= '<li><a href="'.LINK_INFO_ITEM.$row['alias'].'.html">'.$json->getDataJson1D($row['title'], $_SESSION['dirlang']).'</a></li>';
					}
				}
				break;
				
			case 'shop':
				
				if( $m === 'brand') {
					$man = $this->loadObject('SELECT * FROM #__shop_manuafact WHERE alias = "'.$_GET['malias'].'"');  
					if(!empty($man)){
						$url = LINK_SHOP_MANUFACT_ITEM.$_GET['malias'].'.html';
						$brandName = $json->getDataJson1D($man['name'], $_SESSION['dirlang']);
					} 

					$this->breadcrumb .= '<li><a href="'.$url.'">'.$brandName.'</a></li>';
				}

				else if($m != 'detail')
				{
					$sql = "SELECT *  FROM #__shop_category WHERE alias = '".$_GET['alias']."'";					
					$row = parent::loadObject($sql);
					if($row)
					{
						$this->meta_title	= $json->getDataJson1D($row['title'], $_SESSION['dirlang']);			
						$this->meta_keywords =  $json->getDataJson1D($row['meta_keywords'], $_SESSION['dirlang']);
						$this->meta_description =  $json->getDataJson1D($row['meta_description'], $_SESSION['dirlang']);
						
						$this->breadcrumb .= '<li><a href="'.LINK_SHOP_LIST.$row['alias'].'.html">'.$json->getDataJson1D($row['title'], $_SESSION['dirlang']).'</a></li>';
					}
				}
				else if($m == 'detail')
				{
					$row= parent::loadObject("SELECT p.*, c.alias AS calias, c.title AS ctitle FROM #__shop_products p, #__shop_category c WHERE p.id_cat = c.id_cat AND p.alias = '".$id."'");					
					if($row)
					{
						$this->meta_title= $json->getDataJson1D($row['title'], $_SESSION['dirlang']);			
						$this->meta_keywords =  $json->getDataJson1D($row['meta_keywords'], $_SESSION['dirlang']);
						$this->meta_description =  $json->getDataJson1D($row['meta_description'], $_SESSION['dirlang']);
						$this->meta_fbimage =  URL_UPLOAD.'shop/'.$row['image'];
						
						$this->breadcrumb .= '<li><a href="'.LINK_SHOP_LIST.$row['calias'].'.html">'.$json->getDataJson1D($row['ctitle'], $_SESSION['dirlang']).'</a></li>';
						$this->breadcrumb .= '<li><a href="'.LINK_SHOP_ITEM.$row['alias'].'.html">'.$json->getDataJson1D($row['title'], $_SESSION['dirlang']).'</a></li>';
					}
				}
				break;
				
			default:				
		}
	}


	function redirect($url='', $title='') {
		echo "<script>window.location.href='".$url."'</script>"; 
	}

	function checkInt($int)
	{
		$ktra = is_numeric($int);
		if($ktra == 0) return 0;
		else if($ktra == 1)
		{
			if($int < 0) return 0;
			else if($int >9999) 
				return 0;
			else
				return 1;
		}
	}
	//====substring
	function cutstring($strorg, $limit){	
		if(strlen($strorg)<=$limit){
			return $strorg;
		}else{		
			if(strpos($strorg," ",$limit) > $limit){
				$new_limit=strpos($strorg," ",$limit);
				$new_strorg = substr($strorg,0,$new_limit)."...";
			return $new_strorg;
		}	
		$new_strorg = substr($strorg,0,$limit)."...";
		return $new_strorg;
		}
	}
	//=====alert & redirect
	function aRedirect($msg, $strUrl){		
	?>
		<script language="javascript">
			alert('<?php echo $msg?>');
			window.location.href='<?php echo $strUrl?>';
		</script>
	<?php
	}
	//=====redirect
	function nRedirect($msg, $strUrl){		
	?>
		<script language="javascript">
			//alert('<?php echo $msg?>');
			window.location.href='<?php echo $strUrl?>';
		</script>
	<?php
	}
	//function secMod(){ if($_SERVER['HTTP_HOST']!='localhost'){if(md5($_SERVER['HTTP_HOST']) != HD_SEC) exit(); }}
	//generate string number
	function rand_str($length = 8, $chars = '0123456789')
	{
		// Length of character list
		$chars_length = (strlen($chars) - 1);
	
		// Start our string
		$string = $chars{rand(0, $chars_length)};
	   
		// Generate random string
		for ($i = 1; $i < $length; $i = strlen($string))
		{
			// Grab a random character from our list
			$r = $chars{rand(0, $chars_length)};
		   
			// Make sure the same two characters don't appear next to each other
			if ($r != $string{$i - 1}) $string .=  $r;
		}
	   
		// Return the string
		return $string;
	}
	 

	// Rewrite Label
	function aRewrite($label){
		$search = array("À","Á","Â","Ã","Ä","Å","à","á","ả","â","ã","ä","å","Ò","Ó","Ô","Õ","Ö","Ø","ò","ó","ô","õ","ö","ø","È","É","Ê","Ë","è","é","ê","ễ","ế","ề","ể","ệ","ë","Ç","ç","Ì","Í","Î","Ï","ì","í","î","ï","Ù","Ú","Û","Ü","ù","ú","û","ü","ÿ","Ñ","ñ");
		$model = array("A","A","A","A","A","A","a","a","a","a","a","a","a","O","O","O","O","O","O","o","o","o","o","o","o","E","E","E","E","e","e","e","e","e","e","e","e","e","C","c","I","I","I","I","i","i","i","i","U","U","U","U","u","u","u","u","y","N","n");
		$label = str_replace($search,$model,$label);
		$search2 = array ('@[^a-zA-Z0-9]@');
		$replace = array (' ');
		$label =  preg_replace($search2, $replace, $label); 
		
		$label = strtolower($label); // mais toutes les lettres de la chaîne en minuscule
		$label = str_replace(" ",'-',$label); // remplace les espaces en tirets
		$label = preg_replace('#\-+#','-',$label); // enlève les autres caractères inutiles
		$label = preg_replace('#([-]+)#','-',$label);
		trim($label,'-'); // remplace les espaces restants par des tirets
	
		return $label;
	}
	function Rewrite($text) {
		$text = str_replace(
		array(' ','%',"/","\\",'"','?','<','>',"#","^","`","'","=","!",":" ,",,","..","*","&","__","▄","-"),
		array('-','' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-','' ,'-','' ,'' ,'' , "va" ,"-" ,"-","-"),
		$text);
		
		$chars = array("a","A","e","E","o","O","u","U","i","I","d", "D","y","Y");
		
		$uni[0] = array("á","à","ạ","ả","ã","â","ấ","ầ", "ậ","ẩ","ẫ","ă","ắ","ằ","ặ","ẳ","� �");
		$uni[1] = array("Á","À","Ạ","Ả","Ã","Â","Ấ","Ầ", "Ậ","Ẩ","Ẫ","Ă","Ắ","Ằ","Ặ","Ẳ","� �");
		$uni[2] = array("é","è","ẹ","ẻ","ẽ","ê","ế","ề" ,"ệ","ể","ễ");
		$uni[3] = array("É","È","Ẹ","Ẻ","Ẽ","Ê","Ế","Ề" ,"Ệ","Ể","Ễ");
		$uni[4] = array("ó","ò","ọ","ỏ","õ","ô","ố","ồ", "ộ","ổ","ỗ","ơ","ớ","ờ","ợ","ở","� �");
		$uni[5] = array("Ó","Ò","Ọ","Ỏ","Õ","Ô","Ố","Ồ", "Ộ","Ổ","Ỗ","Ơ","Ớ","Ờ","Ợ","Ở","� �");
		$uni[6] = array("ú","ù","ụ","ủ","ũ","ư","ứ","ừ", "ự","ử","ữ");
		$uni[7] = array("Ú","Ù","Ụ","Ủ","Ũ","Ư","Ứ","Ừ", "Ự","Ử","Ữ");
		$uni[8] = array("í","ì","ị","ỉ","ĩ");
		$uni[9] = array("Í","Ì","Ị","Ỉ","Ĩ");
		$uni[10] = array("đ");
		$uni[11] = array("Đ");
		$uni[12] = array("ý","ỳ","ỵ","ỷ","ỹ");
		$uni[13] = array("Ý","Ỳ","Ỵ","Ỷ","Ỹ");
		
		for($i=0; $i<=13; $i++) {
			$text = str_replace($uni[$i],$chars[$i],$text);
		}	
		return strtolower($text);
	}	
	
	
	//stripslashes custom
	function stripslash($str){

		return str_replace(array("\\","'"),"",$str);
	}

	// get request
	function getRequest($get){
		return addslashes($get);
	}
	
	
	function checkPermision($level=0){
		if(isset($_SESSION['id_group']) && $_SESSION['id_group']<=$level)
			return true;
		return false;
	}
	
	function curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}
	
	function encryptPwdUser($str='') {
		 return md5(sha1(addslashes($str)));
	}
 }

?>