<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>
<div class="box">
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?= MENU_MANAGE.' '.MENU_CATALOG ?></h2> 
	  <h2 class="col-md-6 text-right modBtn" > <?php Admin::button('add'); ?>  </h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>    
    
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=location&q=location">
		<table class="tbltop" cellspacing="0" cellpadding="0" border="1" > 
			<tr>
				<td class="text-right"> 
					<ul class="list-inline text-right actToplocation"> 
						<li><?= $filter_cat?></li>  
						<li>
							<div class="input-group">
								<a href="javascript:void(0);" class="btn bg-sdt1" id="button_reset"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> <?= LANG_ALL ?></a>				
								<input class="attr-reset" type="hidden" value="location-publish" />
							</div>
						</li>
					</ul> 
				</td>	
			</tr>
		</table>
		
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
          <thead>
              <tr class="bg-sdt1"> 
                 <th width="5"><strong><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></strong></th>
                  <th><strong>ID</strong></th>
                  <th><?= LANG_TITLE;?></th>
                  <th>Image</th>
                  <th><strong> <?= ucfirst(MENU_ARTICLE)?></strong></th>
                  <th><?= LANG_ENABLE;?></th>
                  <th><?= LANG_ORDER?>&nbsp; <i class="fa fa-save submitform" style="color: yellow;"></i></th>
                  <th class="col-md-1 text-right" >Action</th>
              </tr>
          </thead>
		  <tbody>
			<?php if( empty($rows) ) { ?>
            <tr>
                <td class="center" colspan="20"><?= LANG_NO_RESULT; ?></td>
            </tr>
			<?php
            }
			else 
			{ 
				$listid ='';
                foreach($rows as $row) 
				{
					//$num_art = $db->num("SELECT id_art FROM #__location WHERE id_location = ".$row[0]);
					$listid .= '-'.$row[0];?>
					<tr>
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row[0]; ?>" class="chkbox"> </td>
						<td> <?= $row[0];?> </td>
						<td><?= $row[1]?> </td>
						<td><?=
							showImg('../'.DIR_UPLOAD.'/location/'.$row[4], 'location/'.$row[4], 'no-image.png', 30, 30, "", "", 'zoom img-circle', '');
							?>
						</td>						
						<td><?=$num_art?></td>
						<td>
							<?php  
							if($row[0] != 69): ?>
								<img data-id="location#id_location#<?=$row[0]?>" data-state="<?=$row[3]?>" src="images/status-<?=$row[3]?>.png"  class="pointer change-status-record" />						
							<?php
							endif;
							?>
 						</td>
						<td class="col-md-1"><input type="number" class="orderring form-control" min="1" name="<?= $row[0]?>_id" size="2" value="<?= $row[2]; ?>"></td>	 
						<td>
						<?php  
						if($row[5] == 1)
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="location#id_location#'.$row[0].'"><span class="glyphicon glyphicon-remove"></span></a>';
						if($row[6] == 1)
							Admin::edit($row[0]); 
						?>  
                        </td>
					</tr>
			<?php	
			}
		}?>
		</tbody>
    </table>
     <?php //echo $paging; ?>
    <input type="hidden" name="listid"  value="<?=$listid?>" />      
    <input type="hidden" name="task" id="task" value="" />
    </form>
</div> 
			
            
