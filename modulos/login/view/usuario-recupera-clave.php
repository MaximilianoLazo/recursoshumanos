<?php
ini_set ( 'display_errors' , 1 );
ini_set ( 'display_startup_errors' , 1 );
error_reporting ( E_ALL );

	$errors = array();

	if(!empty($_POST)){


		$email = $_POST['email'];

		if(!$this->model->isEmail($email)){
			$errors[] = "Debe ingresar un correo electronico valido";
		}
		if($this->model->emailExiste($email)){
			$user_id = $this->model->getValor('usuario_id', 'usuario_email', $email);
			$nombre = $this->model->getValor('usuario_nombres', 'usuario_email', $email);

			$token = $this->model->generaTokenPass($user_id);

			$url = 'http://'.$_SERVER["SERVER_NAME"].'/expedientes/cliente/modulos/login/?c=login&a=UsuarioCambiaClave&id='.$user_id.'&token='.$token;

			$asunto = 'Activar Cuenta - Sistema de Expedientes';
			$cuerpo = "Estimado $nombre: <br /><br />Para restaurar la contrase&ntilde;a, visita la siguiente direccion <a href='$url'>Click aqui !</a>";

			if($this->model->enviarEmail($email, $nombre, $asunto, $cuerpo)){

			echo "Hemos enviado un correo electronico al al direccion $email para restablecer su contraseña";

			echo "<br><a href='index.php' >Iniciar Sesion</a>";
			exit;

			}else{
				$errors[] = "Error al enviar Email";
			}
		}else{
			$errors[] = "No existe el Correo electronico";
		}
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
										<input type="email" id="email" name="email" value="" class="form-control" placeholder="Email">
										<div class="input-group-append custom">
											<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="input-group">
												<button type="submit" id="btn-login" class="btn btn-outline-primary btn-lg btn-block">Enviar</a>
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
