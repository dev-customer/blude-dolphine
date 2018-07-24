<?php if(!defined('DIR_APP')) die('Your have not permission'); 
?>
<script>
$(document).ready(function(){ 
	$('#submit_btn').click(function(){
		if($('#username').val()==''){
			alert('Yêu cầu nhập tên đăng nhập');
			return false;
		}
		else{
			document.contact.submit();
		}
	}); 
	$('#reset').click(function(){
			document.contact.reset();
	}); 
});

</script>
<div class="container-fluid"> 
	<div class="container"> 
		<div class="col-md-7 panel panel-default clearfix" style="float:inherit; margin:auto">
			<div class="panel text-center">
				<h3 class="text-uppercase">Đăng nhập</h3>
				<p>Đăng nhập bằng email bạn đã dùng để đã đăng ký</p>
			</div>
			<hr/>
			<div class="col-md-6" style="float:inherit; margin:auto">
				<br/><br/>
				<?php 
				if(@$_SESSION['message']):?>
					<div class="alert alert-warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
				<?php 
				endif; ?>
				<form class="frmLogin" role="form" method="post" action=""> 
					<div class="form-group" >
						<label><span class="glyphicon glyphicon-envelope clr-sdt1"></span> Email đăng nhập</label>
						<input type="text"  name="email" class="form-control"  placeholder="Email đăng nhập" required>
					</div> 
					<div class="form-group" >
						<label><span class="glyphicon glyphicon-lock clr-sdt1"></span> Mật khẩu</label>
						<input type="password"  name="password" class="form-control"  placeholder="Mật khẩu" required>
					  </div>  
					  <div class="form-group text-right hidden">
						<a href="<?=LINK_USER_ACCOUNT_RESET?>" class="clr-sdt1"><u>Quên mật khẩu?</u></a>
					</div>
					<div class="form-group text-center" >
						<button type="submit" class="btn bg-sdt1" ><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Gửi</button>										
					</div>
					<input type="hidden" name="actExec" value="loginAccount" />
				</form>
			<br/><br/>
			</div>
			<hr/>
			<div class="panel text-center">
				Bạn chưa có tài khoản? <a class="clr-sdt1" href="<?=LINK_USER_REG?>">Đăng kí ngay</a><br/><br/><br/>
			</div>
		</div> 
	</div>
</div> 