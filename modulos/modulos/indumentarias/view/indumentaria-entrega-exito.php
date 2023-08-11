<?php
//error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}
$entrega_numero = $_GET["id"];
$datosindumentariae = $this->model->IndumentariaEntregaObtner($entrega_numero);


?>
<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
  <link rel="stylesheet" type="text/css" href="../../src/plugins/tabla-car/tabla-car.css">

</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php //include("includes/mdl/indumentaria-carro-editar.php");?>
	<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Indumentarias</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item" aria-current="page">Entrega & Consulata de Indumentarias</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							<!--
							<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>
							-->
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="row">
          <div class="col-md-12">
            <div class="jumbotron" style="text-align: center; padding: 2rem 2rem; margin-bottom: 10px;">
              <h1 class="display-4">ATENCIÓN!</h1>
              <p class="lead">Indumentaria entregada correctamente a <?php echo $datosindumentariae[0]->legempleado_nrodocto; ?>!</p>
              <hr class="my-4">
              <!--<div style="padding: 0.8rem 0.2rem">
                <span style="font-size: 15em; color: green;">
                  <i class="ion-android-checkmark-circle"></i>
                </span>
              </div>-->
              <i class="ion-android-checkmark-circle fa-5x"></i>
              <br>
              <a href="?c=indumentaria&a=Index&id=<?php echo $datosindumentariae[0]->legempleado_nrodocto; ?>"
                class="btn btn-primary">
                <i class="ion-android-arrow-back fa-lg"></i>&nbsp;VOLVER a Indumentarias
              </a>

              <a href="?c=indumentaria&a=IndumentariaEntregaExitoComprobante&id=<?php echo $entrega_numero; ?>"
                class="btn btn-danger">
                <i class="fa fa-download fa-lg" aria-hidden="true"></i>&nbsp;DESCARGAR Comprobante
              </a>
            </div>
          </div>
        </div>
			<?php include('../../includes/footer.php'); ?>
		  </div>
	  </div>
  </div>
  <?php include('../../includes/script.php'); ?>
  <!-- busqueda de empleados -->
  <!--
	<script src="../../src/plugins/typeahead/typeahead.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/typeahead/typeahead.css">
  -->
  <!--script propios del formulario -->
	<!--<script src="includes/js/indumentaria.js"></script>-->
</body>
</html>
