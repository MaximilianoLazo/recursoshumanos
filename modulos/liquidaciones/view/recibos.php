<?php
  error_reporting(0);
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
  <?php //include("../view/recibos-respuesta.php");?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
	<link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
	<link rel="stylesheet" type="text/css" href="includes/css/bd-callout.css">
	<link rel="stylesheet" type="text/css" href="includes/css/fieldset.css">
  <link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-steps/build/jquery.steps.css">
  <link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa1.css">
  <link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa2.css">
  <link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa3.css">
  <link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa4.css">
</head>
<body>

	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/recibo-xmes.php");?>
  <?php //include("includes/mdl/licenciaanualordinaria-eliminar.php");?>
  <?php //include("includes/mdl/licenciaanualordinaria-info.php");?>
  <?php //include("includes/mdl/licenciaanualordinaria-agregar.php");?>
  <?php //include("includes/mdl/licenciaanualordinaria-cortar.php");?>

	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Listado de Recibos</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item" aria-current="page">Listado de Recibos</li>
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
							<h5 class="text-blue">Listado de Recibos</h5>
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
								<label for="txtbusquedalicenciaaonrodocto">DNI :</label>
								<input type="text" name="txtbusquedalicenciaaonrodocto" id="txtbusquedalicenciaaonrodocto" value="<?php echo $valorimput; ?>" class="form-control" required>
							</div>
						</div>

				</div>
				<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="btnbusquedalicenciaaoenviar">Buscar</button>
							</div>
						</div>
				</div>

				<div class="row" id="tabladato">
					<div  id="tabladatostres">

					</div>
				</div>

				</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="includes/js/liquidacion.js"></script>
	<script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">

 <script>
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#btnbusquedalicenciaaoenviar").click(function(){
				//cogemos el valor del input
				var nrodocto = jQuery("#txtbusquedalicenciaaonrodocto").val();
				var params = {
					"dni" : nrodocto,
					//"LicenciaTipo" : licenciatipo,
					//"FechaI" : fechai,
					//"FechaF" : fechaf
				};
				//llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					url:   '?c=liquidacion&a=ListadoReciboRespuesta',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						//jQuery("#tabladatostres").html("Déjame pensar un poco...");
            jQuery("#tabladatostres").html("<div class='col-md-12'>Cargando Datos...</div>");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tabladato").html(response);

					}
				});


			});

			//----- Al cargar datos si existe dni cargar paginas dos ---
			var node = jQuery("#txtbusquedalicenciaaonrodocto").val();

			//if(node === null){
			if(node == ""){ //true

			}else{
				//--- resultado en vivo de marcaciones ---------
				jQuery(document).ready(function(){
					//--------Obtenemos el valor del input
					var nrodocto = jQuery("#txtbusquedalicenciaaonrodocto").val();

					var params = {
						"DNI" : nrodocto
					};
					//--------llamada al fichero PHP con AJAX
					$.ajax({
						data:  params,
						url:   'view/recibos-respuesta.php',
						dataType: 'html',
						type:  'post',
						beforeSend: function () {
							//mostramos gif "cargando"
							//jQuery('#loading_spinner').show();
							//antes de enviar la petición al fichero PHP, mostramos mensaje
							//jQuery("#tabladatostres").html("Déjame pensar un poco...");
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
