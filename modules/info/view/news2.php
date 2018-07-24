<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod, $cNews; ?>


<div class="container-fluid side-main side-news">
	<div class="container">	  
		<div class="col-sm-3 col-md-3 category-side">
			<?php
				$mod->view('info/view/category');
			?>			
			<style>
			.category-side .panel-heading:hover{ background-color: #ccc}
			</style>
			
			<div class="panel text-center">
				<?php
					foreach($cNews as $row) 
						if($row[0] == $category['id_parent']) 
							echo showImg(DIR_UPLOAD.'/content/'.$row[6], 'content/'.$row[6], 'no-image.png', '', '', '', '', '', '');
				?>
			</div>
		</div>		 
		<div class="col-sm-9 col-md-9 news-list-right">			
			<?php
			if(count($rows) > 0)
			{  ?>
				<div class="panel clearfix">
					<?php
					foreach($rows as $row):
						$link = $row['link'] != '' ? $row['link'] : LINK_INFO_ITEM.$row['alias'].'.html';
						$title =  $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
						$tmp = explode('watch?v=', $row['link']);
						?>
						<div class="col-sm-6 col-md-4 text-center">
							  <div class="thumbnail zoomItemImg">  	
								<?php
								 if (strpos($link, 'youtube') > 0) { ?>
									<div id="<?=$tmp[1]?>" class="youtubeVideoLoader"></div>
								 <?php
								 }else{ ?>
									<a href="<?=$link?>">
										<?=
										showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', $title, $title, 'img-responsive', 'style="width:100%"');
										?>
									</a>
								 <?php
								 } 
								 ?>
							  </div>
							  <div class="caption clearfix">
								<h5><a class="clr-sdt2" href="<?=$link?>"><?=$title?></a></h5>
								<p class="clr-sdt1 priceFormat txtPrice hidden"><?=$row['price']?></p> 
							  </div>							
						</div>
					<?php
					endforeach;?> 
					<style>
					.news-list-right .caption {height:60px}
					</style>
				</div>	 
					
				<div class="row">
					<?=$paging?>
				</div>
				
			<?php
			}else 
				echo '<div  class="alert alert-danger">'.LB_NO_RESULT.'</div>';
			?>				
			
		</div>
	</div>
</div>


<link href="<?=TEMPLATE?>js/youtube-Video/css/YouTubeDefaultImageLoader.css" rel="stylesheet" type="text/css">
<script src="<?=TEMPLATE?>js/youtube-Video/js/YouTubeDefaultImageLoader.js"></script>

<div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
		<div id="videoModalContainer"> 
		</div>
	  </div>
	  <div class="modal-footer">
		<button id="CloseModalButton" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>