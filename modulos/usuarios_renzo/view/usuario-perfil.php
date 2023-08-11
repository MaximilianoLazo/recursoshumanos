<!DOCTYPE html>
<html>

<head>
	<?php include('../../includes/head.php'); ?>
</head>

<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/usuario-editar.php");	?>
	<?php include("includes/mdl/usuario-clave-editar.php");	?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Usuarios</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-end">

							<!--<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>-->
							<?php
							//$destinodatos = $this->model->DestinoObtener($_SESSION["destino_id"]);
							?>
							<button type="button" class="btn btn-primary">
								<?php //echo $destinodatos->destino_nombre;
								?>
								***
							</button>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<!--<div class="pull-left">
							<h5 class="text-blue">Bienvenidos al nuevo Sistema de Expedientes!!!</h5>
              <h5 class="text-blue"><?php //echo $_SESSION['usuario_tipo_id'];
																		?></h5>

						</div>-->
					</div>
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Mi Perfil</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="mb-3">
								<label for="txtperfilusuario" class="control-label">Usuario:</label>
								<input type="text" name="txtperfilusuario" id="txtperfilusuario" value="<?php echo $usuario_datos->usuario_usuario; ?>" class="form-control form-control-sm" disabled>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="mb-3">
								<label for="txtperfilusuariotipo" class="control-label">Tipo de Usuario:</label>
								<input type="text" name="txtperfilusuariotipo" id="txtperfilusuariotipo" value="<?php echo $usuario_tipo_datos->usuario_tipo_nombre; ?>" class="form-control form-control-sm" disabled>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="mb-3">
								<label for="txtperfilusuarioclave" class="control-label">Clave:</label>
								<input type="text" name="txtperfilusuarioclave" id="txtperfilusuarioclave" value="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" class="form-control form-control-sm" disabled>
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="mb-3">
							<button type="button"
											class="btn btn-primary"
											data-bs-toggle="modal"
											data-bs-target="#UsrEditarClave"
											data-titulo="<?php echo "Cambiar Clave"; ?>"
											data-usuarioid="<?php echo $_SESSION['usuario_id']; ?>">
											<i class="fi-key"></i>
											Cambiar Clave
							</button>
							</div>
						</div>
					</div>

					<br>




				</div>
				<?php include('../../includes/footer.php'); ?>
			</div>
		</div>
		<?php include('../../includes/script.php'); ?>
		<script src="includes/js/usuarios.js"></script>
</body>

</html>
