<?php
  //error_reporting(0);
 	session_start();
	if(!isset($_SESSION['usuario_id'])){
		header('Location: ../login/index.php');
	}
?>
<?php
$imputacionid = $_GET['id'];
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
							<h5 class="text-blue"><?php echo "Seleccione Dependencia de Imputacion:".$imputacionid; ?></h5>
						</div>
					</div>



					<div class="row">
	          <div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="cbodependencia" class="control-label"><?php echo "Seleccione Dependencia:"; ?></label>
	              <select name="cbodependencia" id="cbodependencia" class="custom-select form-control" required>
	                <option value="">--SELECCIONE--</option>

	                  <?php foreach($this->model->ObtenerDependencias($imputacionid) as $row): ?>
	                      <option value="<?php echo $row->impdependencia_id; ?>"><?php echo $row->impdependencia_nombre; ?></option>
	                  <?php endforeach; ?>
	              </select>
	            </div>
	          </div>
	        </div>

          <div class="row">
	          <div class="col-xs-12 col-sm-12">
	            <div class="form-group">
                <div align="right">
                  <button type="button" class="btn btn-danger" id="btnaplicardependencia">Aplicar Cambios</button>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div id="no-more-tables">
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                  <table width="100%" border="1" class="table table-striped table-hover table-fixed">
                    <thead>
                      <tr>
                        <th>Nro Documento</th>
                        <th>Apellido y Nombres</th>
                        <th>Lugar de Trabajo</th>

                        <th>Fec Igreso</th>
                        <th>Fec Inicio</th>
                        <th>Fec Final</th>
                        <th>Tarea</th>
                        <th>S. Basico</th>
                        <th width="3%">
                          <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input check-all" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1"></label>
                          </div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                        foreach($dep as $row):
                          /*


                          $nrodocto = $row->legempleado_nrodocto;
                          $imputacionid = $row->imputacion_id;
                          $datoimputacion = $empleado->ObtenerImputacion($imputacionid);
                          $sbasicobase = $empleado->ObtenerActualizacion($nrodocto);

                          $cantidad = $sbasicobase->legajo_importeb;
                          $porciento = 10;
                          $decimales = 2;
                          $sbasiconuevo = $empleado->Porcentaje($cantidad,$porciento,$decimales);
                          $sbasiconuevo2 = $cantidad + $sbasiconuevo;*/
                          $datotrabajo = $this->model->ObtenerLTrabajo($row->trabajo_id);
                          $fechaingreso = date("d/m/Y", strtotime($row->legempleado_fecingreso));
                          $contratofeci = date("d/m/Y", strtotime($row->legcontrato_fecinicio));
                          $contratofecf = date("d/m/Y", strtotime($row->legcontrato_fecfin));
                          $sbasico = number_format($row->legcontrato_sbasico, 2, ',', '.');
                      ?>
                      <tr>
                        <td data-title="no name:"><?php echo $row->legempleado_nrodocto; ?></td>
                        <td data-title="no name:"><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
                        <td data-title="no name:"><?php echo $datotrabajo->trabajo_nombre; ?></td>

                        <td data-title="no name:"><?php echo $fechaingreso; ?></td>
                        <td data-title="no name:"><?php echo $contratofeci; ?></td>
                        <td data-title="no name:"><?php echo $contratofecf; ?></td>
                        <td data-title="no name:"><?php echo $row->legcontrato_tarea; ?></td>
                        <td data-title="no name:"><?php echo "$ ".$sbasico; ?></td>
                        <td data-title="no name:">
                          <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input check-cont" name="checkbox[]" value="<?php echo $row->legcontrato_id; ?>" id="checkbox[<?php echo $row->legcontrato_id; ?>]">
                            <label class="custom-control-label" for="checkbox[<?php echo $row->legcontrato_id; ?>]"></label>
                          </div>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
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
    jQuery(document).ready(function(){
      jQuery("#btnaplicardependencia").click(function(){
        //--------Obtenemos el valor del input
        var contratoids = [];
        console.log($("input[name='checkbox[]']"));
        $("input[name='checkbox[]']:checked").each(function(){
          console.log($(this).val());
          contratoids .push($(this).val());
        });
        //var fechainicioc = "'.$variable_php.'";
        var dependenciaid = jQuery("#cbodependencia").val();
        var imputacionid = '<?php echo $imputacionid; ?>';


        var params = {
          "DependenciaId" : dependenciaid,
          "ContratoIds" : contratoids,
          "ImputacionId" : imputacionid,

        };
        //--------llamada al fichero PHP con AJAX
        $.ajax({
          cache: false,
          type: 'POST',
          dataType:"html",
          url: '?c=dependencia&a=AplicarDependencia',
          //contentType: false,
          //processData: false,
          data: params,
          //xhrFields is what did the trick to read the blob to pdf
          xhrFields:{
            responseType: 'blob'
          },
          beforeSend: function () {
            //mostramos gif "cargando"
            //jQuery('#loading_spinner').show();
            //antes de enviar la petición al fichero PHP, mostramos mensaje
            jQuery("#tabladato").html("Déjame pensar un poco...");
          },
          success: function (response, status, xhr){
            window.location.href = "?c=dependencia&a=AplicacionDependenciaExitosa&id="+imputacionid;
          }
        });
      });
    });
    var checked = false;
    $('.check-all').on('click',function(){
      if(checked == false){
        $('.check-cont').prop('checked', true);
        checked = true;
      }else{
        $('.check-cont').prop('checked', false);
        checked = false;
      }
    });
	</script>
</body>
</html>
