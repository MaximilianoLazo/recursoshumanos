<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
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
						<div class="col-md-6">
							<div class="form-group">
								<label for="cbohsextrasperiodo" class="control-label">Periodo:</label>
								<select name="CboSecretarias" id="CboSecretarias" class="custom-select form-control" required>
	                <option value="">--SELECCIONE--</option>
	                  <?php foreach($this->model->PeriodoUDiez() as $row):
											$periodofeci = date("d/m/Y", strtotime($row->periodo_hsext_jor_i));
											$periodofecf = date("d/m/Y", strtotime($row->periodo_hsext_jor_f));
										?>
	                      <option value="<?php echo $row->periodo_id; ?>"><?php echo $row->periodo_nombre." ".$periodofeci." a ".$periodofecf; ?></option>
	                  <?php endforeach; ?>
	              </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="cbohsextrasperiodo" class="control-label">Tipo de Listado:</label>
								<select name="CboSecretarias" id="CboSecretarias" class="custom-select form-control" required>
	                <option value="">--SELECCIONE--</option>
									<option value="1">Listado Completo</option>
									<option value="2">Listado Agrupado por Lugar de Trabajo</option>
	              </select>
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
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>

	<script src="../../src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
  <!--<script src="//cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js"></script>-->
  <script src="../../src/plugins/datatables/dataRender/datetime.js"></script>
	<script src="../../src/plugins/datatables/media/js/dataTables.bootstrap4.js"></script>
	<script src="../../src/plugins/datatables/media/js/dataTables.responsive.js"></script>
	<script src="../../src/plugins/datatables/media/js/responsive.bootstrap4.js"></script>
	<!-- buttons for Export datatable -->
	<script src="../../src/plugins/datatables/media/js/button/dataTables.buttons.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.bootstrap4.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.print.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.html5.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.flash.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/pdfmake.min.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/vfs_fonts.js"></script>
	<script src="includes/js/horasextras.js"></script>
  <script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">


	<!--<script src="includes/js/busquedaporfecha.js"></script>-->
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
					url:   'view/horasextras-periodosanteriores-respuesta.php',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tabladato").html("Déjame pensar un poco...");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
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
			source: "?c=marcacion&a=BusquedaPorFechaAyuda",
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
