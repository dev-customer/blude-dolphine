<?php if(!defined('DIR_APP')) die('Your have not permission'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.act-create-alias').click(function(){
		if(confirm('(*)CẢNH BÁO: Việc tạo link thân thiện chỉ nên thực hiện khi đã hoàn thiện nội dung'))
		{ 
			$tbl = $(this).attr('data-id');	
			$.post('ajax.php?module=createAlias', {'tbl': $tbl}, function(data){ alert('Success!'); });
		}
	}); 
	
	$('.act-db-backup').click(function(){
		if(confirm('(*)Sao lưu Database trên Hositng'))
		{ 
			$.post('ajax.php?module=backupDB',  function(data){  alert('File DB : <?=BASE_NAME.DIR_APP?>/'+data); });
		}
	}); 
	$('.act-reset-data').click(function(){
		if(confirm('(*)Cảnh báo: Việc này chỉ thực hiện khi Website mới bắt đầu'))
		{ 
			$.post('ajax.php?module=resetData',  function(data){  alert('Success!');; });
		}
	}); 
	
});
</script>

<div class="box">
	<div class="headMod bg-sdt1">
      <h2 class="col-md-6 text-left alert modTitle"><span class="glyphicon glyphicon-bookmark"></span> Tools</h2> 
	  <h2 class="col-md-6 text-right modBtn"></h2>
    </div> 
 
	<table class="table table-hover tblList" cellspacing="0" cellpadding="0"> 
		<thead>
			<tr class="bg-sdt1"> 
				<th class="bg-sdt1" width="5">No</th>  
				<th>Name</th>  
				<th>Action</th>
			</tr> 
		</thead>
		<tbody>
			<tr>
				<td class="bg-sdt1">1</td>  
				<td>Link Alias(SEO)  </td>  
				<td>
					<a class="btn bg-sdt1 act-create-alias" data-id="content">News</a> 
					<a class="btn bg-sdt1 act-create-alias" data-id="product">Shop</a>
				</td>  
			</tr>  
			<tr>
				<td class="bg-sdt1">2</td>  
				<td>Backup Database</td>  
				<td>
					<a class="btn bg-sdt1 act-db-backup">Backup</a>
				</td>  
			</tr>  
			<?php
			if($_SESSION['id_group']<=0):?>
			<tr>
				<td class="bg-sdt1">3</td>  
				<td>Reset Data</td>  
				<td>
					<a class="btn bg-sdt1 act-reset-data">Reset</a>
				</td>  
			</tr>  
			<?php
			endif;
			?>
		</tbody>
	</table>
</div> 
			
            
