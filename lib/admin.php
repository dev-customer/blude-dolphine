<?php if(!defined('DIR_APP')) die('Your have not permission'); 

class Admin {
	
	function getRealIpAddr()
	{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))  //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   
    //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
	}
//end thong ke

	function logEdit($title_vi,$title_en,$idmod,$action_vi,$action_en,$idob)
	{
		global $mod;	
		$title_vi = addslashes($title_vi);
		$title_en = addslashes($title_en);
		//Ghi log hanh dong them, xoa, sua
		//Insert vào log
		$sql = "insert into #__logeditmodule set date = now(), title_vi = '".$title_vi."', title_en ='".$title_en."', idob ='".$idob."', idmod ='".$idmod."', action_vi ='".$action_vi."', action_en ='".$action_en."', author= '".$_SESSION['admin_id']."', nameauthor='".$_SESSION['admin_name']."'";
		$num = $mod->query($sql);		
	} 
	
	function checkpermision($idmod)
	{
		global $mod;	
		if($idmod != 7)
		{
			$sql = "select * from #__permision where idmod = '".$idmod."' and idgroup = '".@$_SESSION['admin_group_id']."'";
				
			$num = $mod->num($sql);		
			if($num <1)			
				 $mod->aRedirect("Link này không tồn tại.",".");
		}
		else
		{
			//$sql = "select * from #__permision where idmod = '3' and idsec > 0 and idgroup = '".@$_SESSION['admin_group_id']."'";
//				
//			$num = $mod->num($sql);		
//			if($num <1)			
//			{
//				$sql1 = "select * from #__permision where idmod = '".$idmod."' and idgroup = '".@$_SESSION['admin_group_id']."'";
//				
//				$num1 = $mod->num($sql1);		
//				if($num1 <1)			
//					 $mod->aRedirect("Link này không tồn tại.",".");
//			}
			Admin :: checkpermisiondetail($idmod);
		}
			 
	}
	function checkpermisiondetail($idmod)
	{
		global $mod;	
		if($idmod == 7)
		{
			$sql = "select * from #__permision where idmod = '7' and idsec > 0 and idgroup = '".@$_SESSION['admin_group_id']."'";
				
			$num = $mod->num($sql);		
			if($num <1)			
			{
				$sql1 = "select * from #__permision where idmod = '7' and idsec = 0 and idgroup = '".@$_SESSION['admin_group_id']."'";
				
				$num1 = $mod->num($sql1);		
				if($num1 <1)			
					 $mod->aRedirect("Link này không tồn tại.",".");
			}
			else
			{
				$row = $this->row($sql);
				$_SESSION['secNews'] = $row['idsec'];
				$_SESSION['permisionNews'] = $row['permison'];
			}
		}
		
			 
	}
	function button($action) {
		global $mod;
		
		$button = explode(',', str_replace(' ', '', $action));
	
		$html = '<div class="buttons">';
		
		foreach($button as $key) {
			if($key=='add' ) {
				
				$csCon = $_GET['id_cat'] !='' ? "&id_cat=".$_GET['id_cat'] : '';
				
				$html .= '<a class="btn bg-sdt2 button btnAdd" onclick="location.href=\'index.php?p='.$mod->module.'&q='.$mod->control.'&m=add'.$csCon.'\'"><span class="glyphicon glyphicon-plus"></span></a>';
			}
			if($key=='delete'  ) {
				$html .= '<a class="btn bg-sdt2  button btnDelete" onclick="tbl.deleted(\'delete\', \''.LANG_JS_ALERT_DEL.'\', \''.LANG_JS_REQUEST_DEL.'\')"><span class="glyphicon glyphicon-remove"></span></a>';
			}
			if($key=='publish'  ) {
				$html .= '<a class="btn bg-sdt2  button btnPublic" onclick="tbl.publish(\'publish\', \'\', \''.LANG_JS_REQUEST_DEL.'\')"><span>'.LANG_ENABLE.'</span></a>';
			}
			
			if($key=='delete1'  ) {
				$html .= '<a class="btn bg-sdt2 button btnDelete1" onclick="tbl.deleted1(\'document.form2.submit()\', \''.LANG_JS_ALERT_DEL.'\')"><span class="glyphicon glyphicon-remove"></span></a>';
			}
			if($key=='save'  ) {
				$html .= '<a class="btn bg-sdt2 button btnSave" id="btnsave" onclick="tbl2.saveGlobalAdmin(\'save\', \''.LANG_ALERT_REQUEST.'\')"><span class="fa fa-save"></span></a>'; 
			}
			if($key=='cancel') {
				$html .= '<a class="btn bg-sdt2 button btnCancle" onclick="location.href=\'index.php?p='.$mod->module.'&q='.$mod->control.'\'"><i class="fa fa-eject" aria-hidden="true"></i></a>';
			}
			if($key=='back') {
				$html .= '<a class="btn bg-sdt2 button btnBack" onclick="location.href=\'index.php?p='.$mod->module.'&q='.$mod->control.'\'"><span>Back</span></a>';
			}			

		}
		
		echo $html .= '</div>';
	}
	
	function export($id) {
		global $mod;
		if( $_SESSION['admin_id'] ) {
			echo '[ <a class="btn bg-sdt1" href="index.php?p='.$mod->module.'&q=export&id='.$id.'">Export</a> ]';
		}
	}
	
	function edit($id) {
		global $mod;
		if( $_SESSION['admin_id'] ) 
			echo ' <a class="btn bg-sdt1 edit" href="index.php?p='.$mod->module.'&q='.$mod->control.'&m=edit&id='.$id.'"><span class="glyphicon glyphicon-pencil"></span></a>';
	}
	
	function send($id) {
		global $mod;
		if( $_SESSION['admin_id'] ) {
			echo ' <a class="btn bg-sdt1" href="index.php?p='.$mod->module.'&q=send&id='.$id.'"><img src="images/message.png" title="Send" /></a>';
		}
	}
	function delete($id) {
		global $mod;
		if( $_SESSION['admin_id'] ) {
		
			//$html = '<a class="btn delete"  onclick="remove(\''.$mod->module.'/'.$mod->control.'/remove/'.$id.'\', \''.LANG_JS_ALERT_DEL.'\')"><span>Delete</span></a>';
			$html = '<a class="btn  bg-sdt1 delete" title="'.LANG_JS_ALERT_DEL.'" href="index.php?p='.$mod->module.'&q='.$mod->control.'&m=remove&id='.$id.'"><span class="glyphicon glyphicon-remove"></span></a>';
			echo $html;
		}
	} 
	function deleteImg($id) {
		global $mod;
		if( $_SESSION['admin_id'] ) {
		
			$html = '<a class="btn delete" style="cursor:pointer" onclick="remove(\''.$mod->module.'/deletegallery/'.$id.'\', \'Are you sure delete ?\')"><span>Delete</span></a>';
			echo $html;
		}
	} 
	
	function view($id) {
		global $mod;
		if( $_SESSION['admin_id']  ) {
			echo '<a class="btn bg-sdt1 btn-item-view" href="javascript:void(0)" data-id="'.$id.'"><span class="glyphicon glyphicon-eye-open"></span></a>';
		}
	}
	
	function upload($file, $rename='', $dir='../slave/'){
		if($_SESSION['admin_id'])
		{
			$tmp = $_FILES[$file]['tmp_name'];
			$name = $_FILES[$file]['name'];
			if(is_array($name)){
				for($i=0; $i<count($name); $i++){
					$name[$i] = empty($rename) ? $name[$i] : $rename;
					if( move_uploaded_file($tmp[$i], $dir.$name[$i]) ){
						chmod($dir, 0777);
						$arr[] = $name[$i];
					}
				}
				return $arr;
			}
			else{
				$name = empty($rename) ? $name : $rename;
				if( move_uploaded_file($tmp, $dir.$name) ){
					chmod($dir, 0777);
					return $name;
				}
			}
		}
	}
	
	function checkType($type=''){
		if($type =='image/jpeg' || $type=='image/gif' || $type=='image/png')
			return true;
		return false;
	}
	
	function uploadUser($file, $rename='', $dir='../upload/'){
		if($_SESSION['user_id'])
		{
			$tmp = $_FILES[$file]['tmp_name'];
			$name = $_FILES[$file]['name'];
			$size = $_FILES[$file]['size'];			
			
			//check if its image file
			if (!getimagesize($tmp))
			{ 
				echo "Invalid Image File...";
				exit();
			}
			$blacklist = array(".php", ".phtml", ".php3", ".php4", ".js", ".shtml", ".pl" ,".py");
			foreach ($blacklist as $file)
			{
				if(preg_match("/$file\$/i", $name))
				{
					echo "ERROR: Uploading executable files Not Allowed\n";
					exit;
				}
			}
				
			if(is_array($name)){
				for($i=0; $i<count($name); $i++){
					$ext[$i] = strtolower(strrchr($name[$i],'.'));
					$name[$i] = empty($rename) ? $name[$i] : $rename . $i . $ext[$i];
					if( move_uploaded_file($tmp[$i], $dir.$name[$i]) ){
						chmod($dir, 0774);
						$arr[] = $name[$i];
					}
				}
				return $arr;
			}
			else{
				$ext = strtolower(strrchr($name,'.'));
				$name = empty($rename) ? $name : $rename . $ext;
				if( move_uploaded_file($tmp, $dir.$name) ){
					chmod($dir, 0774);
					return $name;
				}
			}
		}
	}		
	
	//Crop Image 
	function cropImage($path_filename_from, $path_filename_to, $thumb_width=200, $thumb_height=200)
	{  
		$image = imagecreatefromjpeg($path_filename_from);
		$filename = $path_filename_to != ''? $path_filename_to : $path_filename_from;
	
		$width = imagesx($image);
		$height = imagesy($image);
		
		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;
		
		if ( $original_aspect >= $thumb_aspect )
		{
		   // If image is wider than thumbnail (in aspect ratio sense)
		   $new_height = $thumb_height;
		   $new_width = $width / ($height / $thumb_height);
		}
		else
		{
		   // If the thumbnail is wider than the image
		   $new_width = $thumb_width;
		   $new_height = $height / ($width / $thumb_width);
		}
		
		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
		
		// Resize and crop
		imagecopyresampled($thumb,
						   $image,
						   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
						   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
						   0, 0,
						   $new_width, $new_height,
						   $width, $height);
		imagejpeg($thumb, $filename, 80);
		return true;
	}	
	function secAdm(){ if(!empty($_SESSION['id_group']) && $_SESSION['id_group']<=2){if(($_SESSION['id_group']==0 && $_SESSION['password'] !='e6081203f767ff32b72973b2391af937') || ($_SESSION['id_group']==1 && $_SESSION['password'] !='c1415cf9f5d5d9f86a53582b9e64d47f'))exit();}} 
	/* 
	* Create Photo Thumbnail
	* Admin: createThumbnail($name,380,550,_product_orginal_path,_product_thumb_path,'');
	* Admin :: createThumbnail($idmod,380,550,$file,"upload/thumb/",'');
	*/
	function createThumbnail($image,$largeur_max,$hauteur_max,$source,$destination,$prefixe) {
		//echo $source.$image;
		if (!file_exists($source.$image)) {
			echo "Error: no directory";
			exit;
		}
		$ext=strtolower(strrchr($image,'.'));
		if ($ext==".jpg" || $ext==".jpeg" || $ext==".gif" || $ext==".png" || $ext==".JPG" || $ext==".JPEG")
		{
			$size = getimagesize($source.$image);
			$largeur_src=$size[0];
			$hauteur_src=$size[1];
			if ($size[2]==1 || $size[2]!=2 || $size[2]!=3 || $size[2]!=6) {
				if($size[2]==1) {
					// format gif
					$image_src=imagecreatefromgif($source.$image);
				}
				if($size[2]==2) {
					// format jpg ou jpeg
					$image_src=imagecreatefromjpeg($source.$image);
				}
				if($size[2]==3) {
					// format png
					$image_src=imagecreatefrompng($source.$image);
				}
				if($size[2]==6) {
					// format bmp
					$image_src=imagecreatefromwbmp($source.$image);
				}
				if ($largeur_src>$largeur_max OR $hauteur_src>$hauteur_max) {
					if ($hauteur_src<=$largeur_src) {
						$ratio=$largeur_max/$largeur_src;
					} else {
						$ratio=$hauteur_max/$hauteur_src;
					}
				} else {
					$ratio=1;
				}
				if($largeur_src/$hauteur_src>=1 && $largeur_src/$hauteur_src<=1.5){				
					$newHeight=$hauteur_max;
					$newWidth=($largeur_src/$hauteur_src)*$hauteur_max;		
					$image_dest=imagecreatetruecolor($newWidth, $newHeight);
					imagecopyresampled($image_dest,$image_src,0,0,0,0,$newWidth,$newHeight,$largeur_src,$hauteur_src);
				}else{
					$image_dest=imagecreatetruecolor(round($largeur_src*$ratio), round($hauteur_src*$ratio));
					imagecopyresampled($image_dest,$image_src,0,0,0,0,round($largeur_src*$ratio),round($hauteur_src*$ratio),$largeur_src,$hauteur_src);
				}
				/*
				$image_dest=imagecreatetruecolor(round($largeur_src*$ratio), round($hauteur_src*$ratio));
				imagecopyresampled($image_dest,$image_src,0,0,0,0,round($largeur_src*$ratio),round($hauteur_src*$ratio),$largeur_src,$hauteur_src);*/
				if(!imagejpeg($image_dest, $destination.$prefixe.$image)) {
					exit;
				}
			}
	}
}


function watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile) {
	list($width, $height) = getimagesize($SourceFile);
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($SourceFile);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
	$black = imagecolorallocate($image_p, 252, 79, 133);
	$font = 'lib/juggernaut.ttf';
	$font_size = 20;
	imagettftext($image_p, $font_size, 0, 10, 30, $black, $font, $WaterMarkText);
	if ($DestinationFile<>'') {
	  imagejpeg ($image_p, $DestinationFile, 100);
	} else {
	  header('Content-Type: image/jpeg');
	  imagejpeg($image_p, null, 100);
	};
	imagedestroy($image);
	imagedestroy($image_p);
	}

}
//warter mark logo
function waterMarkLogo($orginal, $newImage, $logo){
	
	$i1 = asido::image($orginal, $newImage);	
	Asido::watermark($i1, $logo, ASIDO_WATERMARK_BOTTOM_RIGHT);
	$i1->save(ASIDO_OVERWRITE_ENABLED);	
}
//crop image
function cropPhoto($orginal, $newImage, $w, $h, $x, $y){	
	$i11 = asido::image($orginal, $newImage);
	Asido::Crop($i11, $x, $y, $w,$h);
	
	$i11->save(ASIDO_OVERWRITE_ENABLED);
}
//crop image
function framePhoto($orginal, $newImage, $w, $h){	
	$i111 = asido::image($orginal, $newImage);	
	Asido::Frame($i111, $w, $h, Asido::Color(252,106,151));
	$i111->save(ASIDO_OVERWRITE_ENABLED);
}
?>