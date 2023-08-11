<?php
  error_reporting(0);
 	session_start();
	if(!isset($_SESSION['usuario_id'])){
		header('Location: ../login/index.php');
	}
?>
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
							<h5 class="text-blue">Listados de Entrega de Indumentaria</h5>
						</div>
					</div>
					<div class="row">
	          <div class="col-xs-7 col-sm-7">
	            <div class="form-group">
	              <label for="cboleindumentaria" class="control-label">Seleccione Tipo de Listado: </label>
	              <select name="cboleindumentaria" id="cboleindumentaria" class="custom-select form-control" required>
	                <option value="0">--Seleccione--</option>
                  <option value="1">Listado de Entrega de Indumentaria por Fecha/Empleado</option>
	              </select>
	            </div>
	          </div>
            <div class="col-xs-4 col-sm-4">
              <div class="form-group">
                <label for="cboleindumentaria" class="control-label"> </label><br>
                <button type="button" class="btn btn-primary" id="btnleindumentaria">Siguiente</button>
              </div>
            </div>
	        </div>
				  <div class="row">

				  </div>
          <div id="tblcontenidolistado">
  				</div>
  				<!-- Simple Datatable End -->
  				<!-- multiple select row Datatable start -->

  				<!-- multiple select row Datatable End -->
  				<!-- Export Datatable start -->

  				<!-- Export Datatable End -->
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="../../src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
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
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<!-- <script src="../../src/scripts/jquery.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
  <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
	<!--<script src="includes/js/busquedacontrato.js"></script>-->
	<script>
		/*$('document').ready(function(){
		});*/
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#btnleindumentaria").click(function(){
				//--------Obtenemos el valor del input
				var cboleindumentaria = jQuery("#cboleindumentaria").val();
				var params = {
					"CboLEIndumentaria" : cboleindumentaria
				};
				//--------llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
          url:   '?c=indumentaria&a=IndumentariaEntregadaListadosRespuesta',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tblcontenidolistado").html("Déjame pensar un poco...");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tblcontenidolistado").html(response);
					}
				});
			});
		});
	</script>
</body>
</html>
