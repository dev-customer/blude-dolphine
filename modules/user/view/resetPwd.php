<?php if(!defined('DIR_APP')) die('Your have not permission'); 
?> 
<div class="container-fluid" style="background:#f7f7f7"> 
	<div class="container"> 
		<div class="col-md-8 panel panel-default clearfix" style="float:inherit; margin:auto">
			<div class="panel text-center">
				<h3 class="text-uppercase">Yêu cầu lấy lại mật khẩu</h3>
				<p>Hệ thống sẽ gửi xác nhận đến email mà bạn đăng ký. <br/>Vui lòng kiểm tra email để thực hiện lấy lại mật khẩu</p>
			</div>
			<hr/>
			<div class="col-md-6" style="float:inherit; margin:auto"> 
				<?php 
				if(@$_SESSION['message']):?>
					<div class="alert alert-warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
				<?php 
				endif; ?>
				<form   method="post" action=""> 
					  <div class="form-group" >
						<label><span class="glyphicon glyphicon-envelope clr-sdt1"></span> Email đã đăng ký</label>
						<input type="text"  name="email" class="form-control"  placeholder="Email" required>
					  </div>   
					  <button type="submit" class="btn bg-sdt1" style="width:100%"><span class="glyphicon glyphicon-hand-right"></span> Gửi</button>
				</form>
			<br/><br/><br/><br/>
			</div>
			<hr/>
			<div class="panel text-center">
				Bạn chưa có tài khoản? <a class="clr-sdt1" href="<?=LINK_USER_REG?>">Đăng kí ngay</a><br/><br/><br/>
			</div>
		</div> 
	</div>
</div> 