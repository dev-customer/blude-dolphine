<?php if(!defined('DIR_APP')) die('Your have not permission'); ?>
 

<div class="box"> 
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><?= MENU_MANAGE.' '.MENU_NEWSLETTER ?></h2>
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('delete'); ?></h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
     
    <div class="result" id="result" style="display:none; position:relative; padding:10px; border:1px solid #CCCCCC"></div>
	<form id="frm_list" name="frm_list" method="post" action="<?= $mod->url('index.php?p='.$_GET['p'].'&q='.$_GET['q'])?>">
      <table class="table table-hover tblList" cellspacing="0" cellpadding="0"><!-- Table -->
          <thead>
              <tr class="bg-sdt1"> 
                 <th width="5"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
                  <th width="3">No</th>
                  <th class="hidden"><strong> <?= LANG_NAME;?></strong></th>
				  <th><strong> Email</strong></th>
				  <th><strong> <?= LANG_DATE?></strong></th>
                  <th width="100" >Action</th> 
              </tr> 
          </thead>
      	<?php if( empty($rows) ) { ?>
            <tr >
                <td class="center" colspan="20"><?= LANG_NO_RESULT; ?></td>
            </tr>
        <?php
            }
			else {
				$page = isset($_GET['page'])? $_GET['page']: 1;
				$i= ($page-1)*PAGE_ROWS + 1;
                foreach($rows as $row) {	?>
				   <tr >
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_news']; ?>" class="chkbox"> </td>
						<td> <?= $row['id_news'] ?> </td>
						<td class="hidden"><a class="viewMessage" id="<?= $row['id_news']; ?>" style="cursor:pointer; color:#006699" >
							<?= $row['name'];?></a>
						</td>
						<td><?= $row['email'];?></td>
						<td><?= date('h:i d-m-Y', strtotime($row['date']))?></td>				  
						 <td>
						 <?php 
							echo '<a class="btn bg-sdt2 deleteAjx" data-id="contact_newsletter#id_news#'.$row['id_news'].'"><span class="glyphicon glyphicon-remove"></span></a>';
						 ?>
						 </td> 
					</tr>
					  <?php  $i++;
				}
			 } ?>
          
      </table>
		
      
      <?= $paging; ?>
       <input type="hidden" name="task" id="task" value="" />
  </form>
  </div> 
			
            
