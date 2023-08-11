<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/modal/reprocesardia.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Inicio</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
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
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Busqueda de Marcaciones</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="mbusquedanrodocto">Nro Docto :</label>
								<input type="text" name="mbusquedanrodocto" id="mbusquedanrodocto" value="" class="form-control" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="mbusquedafechai">Desde :</label>
								<input type="date" name="mbusquedafechai" id="mbusquedafechai" value="" class="form-control" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="mbusquedafechaf">Hasta :</label>
								<input type="date" name="mbusquedafechaf" id="mbusquedafechaf" value="" class="form-control" required>
							</div>
						</div>
				</div>
				<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="mbusquedaeviar">Buscar</button>
							</div>
						</div>
				</div>
				<div id="tabladato">

				</div>
				<div class="gifCarga">
					<img id="loading_spinner" style="display: none;" src="../../vendors/images/hola.gif">
				</div>
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="includes/js/busquedaporfecha.js"></script>
	<script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">

	<script>

		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#mbusquedaeviar").click(function(){
				//cogemos el valor del input
				var nrodocto = jQuery("#mbusquedanrodocto").val();
				var fechai = jQuery("#mbusquedafechai").val();
				var fechaf = jQuery("#mbusquedafechaf").val();
				/*
				if( num == "" ){
					alert("Dame un número :)");
					return;
				}
				*/
				//creamos array de parámetros que mandaremos por POST
				var params = {
					"NroDocto" : nrodocto,
					"FechaI" : fechai,
					"FechaF" : fechaf
				};
				//llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					url:   'view/busquedaporfecha-respuesta.php',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tabladato").html("Cargando...");
					},
					success:  function (response) {
						//escondemos gif
						jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tabladato").html(response);
					}
				});
			});
		});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#mbusquedanrodocto").autocomplete({
			//source: "productos.php",
			source: "?c=marcacion&a=BusquedaPorFechaHelp",
			minLength: 3,
			select: function(event, ui){
				event.preventDefault();
				$('#mbusquedanrodocto').val(ui.item.nrodocto);
				//$('#descripcion').val(ui.item.descripcion);
				//$('#precio').val(ui.item.precio);
				//$('#id_producto').val(ui.item.id_producto);
			 }
		});
 });
</script>
</body>
</html>
