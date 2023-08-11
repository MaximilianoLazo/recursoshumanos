<?php
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include('../../includes/head.php'); ?>
	</head>
	<body>
			<div id="loginbox" class="login-wrap customscroll d-flex align-items-center flex-wrap justify-content-center pd-20">
				<div class="login-box bg-white box-shadow pd-30 border-radius-5">
					<img src="../../vendors/images/login-img.png" class="login-img">

						<div style="display:none" id="login-alert" class="alert alert-danger" role="alert"></div>
								<form id="loginform" class="form-horizontal" role="form" action="?c=login&a=UsuarioClaveGuardar" method="POST" autocomplete="off">

									<input type="hidden" id="user_id" name="user_id" value ="<?php echo $user_id; ?>" />
									<input type="hidden" id="token" name="token" value ="<?php echo $token; ?>" />

									<div class="input-group custom input-group-lg">
										<input type="password" id="password" name="password" value="" class="form-control" placeholder="Nueva Clave">
										<div class="input-group-append custom">
											<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
										</div>
									</div>

									<div class="input-group custom input-group-lg">
										<input type="password" id="con_password" name="con_password" value="" class="form-control" placeholder="Repetir Clave">
										<div class="input-group-append custom">
											<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-8">
											<div class="input-group">
												<button type="submit" id="btn-login" class="btn btn-outline-primary btn-lg btn-block">Guardar Cambios</a>
											</div>
										</div>
										<!--
										<div class="col-sm-6">
										</div>
									-->
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%"><a href="?c=login&a=Index">Iniciar Sesión</a>
											</div>
											<br>
										</div>
									</div>
								</form>
						<?php echo $this->model->resultBlock($errors); ?>
				</div>
			</div>
		<?php include('../../includes/script.php'); ?>
	</body>
</html>
