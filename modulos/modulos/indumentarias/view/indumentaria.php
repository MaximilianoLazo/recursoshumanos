<?php
//error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}
$ndocconsultado = $_GET["id"];
// Esto evaluará a TRUE así que el texto se imprimirá.
if(isset($_GET["id"])){
  //echo "Esta variable está definida, así que se imprimirá";
  $valorimput = $ndocconsultado;
}else{
  $valorimput = null;
}

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
	<?php include("includes/mdl/indumentaria-carro-editar.php");?>
  <?php include("includes/mdl/indumentaria-carro-baja.php");?>
  <?php include("includes/mdl/indumentaria-carro-cerrar.php");?>
	<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Entrega & Consulta de Indumentarias</h4>
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
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Indumentaria</h5>
						</div>
					</div>
					<?php
						date_default_timezone_set("America/Buenos_Aires");
						$fecha_actual = date("Y-m-d");
						$hora_actual = date("H:i:s");
						$fecha_inicio = date("Y-01-01");
					?>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="txtbusquedaindumentarianrodocto">DNI :</label>
								<input type="text" name="txtbusquedaindumentarianrodocto" id="txtbusquedaindumentarianrodocto" value="<?php echo $valorimput; ?>" class="form-control" required>
							</div>
						</div>

				</div>
				<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="btnbusquedaindumentariaenviar">Buscar</button>
							</div>
						</div>
				</div>
				<div class="row" id="tabladato">
          <br>
          <br>
          <br>
          <br>
				</div>
				<div class="row table-responsive">
					<div class="col-md-12" id="tabladatodos">

					</div>
				</div>
			</div>
			<?php include('../../includes/footer.php'); ?>
		  </div>
	  </div>
  </div>
  <?php include('../../includes/script.php'); ?>
  <!-- busqueda de empleados -->
	<script src="../../src/plugins/typeahead/typeahead.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/typeahead/typeahead.css">
  <!--script propios del formulario -->
	<script src="includes/js/indumentaria.js"></script>
  <script>
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#btnbusquedaindumentariaenviar").click(function(){
				//cogemos el valor del input
				var nrodocto = jQuery("#txtbusquedaindumentarianrodocto").val();
				var params = {
					"NroDocto" : nrodocto,
				};
				//llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
          url:   '?c=indumentaria&a=IndumentariaRespuesta',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tabladato").html("<div class='col-md-12'>Cargando Datos...</div>");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tabladato").html(response);
					}
				});
			});
      //------Al cargar el Formulario -------
      var nrodocto = jQuery("#txtbusquedaindumentarianrodocto").val();
      //if(node === null){
      if(nrodocto === ""){ //true
        //----Campo vacio ----
      }else{
        //--- resultado en vivo de marcaciones ---------
  			jQuery(document).ready(function(){
  				var params = {
  					"NroDocto" : nrodocto
  				};
  				//--------llamada al fichero PHP con AJAX
  				$.ajax({
  					data:  params,
            url:   '?c=indumentaria&a=IndumentariaRespuesta',
  					dataType: 'html',
  					type:  'post',
  					beforeSend: function () {
  						//mostramos gif "cargando"
  						//jQuery('#loading_spinner').show();
  						//antes de enviar la petición al fichero PHP, mostramos mensaje
              jQuery("#tabladato").html("<div class='col-md-12'>Cargando Datos...</div>");
  					},
  					success:  function (response) {
  						//escondemos gif
  						//jQuery('#loading_spinner').hide();
  						//mostramos salida del PHP
              jQuery("#tabladato").html(response);
  					}
  				});
  			});
      }
		});
  </script>
</body>
</html>
