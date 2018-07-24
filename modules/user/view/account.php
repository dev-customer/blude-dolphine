<?php if(!defined('DIR_APP')) die('Your have not permission');
global $account, $mod; ?>
<style>
.frmAccount fieldset legend{padding:3px}
</style>

<div class="container-fluid"> 
	<div class="container"> 
		<div class="col-md-10 panel panel-default clearfix" style="float:inherit; margin:auto"> 
			<br/>
			<h4 class="text-uppercase text-center clr-sdt1"><label>Quản lý thông tin</label></h4>
			<hr>
			<div class="col-md-3">
				<?php
					$mod->view('user/view/left');
				?>				
			</div> 
			<div class="col-md-9"> 
				<?php 
				if(@$_SESSION['message']):?>
					<div class="alert alert-warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
				<?php 
				endif; ?> 
				<form class="frmAccount" method="post" enctype="multipart/form-data" > 
					<fieldset class="panel panel-default col-md-12"><legend class="bg-sdt1"><span class="glyphicon glyphicon-info-sign"></span> Thông tin cơ bản</legend>
						<div class="form-group" >
							<input name="firstname" class="form-control"  placeholder="Họ" value="<?=@$account['firstname']?>" required/>
						</div> 
						<div class="form-group" >
							<input name="lastname" class="form-control"  placeholder="Tên" value="<?=@$account['lastname']?>" required/>
						</div> 
						<div class="form-group" >
							<input name="email" class="form-control"  placeholder="Email" value="<?=@$account['email']?>"/>
						</div> 
						<div class="form-group" >
							<input type="password" name="password" class="form-control"  placeholder="Mật khẩu" <?=$_GET['m']=='register' ? 'required':''?> />
						</div>
						<div class="form-group" >
							<div class="input-group col-md-8" style="float:left">
								<label class="input-group-addon bg-sdt1"> Hình ảnh</label>
								<input type="file" name="image" class="form-control" id="imageUpload" accept="image/*"  />
								<div class="input-group-addon" style="padding:6px 20px"> 
								<?=
								showImg(DIR_UPLOAD_NAME.'/avatars/'.$account['image'], 'avatars/'.$account['image'], 'no-image.png', 20, 20, "", "", '', '');
								?>                    
								<span class="glyphicon glyphicon-remove actDelImgItem" role="button" data-src="avatars/<?=$account['image']?>"></span>
								</div> 
							</div>  
						</div> 
						<br/>
						<div class="form-group" >
							<button type="submit" class="btn btn-send bg-sdt1 pull-right"><span class="glyphicon glyphicon-chevron-down"></span> Cập nhật</button> 
						</div>
						<br/>
					</fieldset>	
					
					<input type="hidden" name="old_img" value="<?= @$account['image']?>" /> 
					<input type="hidden" name="actExec" value="updateAccount" />
				</form>
				<br/>
			</div> 
		</div>
	</div>
</div>  
<script type="text/javascript">
	//limit media upload
	var file = document.getElementById('imageUpload');
	file.onchange = function(e){
		var ext = this.value.match(/\.([^\.]+)$/)[1];
		switch(ext)
		{
			case 'jpg':
			case 'bmp':
			case 'gif':
			case 'png':
			case 'tif':
				alert('allowed');
				break;
			default:
				alert('not allowed');
				this.value='';
		}
	};	
</script>   
