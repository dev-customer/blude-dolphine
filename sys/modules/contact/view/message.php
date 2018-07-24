<?php if(!defined('DIR_APP')) die('Your have not permission'); ?> 
<script type="text/javascript">
	$( document ).ready(function() { 
		/* Open when someone clicks on the span element */
		$("body").on( "click", ".btn-item-view", function(e){ 
			$('#myNav .overlay-content').html('Loading...');
			$id = $(this).attr('data-id');	 
			$.post( "ajax.php?module=loadContactMessageItem", {'id': $id}, function(data) {  
				$('#myNav .overlay-content').html(data);  
				return false;
			});	   
			$("#myNav").css('width',"100%");
		});  
	}); 
</script>   
<div class="box">  
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><?= MENU_MANAGE.' '.MENU_MESSAGE ?></h2> 
	  <h2 class="col-md-6 text-right modBtn"><?php Admin::button('delete'); ?></h2>
    </div>
	
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="alert alert-danger text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
 
    
	<form id="frm_list" name="frm_list" method="post" action="index.php?p=contact&q=message">
      <table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
			<thead>
				<tr class="bg-sdt1"> 
					<th width="1"><input type="checkbox" onclick="$('input[name*=\'id\']').attr('checked', this.checked);"></th>
					<th>No</th>
					<th><?= LANG_NAME;?></th>
					<th>Email</th>
					<th>Phone</th> 
					<th>Message</th>
					<th><?= LANG_DATE?></th>
					<th width="150" >Action</th> 
				</tr>
              
			</thead>
			<?php 
			if( empty($rows) ) { ?>
            <tr>
                <td class="center" colspan="20"><?= LANG_NO_RESULT; ?></td>
            </tr>
			<tbody>
			<?php
            }
			else {
				$page = isset($_GET['page'])? $_GET['page']: 1;
				$i= ($page-1)*PAGE_ROWS + 1;
                foreach($rows as $row) {	?>
				   <tr >
						<td class="bg-sdt1"><input type="checkbox" name="id[]" value="<?= $row['id_msg']; ?>" class="chkbox"> </td>
						<td> <?= $i; ?> </td>
						<td><?= $row['name']?></td>
						<td><?= $row['email'];?></td>
						<td><?= $row['tel'];?></td> 
						<td><div class="alert alert-warning"><?= $row['content']?></div></td>
						<td><?= date('d-m-Y', strtotime($row['date']))?></td>				  
						<td>
						<?php 
						echo '<a class="btn bg-sdt2 deleteAjx" data-id="contact_msg#id_msg#'.$row['id_msg'].'"><span class="glyphicon glyphicon-remove"></span></a>';
						Admin::view($row['id_msg']); 
						?>
						</td>						
	    			</tr>
					 <?php  $i++;
				}
			 } ?>
			</tbody>
      </table> 
      <?= $paging; ?>
       <input type="hidden" name="task" id="task" value="" />
  </form>
</div> 
			
            
