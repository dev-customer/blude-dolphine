<?php if(!defined('DIR_APP')) die('Your have not permission'); 
global $json; ?>
<div class="box">  
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><?= MENU_MANAGE.' '.MENU_CONTACT ?></h2> 
	  <h2 class="col-md-6 text-right modBtn" ></h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?> 
    
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=contact&q=contact">
      <table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
          <thead>
              <tr class="bg-sdt1"> 
                 <th width="5"><strong><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></strong></th>
                  <th width="3"><strong>No</strong></th>
                  <th><strong> <?= LANG_TITLE;?></strong></th>
				  <th>Image</th>
				  <th><strong> Email</strong></th>
				  <th><strong> <?= LANG_ADDRESS?></strong></th>
                  <th width="150" >Action</th>
              </tr>
              
          </thead>
      	<?php if( empty($rows) ) { ?>
            <tr >
                <td class="center" colspan="20"><?= LANG_NO_RESULT; ?></td>
            </tr>
        <?php
            }
			else
			{
                $i=1;
                foreach($rows as $row) {	?>
					<tr >
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_contact']; ?>" class="chkbox"> </td>
						<td> <?= $i?> </td>
						<td><?=$json->getDataJson1D($row['name'], $_SESSION['dirlang'])?></td>
						<td>
						<?=
						showImg('../'.DIR_UPLOAD.'/'.$row['image'], $row['image'], 'no-image.png', 30, 30, "", "", 'zoom img-circle', '');
						?>
						</td>
						<td><?= $row['email'];?></td>
						<td><?=$json->getDataJson1D($row['address'], $_SESSION['dirlang'])?> </td>
						<td><?php Admin::edit($row['id_contact']); ?> </td>
					  </tr>
					  <?php  $i++;
				}
			 } ?>
          
        </table>
       <input type="hidden" name="task" id="task" value="" />
       </form>
  </div> 
			
            