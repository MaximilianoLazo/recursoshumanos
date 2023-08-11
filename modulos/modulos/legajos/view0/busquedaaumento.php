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
  <link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
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
							<h5 class="text-blue">Actualizacion de Contratos</h5>
						</div>
					</div>
          <div class="row">
  						<div class="col-md-12">
  							<div class="form-group">
                  <div align="right">
  								  <button type="button" class="btn btn-primary" id="">Configuracion de Actualizaciones</button>
                  </div>
  							</div>
  						</div>
  				</div>
          <div class="clearfix mb-20">
						<div class="pull-left">
							<h6 class="text-info">Filtros de Busqueda</h6>
						</div>
					</div>
					<div class="row">
	          <div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="CboSecretarias" class="control-label">Secretaria: </label>
	              <select name="CboSecretarias" id="CboSecretarias" class="custom-select form-control" required>
	                <option value="">--Seleccione--</option>
	                  <?php foreach($this->model->Secretarias() as $row): ?>
	                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
	                  <?php endforeach; ?>
	              </select>
	            </div>
	          </div>
						<div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="CboLugaresDeTrabajo" class="control-label">Lugar de Trabajo:</label>
	              <select name="CboLugaresDeTrabajo" id="CboLugaresDeTrabajo" class="custom-select form-control" required>
	                <option value="">--Seleccione--</option>
	              </select>
	            </div>
	          </div>
            <div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="cbosituacionrevista" class="control-label">Situacion de Revista:</label>
                <select name="cbosituacionrevista" id="cbosituacionrevista" class="custom-select form-control" required>
	                <option value="">--Seleccione--</option>
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
	          <div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="CboFecReferencia" class="control-label">Fecha de Referencia: </label>
	              <select name="CboFecReferencia" id="CboFecReferencia" class="custom-select form-control" required>
	                <option value="">Ago-2021</option>
                    <!--
	                  <?php //foreach($this->model->FechasDeReferencia() as $row): ?>
	                      <option value="<?php //echo $row->legcontrato_id; ?>"><?php echo $row->legcontrato_fecinicio; ?></option>
	                  <?php //endforeach; ?>
                  -->

	              </select>
	            </div>
	          </div>
            <div class="col-xs-3 col-sm-3">
							<div class="form-group">
								<label for="CboFiltroFecIngreso">Fec de Ingreso Igual o Anterior a :</label>
								<input type="date" name="CboFiltroFecIngreso" id="CboFiltroFecIngreso" value="2022-04-01" class="form-control" required>
							</div>
						</div>

          </div>
          <div class="clearfix mb-20">
            <div class="pull-left">
              <h6 class="text-info">Datos de Actualizacion</h6>
            </div>
          </div>
          <div class="row">

            <div class="col-xs-3 col-sm-3">
							<div class="form-group">
								<label for="CboNuevaFecInicio">Nueva Fecha de Inicio :</label>
								<input type="date" name="CboNuevaFecInicio" id="CboNuevaFecInicio" value="2022-03-01" class="form-control" required>
							</div>
						</div>
            <div class="col-xs-3 col-sm-3">
							<div class="form-group">
								<label for="CboNuevaFecFin">Nueva Fecha de Fin :</label>
								<input type="date" name="CboNuevaFecFin" id="CboNuevaFecFin" value="2022-07-31" class="form-control" required>
							</div>
						</div>
            <div class="col-xs-3 col-sm-3">
							<div class="form-group">
								<label for="CboActualizacion">Porcentaje de Actualizacion % :</label>
								<input type="number" name="CboActualizacion" id="CboActualizacion" value="20" class="form-control" required>
							</div>
						</div>
            <div class="col-xs-3 col-sm-3">
							<div class="form-group">
								<label for="Cbosueldobasico">S. Basico mayores a $ :</label>
								<input type="number" name="Cbosueldobasico" id="Cbosueldobasico" value="9999" class="form-control" required>
							</div>
						</div>
          </div>
				<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="mbusquedaAenviar">Buscar</button>
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
	<script src="includes/js/busquedacontrato.js"></script>
	<script>
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#mbusquedaAenviar").click(function(){
				//--------Obtenemos el valor del input
				var cbosecretaria = jQuery("#CboSecretarias").val();
				var cbolugardetrabajo = jQuery("#CboLugaresDeTrabajo").val();
        var cbosituacionrevista = jQuery("#cbosituacionrevista").val();
        var cbofecingreso = jQuery("#CboFiltroFecIngreso").val();
        var cbonuevafecinicio = jQuery("#CboNuevaFecInicio").val();
        var cbonuevafecfin = jQuery("#CboNuevaFecFin").val();
        var cboactualizacion = jQuery("#CboActualizacion").val();
        var cbosueldobasico = jQuery("#Cbosueldobasico").val();

				var rdoorden = [];
	      console.log($("input[name='RdoOrden']"));
	      $("input[name='RdoOrden']:checked").each(function(){
	        console.log($(this).val());
	        rdoorden .push($(this).val());
	      });
				var params = {
					"CboSecretaria" : cbosecretaria,
					"CboLugarDeTrabajo" : cbolugardetrabajo,
          "CboSituacionRevista" : cbosituacionrevista,
					"RdoOrden" : rdoorden,
          "CboFecIngreso" : cbofecingreso,
          "CboNuevaFecInicio" : cbonuevafecinicio,
          "CboNuevaFecFin" : cbonuevafecfin,
          "CboActualizacion" : cboactualizacion,
          "CboSueldoBasico" : cbosueldobasico
				};
				//--------llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					//url:   'view/busquedaaumento-respuesta.php',
          url:   '?c=empleado&a=BusquedaAumentoRespuesta',
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
