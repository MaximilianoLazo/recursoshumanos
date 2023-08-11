<?php

	$errors = array();

	if(!empty($_POST)){

		$usuario = $_POST['usuario'];
		$password = $_POST['password'];

		if($this->model->isNullLogin($usuario, $password)){
			$errors[] = "Debe llenar todos los campos";
		}
		$errors[] = $this->model->login($usuario, $password);
	}

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
								<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
									<div class="input-group custom input-group-lg">
										<input type="text" id="usuario" name="usuario" value="" class="form-control" placeholder="Usuario">
										<div class="input-group-append custom">
											<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
										</div>
									</div>
									<div class="input-group custom input-group-lg">
										<input type="password" id="password" name="password" class="form-control" placeholder="*******">
										<div class="input-group-append custom">
											<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="input-group">
												<button type="submit" id="btn-login" class="btn btn-outline-primary btn-lg btn-block">Ingresar</a>
											</div>
										</div>
										<!--
										<div class="col-sm-6">
										</div>
									-->
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%"><a href="?c=login&a=RecuperarClave">¿Se olvid&oacute; su contraseña?</a>
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
