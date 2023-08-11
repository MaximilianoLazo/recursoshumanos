<?php
  //error_reporting(0);
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
  <!--<link rel="stylesheet" type="text/css" href="../../src/plugins/bootstrap-4.0.0/dist/css/bootstrap.css">-->
  <link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
  <!--<link rel="stylesheet" type="text/css" href="includes/css/checkbox.css">-->
  <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
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
							<h5 class="text-blue">Seleccione Contratos</h5>
						</div>
					</div>
					<div class="row">
	          <div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="CboSecretarias" class="control-label">Seleccione Secretaria: </label>
	              <select name="CboSecretarias" id="CboSecretarias" class="custom-select form-control" required>
	                <option value="">--SELECCIONE--</option>
	                  <?php foreach($this->model->Secretarias() as $row): ?>
	                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
	                  <?php endforeach; ?>
	              </select>
	            </div>
	          </div>

            <div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="CboTipoDeContrato" class="control-label">Seleccione Tipo de Contrato:</label>
	              <select name="CboTipoDeContrato" id="CboTipoDeContrato" class="custom-select form-control" required>
	                <!--<option value="">-- SELECCIONE --</option>-->
                  <?php foreach($this->model->ContrProv() as $row): ?>
                      <option value="<?php echo $row->legtipo_id; ?>"><?php echo $row->legtipo_nombre; ?></option>
                  <?php endforeach; ?>
	              </select>
	            </div>
	          </div>
						<div class="col-xs-3 col-sm-3">
							<label class="control-label">Ordenar por:</label>
							<div class="custom-control custom-radio mb-5">
								<input type="radio" id="RdoApellidoYNombres" name="RdoOrden" value="1" class="custom-control-input" checked>
								<label class="custom-control-label" for="RdoApellidoYNombres">Apellido y Nombres</label>
							</div>
							<div class="custom-control custom-radio mb-5">
								<input type="radio" id="RdoNroDocumento" name="RdoOrden" value="2" class="custom-control-input">
								<label class="custom-control-label" for="RdoNroDocumento">Nro. Documento</label>
							</div>
						</div>
	        </div>
				<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="mbusquedaheviar">Buscar</button>
							</div>
						</div>
				</div>
        <div id="tabladato">
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
	<script src="includes/js/busquedacontrato.js"></script>
	<script>
		/*$('document').ready(function(){


		});*/
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#mbusquedaheviar").click(function(){
				//--------Obtenemos el valor del input
				var cbosecretaria = jQuery("#CboSecretarias").val();
				//var cbolugardetrabajo = jQuery("#CboLugaresDeTrabajo").val();
        var cbotipodecontrato = jQuery("#CboTipoDeContrato").val();
				//var rdoapellidoynombes = jQuery("#RdoApellidoYNombres").val();
				//var rdonrodocumento = jQuery("#RdoNroDocumento").val();
				var rdoorden = [];
	      console.log($("input[name='RdoOrden']"));
	      $("input[name='RdoOrden']:checked").each(function(){
	        console.log($(this).val());
	        rdoorden .push($(this).val());
	      });
				var params = {
					"CboSecretaria" : cbosecretaria,
					//"CboLugarDeTrabajo" : cbolugardetrabajo,
          "CboTipoDeContrato" : cbotipodecontrato,
					//"RdoApellidoYNombres" : rdoapellidoynombres,
					//"RdoNroDocumento" : rdonrodocumento
					"RdoOrden" : rdoorden
				};
				//--------llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					url:   'view/busquedacontratosinrenovar-respuesta.php',
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
</body>
</html>
