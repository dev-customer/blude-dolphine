<?php if(!defined('DIR_APP')) die('Your have not permission'); ?>
<div class="box"> <!-- Box begins here -->
	<div class="headMod bg-sdt1">
      <h2 class="modTitle"><?= MENU_MESSAGE?></h2> 
	  <h2 class="modBtn" >  <?php Admin::button('publish, add, delete'); ?> </h2>
    </div>
    <?php 
	if(@$_SESSION['message']):?>
    	<div class="warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php 
	endif; ?>
    
   <form method="post" enctype="multipart/form-data" id="frm_list" name="frm_list" action="index.php?p=contact&q=contact">
		<div id="tab_general">
		    <table class="tblList" >
               <tr>
                    <td><?= LANG_NAME ?></td>
                    <td><?=$row['name']?></td>
                </tr>           		
               <tr>
                    <td>Subject</td>
                    <td><?=$row['subject']?></td>
                </tr>           		
               <tr>
                    <td>Email</td>
                    <td><?=$row['email']?></td>
                </tr>           		
               <tr>
                    <td>Date</td>
                    <td><?=date("His d/m/Y", strtotime($row['date']))?></td>
                </tr>           		
               <tr>
                    <td>Message</td>
                    <td><?=$row['content']?></td>
                </tr>           		
            </table>
			</div>
        </form>
  </div> <!-- END Box-->
