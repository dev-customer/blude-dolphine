<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json;?>
<div class="box">
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> <?=MENU_MANAGE.' '.MENU_SLIDE  ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('add'); ?></h2>
    </div>

    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
 
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=media&q=slide">
		<table class="table table-hover tblList" cellspacing="0" cellpadding="0"><!-- Table -->
			<thead>
				<tr class="bg-sdt1"> 
					<th width="5"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th>No</th>
					<th><?=LANG_IMAGE?></th>
					<th><?=LANG_TITLE?></th>
					<th><?=LANG_ORDER?> &nbsp; <i class="fa fa-save submitform" style="color: yellow;"></i></th>
					<th class="col-md-1 text-right">Action</th> 
				</tr> 
			</thead>
			<tbody>
			<?php if( empty($rows) ) { ?>
            <tr>
                <td colspan="6"><?=LANG_NO_RESULT; ?></td>
            </tr>
			<?php
            }
			else{ 
                $i=1;
				foreach(@$rows as $row) 
				{	?>
					<tr>
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?=$row['id_slide']; ?>" class="chkbox"> </td>
						<td> <?= $row['id_slide']?> </td>
						<td>
                        <?=
						showImg('../'.DIR_UPLOAD.'/slide/'.$row['image'], 'slide/'.$row['image'], 'no-image.png', 50, 50, "", "", '', '');
						?>
                        </td>
						<td><?=$json->getDataJson1D($row['title'], $_SESSION['dirlang'])?></td>
						<td class="col-md-1"><input type="number" class="form-control" min="1" name="<?= $row['id_slide']?>_id" size="2" value="<?= $row['orderring']; ?>">
						 <td>
						 <?php 	
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="slide#id_slide#'.$row['id_slide'].'"><span class="glyphicon glyphicon-remove"></span></a>';
							 Admin::edit($row['id_slide']);
						 ?>
                         </td> 
					</tr>
				<?php	
				} 
		  } // end else
		  ?>
        </tbody>
	</table>
	<input type="hidden" name="task" id="task" value="" />
   </form>
</div> 
			
            
