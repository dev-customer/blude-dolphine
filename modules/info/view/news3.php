<?php if(!defined('DIR_APP')) die('You have not permission');
global $json, $mod, $cNews; ?>


<div class="container-fluid side-main side-news">
	<div class="container">	  
		<div class="col-sm-3 col-md-3 category-side">
			<?php
				$mod->load('info', 'news', 'category');
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
					foreach($rows as $key => $row):
						$link = $row['link'] != '' ? $row['link'] : LINK_INFO_ITEM.$row['alias'].'.html';
						$title =  $json->getDataJson1D($row['title'], $_SESSION['dirlang']);
						$imageList = json_decode($row['imageList']);
						?>
						<div id="galleryList<?=$key?>" class="col-sm-6 col-md-4 text-center pointer galleryList">
							  <div class="thumbnail zoomItemImg">  
									<a href="<?=URL_UPLOAD.'content/'.$row['image']?>">
										<?=
										showImg(DIR_UPLOAD.'/content/'.$row['image'], 'content/'.$row['image'], 'no-image.png', '', '', $title, $title, 'img-responsive', 'style="width:100%"');
										?>
									</a>
									
							  </div>
							  <div class="caption clearfix">
								<p><i class="fa fa-picture-o"></i> (<?=count($imageList)?> item)</p>
								<h5 class="clr-sdt2"><?=$title?></h5>
								<?php
								if(count($imageList) > 0):  ?>
									<div class="hidden">
										<?php
										foreach($imageList as $key2 => $value):  
											$imgUrl = is_file(DIR_UPLOAD.'/content/'.$value)? URL_UPLOAD.'content/'.$value: URL_UPLOAD.'no-image.png';
											?> 
											<a href="<?=$imgUrl?>" title="Image"><img src="<?=$imgUrl?>" alt="..." /> </a>
											<?php
										endforeach;
										?>
									</div>
								<?php
								endif;
								?>
							  </div>							
						</div>
						<script>
							$(document).ready(function() {
								$('#galleryList<?=$key?>').magnificPopup({
									delegate: 'a',
									type: 'image',
									tLoading: 'Loading image #%curr%...',
									mainClass: 'mfp-img-mobile',
									gallery: {
										enabled: true,
										navigateByImgClick: true,
										preload: [0,1] // Will preload 0 - before current, and 1 after the current image
									},
									image: {
										tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
										titleSrc: function(item) {
											return item.el.attr('title') + '<small></small>';
										}
									},
									zoom: {
										enabled: true,
										duration: 500 // don't foget to change the duration also in CSS
									},
									closeMarkup: '<button title="%title%" class="mfp-close img-circle" style="padding-right:inherit">x</button>',
								});
								 
							});
							

						</script> 
					<?php
					endforeach;?> 
					<style>
					.galleryList:hover{ color:#0170b1; background: rgba(204, 204, 204, 0.15) !important}
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

<link rel="stylesheet" href="<?=TEMPLATE?>js/magnific/magnific-popup.css">
<script src="<?=TEMPLATE?>js/magnific/jquery.magnific-popup.min.js"></script>
