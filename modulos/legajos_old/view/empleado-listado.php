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
							<h5 class="text-blue">Filtro de Listado de Empleados</h5>
						</div>
					</div>
					<div class="row">
	          <div class="col-xs-3 col-sm-3">
              <div class="row">


                <div class="col-xs-12 col-sm-12">
                  <div class="form-group">

      							<label for="" class="control-label" style="font-weight: bold;">Situación de Revista</label>
      							<?php
                     foreach($this->model->SituacionRevistaListar() as $row):
                    ?>
      							<div class="form-check">
      								<input type="checkbox" class="form-check-input"  name="LT[]" id="<?php echo "LT".$row->legtipo_id; ?>" value="<?php echo $row->legtipo_id; ?>" >

      								<label class="form-check-label" for="<?php echo "LT".$row->legtipo_id; ?>">
      									<?php echo $row->legtipo_nombre; ?>
      								</label>
      							</div>
      							<?php
                     endforeach;
                    ?>
    	            </div>
                </div>
              </div>

	          </div>
            <div class="col-xs-3 col-sm-3">
	            <div class="form-group">

  							<label for="" class="control-label" style="font-weight: bold;">Secretarias</label>
  							<?php
                 foreach($this->model->SecretariasListar() as $row):
                ?>
  							<div class="form-check">
  								<input type="checkbox" class="form-check-input"  name="Secretaria[]" id="<?php echo "Secretaria".$row->secretaria_id; ?>" value="<?php echo $row->secretaria_id; ?>" >

  								<label class="form-check-label" for="<?php echo "Secretaria".$row->secretaria_id; ?>">
  									<?php echo $row->secretaria_nombre; ?>
  								</label>
  							</div>
  							<?php
                 endforeach;
                ?>
	            </div>
	          </div>
            <div class="col-xs-3 col-sm-3">
              <div class="row">
                <div class="col-xs-12 col-sm-12">
                  <div class="form-group">
  									<label for="cbohcomerciotsolicitude" class="control-label" style="font-weight: bold;">Estado</label>
  									<br>
  									<div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Activo</label>

  									</div>
                    <div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Inactivo</label>

  									</div>
                    <div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Ambos</label>

  									</div>
  								</div>
                </div>

                <div class="col-xs-12 col-sm-12">
                  <div class="form-group">
  									<label for="cbohcomerciotsolicitude" class="control-label" style="font-weight: bold;">Estado Civil</label>
  									<br>
  									<div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Casado</label>

  									</div>
                    <div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Soltero</label>

  									</div>
                    <div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Ambos</label>

  									</div>
  								</div>
                </div>

                <div class="col-xs-12 col-sm-12">
                  <div class="form-group">
  									<label for="cbohcomerciotsolicitude" class="control-label" style="font-weight: bold;">Genero</label>
  									<br>
  									<div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Masculino</label>

  									</div>
                    <div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Femenino</label>

  									</div>
                    <div class="form-check form-check-inline">
  										<input class="form-check-input" type="radio" name="rdohcomerciolocal" id="inlineRadio1" value="1" <?php if($hcexpediente->hc_expediente_local == 1){ echo "checked=checked";} ?>>
  										<label class="form-check-label" for="inlineRadio1">Sin especificar</label>

  									</div>
  								</div>
                </div>

              </div>
            </div>
            <div class="col-xs-3 col-sm-3">
              <div class="form-group">
                <label for="cbohcomerciotsolicitude" class="control-label" style="font-weight: bold;">Filtros disponibles</label>
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                  <div>
                    An example warning alert with an icon
                  </div>
                </div>
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
	<script src="includes/js/empleado-listados.js"></script>
	<script>
		/*$('document').ready(function(){


		});*/
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#mbusquedaheviar").click(function(){
				//--------Obtenemos el valor del input
				var cbosecretaria = jQuery("#CboSecretarias").val();
        var cboltrabajo = jQuery("#CboEmpLTrabajo").val();
        var cbosituacionrevista = jQuery("#CboSituacionRevista").val();
				/*var cbolugardetrabajo = jQuery("#CboLugaresDeTrabajo").val();
        var cbotipodecontrato = jQuery("#CboTipoDeContrato").val();
        var sbasicodesde = jQuery("#txtsbasicodesde").val();
        var sbasicohasta = jQuery("#txtsbasicohasta").val();*/

				/*var rdoorden = [];
	      console.log($("input[name='RdoOrden']"));
	      $("input[name='RdoOrden']:checked").each(function(){
	        console.log($(this).val());
	        rdoorden .push($(this).val());
	      });*/
				var params = {
					"CboSecretaria" : cbosecretaria,
					"CboLTrabajo" : cboltrabajo,
          "CboSRevista" : cbosituacionrevista
				};
				//--------llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
          url:   '?c=empleado&a=EmpleadoListadoRespuesta',
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