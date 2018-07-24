<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod;   
$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
?>

<div class="container-fluid side-main side-detail bxShadow">
	<div class="container">	  		
		<div class="col-sm-3 col-md-3 category-side">
			<?php
				$mod->load('info', 'news', 'newsSide');
			?>
		</div>
		<div class="col-sm-9 col-md-9 content-detail content-detail<?=$row['id_art']==27? '-about':''?>">
		<?php
		if(!empty($row))
		{ ?>
			<div class="panel panel-default shadow bxShadow"> 
				<div class="panel-body shadow content-data">
						<div class="col-md-6" style="padding-left:0">
						<?=
						showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', $title, $title, '', 'style="float:left;    margin-bottom: 10px;"');
						?></div>
						<h4 class="text-uppercase clr-sdt1"><?=$title?></h4>
						<?=$row['content_'.$_SESSION['dirlang']]?>
				</div>
				 
				
			</div> 
		<?php
		}else{
			echo '<div  class="alert alert-danger">'.LB_NO_RESULT.'</div>';
		}
		?>
		</div>

	</div>
</div>

