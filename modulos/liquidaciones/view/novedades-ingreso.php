<?php
  //error_reporting(0);
 	session_start();
	if(!isset($_SESSION['usuario_id'])){
		header('Location: ../login/index.php');
	}
	$jub=$_REQUEST['id'];

	//$jub=5081;
  $novedades_datos = $this->model->JubiladoObtenerLeg($jub);
  

?>
<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
	<link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
	<link rel="stylesheet" type="text/css" href="includes/css/bd-callout.css">
	<link rel="stylesheet" type="text/css" href="includes/css/fieldset.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/licencia-eliminar.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Carga de Novedades</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item" aria-current="page">Carga de Novedades</li>
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
								
				<div class="row" id="tabladato">
					


				</div>
				<div class="row table-responsive">
					<div class="col-md-12" id="tabladatodos">

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
			jQuery("#btnbusquedalicenciaenviar").click(function(){
				//cogemos el valor del input
				var nrodocto = jQuery("#txtbusquedalicencianrodocto").val();
				var licenciatipo = jQuery("#cbobusquedalicenciatipo").val();
				var fechai = jQuery("#txtbusquedalicenciafechai").val();
				var fechaf = jQuery("#txtbusquedalicenciafechaf").val();

				var params = {
					"NroDocto" : nrodocto,
					"LicenciaTipo" : licenciatipo,
					"FechaI" : fechai,
					"FechaF" : fechaf
				};
				//llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					url:   'view/novedadesingreso-respuesta.php',
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

			//----- Al cargar datos si existe dni cargar paginas dos ---
			var node = jQuery("#txtbusquedalicencianrodocto").val();

			//if(node === null){
			if(node == ""){ //true

			}else{
				//--- resultado en vivo de marcaciones ---------
				jQuery(document).ready(function(){
					//--------Obtenemos el valor del input
					var nrodocto = jQuery("#txtbusquedalicencianrodocto").val();

				/*	var rdoorden = [];
					console.log($("input[name='RdoOrden']"));
					$("input[name='RdoOrden']:checked").each(function(){
						console.log($(this).val());
						rdoorden .push($(this).val());
					});*/
					var params = {
						"NroDocto" : nrodocto
						//"CboLugarDeTrabajo" : cbolugardetrabajo,
						//"RdoOrden" : rdoorden,
						//"CboFecIngreso" : cbofecingreso,
						//"CboNuevaFecInicio" : cbonuevafecinicio,
						//"CboNuevaFecFin" : cbonuevafecfin,
						//"CboActualizacion" : cboactualizacion
						//"RdoApellidoYNombres" : rdoapellidoynombres,
						//"RdoNroDocumento" : rdonrodocumento
					};
					//--------llamada al fichero PHP con AJAX
					$.ajax({
						data:  params,
						url:   'view/novedadesingreso-respuesta.php',
						dataType: 'html',
						type:  'post',
						beforeSend: function () {
							//mostramos gif "cargando"
							//jQuery('#loading_spinner').show();
							//antes de enviar la petición al fichero PHP, mostramos mensaje
							jQuery("#tabladatostres").html("Déjame pensar un poco...");
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
		<script type="text/javascript">
		$(document).ready(function(){
      $("#txtbusquedalicencianrodocto").autocomplete({
        //source: "productos.php",
				source: "?c=licencia&a=LicenciaIngresoAyuda",
        minLength: 3,
        select: function(event, ui){
					event.preventDefault();
          $('#txtbusquedalicencianrodocto').val(ui.item.nrodocto);
					//$('#descripcion').val(ui.item.descripcion);
					//$('#precio').val(ui.item.precio);
					//$('#id_producto').val(ui.item.id_producto);
			   }
      });
	 });
	</script>
</body>
</html>
