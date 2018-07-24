<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod, $cNews; ?> 

<div class="container-fluid side-main">
	<div class="container">	
		<div class="panel">			
			<?php
			if(count($rows) > 0)
			{  ?>
				<div class="panel clearfix">
					<?php 
					foreach($rows as $key => $row):  
						$title =  $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
						$tmp = explode('watch?v=', $row['link']);
						?>
						<div class="col-sm-6 col-md-3 text-center">
							<?php
							 if(strpos($row['link'], 'youtube') > 0) { ?>								
								<div id="<?=$tmp[1]?>" class="hidden youtubeVideoLoader"></div>							 
								<div id="videogallery<?=$key?>">
									<a rel="#voverlay" href="http://www.youtube.com/v/<?=$tmp[1]?>?autoplay=1" title="football;">
									<img src="https://img.youtube.com/vi/<?=$tmp[1]?>/mqdefault.jpg" alt="football;" /><span></span></a>							 
								</div>
							<?php
							 }
							 ?> 
						</div>
					<?php
					endforeach;
					?> 
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
