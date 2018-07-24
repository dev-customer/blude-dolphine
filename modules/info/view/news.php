<?php if(!defined('DIR_APP')) die('You have not permission');
global $json;  ?>


<div class="container-fluid side-main side-news">
	<div class="container">	  
		<div class="col-sm-3 col-md-3 category-side bxShadow">
			<?php
				$mod->load('info', 'news', 'newsSide');
			?>
		</div>		 
		<div class="col-sm-9 col-md-9">			
			<div class="panel shadow bxShadow">
				<div class="spacer10"></div>
				<?php
				if(count($rows) > 0)
				{ ?>

				 <ul class="list-group list-unstyled">
					<?php
					foreach($rows as $row):					 
						$link=  $row['link'] != '' ? $row['link'] : LINK_INFO_ITEM.$row['alias'].'.html';
						$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
						$tmp = explode('watch?v=', $row['link']);
						?>
						<li class="clearfix">
							<div class="col-sm-4 col-md-4 thumbnail">
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
							<div class="col-sm-8 col-md-8 caption">
								<h4 style="margin:inherit"><a class="clr-sdt1" href="<?=$link?>"><?=$title?></a></h4>
								<p><?= $mod->cutstring(strip_tags($row['content_'.$_SESSION['dirlang']]), 400)?></p>
								<p><br /><br /><a href="<?=$link?>" class="btn bg-sdt1 btn-more pull-right"><?=READ_MORE?>...</a></p>
							</div>
							<hr class="clearfix" style="border-top: 1px solid rgba(238, 238, 238, 0.34); width: 100%;" />
						</li>
					<?php
					endforeach;?>
				</ul>  
				<?php
				}else 
					echo '<div class="alert alert-danger">'.LB_NO_RESULT.'</div>';
				
				echo $paging?>
			</div> 			
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