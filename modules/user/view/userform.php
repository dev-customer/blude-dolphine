<?php if(!defined('DIR_APP')) die('Your have not permission');
//var_dump($account); ?>
<div class="container-fluid"> 
	<div class="container"> 
		<div class="col-md-7 panel panel-default clearfix" style="float:inherit; margin:auto">
			<div class="panel text-center">
				<h3 class="text-uppercase">Đăng ký</h3>
				<p>Đăng ký tài khoản</p>
			</div>
			<hr/>
			<div class="col-md-6" style="float:inherit; margin:auto">
				<br/> 
				<?php 
				if(@$_SESSION['message']):?>
					<div class="alert alert-warning"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
				<?php 
				endif; ?> 
				<form class="" role="form" method="post" action=""> 
					<div class="form-group" >
						<input name="firstname" class="form-control"  placeholder="Họ" value="<?=@$account['firstname']?>" required>
					</div> 
					<div class="form-group" >
						<input name="lastname" class="form-control"  placeholder="Tên" value="<?=@$account['lastname']?>" required>
					</div> 
					<div class="form-group" >
						<input name="email" class="form-control"  placeholder="Email">
					</div> 
					<div class="form-group" >
						<input type="password"  name="password" class="form-control"  placeholder="Mật khẩu" <?=$_GET['m']=='register' ? 'required':''?> >
					</div>  
					<div class="form-group text-center" >
						<button type="submit" class="btn btn-send bg-sdt2"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Gửi</button> 
					</div> 
					
					<input  name="id_user" id="id_user" type="hidden" value="<?= @$account['id_user']?>" />
					<input type="hidden" name="actExec" value="insertAccount" />
				</form>
			</div>
			<hr/>
			<div class="panel text-center">
				Bạn đã có tài khoản? <a class="clr-sdt1" href="<?=LINK_USER_LOGIN?>">Đăng nhập</a><br/> 
			</div>
		</div>
	</div>
</div>   