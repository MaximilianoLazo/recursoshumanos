<?php
  date_default_timezone_set("America/Buenos_Aires");
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
	<!-- ventanas modal -->
  <?php include("includes/mdl/asignacionesfamob-pdf.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Asignaciones Familiares (Otros Beneficiarios)</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Asignaciones Familiares (Otros Beneficiarios)</li>
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
							<h5 class="text-blue">Asignaciones Familiares (Otros Beneficiarios)</h5>
						</div>
					</div>
          <div class="row">
						<div class="col-md-12">
							<div class="form-group">
                <?php
                $periodoactual = $this->model->PeriodoActualObtener();
                $periodoid = $periodoactual->periodo_id;
                $aobfechapase = $this->model->AOBFechaPaseLiqObtener($periodoid);
                $asignacionesobc = $this->model->AsignacionesOBLiqFilasNum($periodoid);

                //date_default_timezone_set("America/Buenos_Aires");
                $date = new DateTime(date("$aobfechapase->AUD_asignacion_datetime"));
                $fecha_de_pase = $date->format('d/m/Y H:i:s');



                if($asignacionesobc->asignacionobc > 0){
                  //--- Pase echo --
                  ?>
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                    El pase del Periodo <strong><?php echo $periodoactual->periodo_nombre; ?></strong> Se realizo el día <strong><?php echo $fecha_de_pase; ?></strong>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div align="right">
                    <a  class="btn btn-success" href="#">Excel</a>
                    <button type="button"
                            class="btn btn-danger"
                            data-toggle="modal"
                            data-target="#dataViewAsignacionesFamOBPDF"
                            data-titulo="<?php echo "Listado de Asignaciones Familiares (Otros Beneficiarios) - PDF"; ?>">PDF
                    </button>
  								</div>
                  <?php
                }else{
                  //--- Pase no echo ---
                  ?>
                  <div align="right">
                    <a  class="btn btn-success" href="#">Excel</a>
                    <button type="button"
                            class="btn btn-danger"
                            data-toggle="modal"
                            data-target="#dataViewAsignacionesFamOBPDF"
                            data-titulo="<?php echo "Listado de Asignaciones Familiares (Otros Beneficiarios) - PDF"; ?>">PDF
                    </button>
                    <a  class="btn btn-info" href="?c=asignacion&a=AsignacionesOBPaseALiq">PASAR a Liquidaciones</a>
  								</div>
                  <?php
                }
                ?>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th style="color:#000000;font-size:13px;">Empleado</th>
									<th style="color:#000000;font-size:13px;">Nro DNI</th>
                  <th style="color:#000000;font-size:13px;">Beneficiario</th>
									<th style="color:#000000;font-size:13px;">Nro DNI / Oficio</th>
                  <th style="color:#000000;font-size:13px;">Pre-Natal</th>
                  <th style="color:#000000;font-size:13px;">H Menor</th>
                  <th style="color:#000000;font-size:13px;">Prescolar</th>
                  <th style="color:#000000;font-size:13px;">Esc Prim</th>
                  <th style="color:#000000;font-size:13px;">Esc Med & Sup</th>
                  <th style="color:#000000;font-size:13px;">DISC</th>
                  <th style="color:#000000;font-size:13px;">Esc DISC</th>
                  <th style="color:#000000;font-size:13px;">Total Asig</th>
                  <th style="color:#000000;font-size:13px;">Fam Num</th>
								</tr>
							</thead>
							<tbody>
							 <?php
                foreach($this->model->AsignacionesOBListado() as $row):
                $empleadonrodocto = $row->empleado;
                $beneficiarionrodocto = $row->beneficiario;
                $empleado = $this->model->EmpleadoObtener($empleadonrodocto);
                $beneficiario = $this->model->BeneficiarioObtener($empleadonrodocto, $beneficiarionrodocto);
                //$hijos = $this->model->DatosHijos($empleadonrodocto, $beneficiarionrodocto);
                //------- Pre Natal --------
                $prenatal = $this->model->PreNatalFilasNum($empleadonrodocto, $beneficiarionrodocto);
                //------- Hijo Menor ------------
                $fecha_actual = date("Y-m-d");
                $fecha_uno = date("Y-m-d",strtotime($fecha_actual."- 5 year"));//resto 5 años
				        $fecha_final = date("Y-m-d",strtotime($fecha_uno."- 5 month"));//resto 5 meses
                $hijomenor = $this->model->HijoMenorFilasNum($empleadonrodocto, $beneficiarionrodocto, $fecha_actual, $fecha_final);
                //------- Prescolar --------
                $escuelanivel = 1;
                $escuelaprescolar = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
                //------- Nivel Primaria ---------
                $escuelanivel = 2;
                $escuelaprimaria = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
                //------- Nivel Medio Y Superior ---------
                $escuelanivel = 3;
                $escuelamedsup = $this->model->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
                //------ Capacidades diferentes  ----------
                $hijodisc = $this->model->HijoDiscFilasNum($empleadonrodocto, $beneficiarionrodocto);
                //------ Escolar con Capacidades diferentes  ----------
                $hijodiscesc = $this->model->HijoDiscEscFilasNum($empleadonrodocto, $beneficiarionrodocto);
                //-----Total de asignaciones --------
                $totalasignaciones = $hijomenor->hijom +
                                     $escuelaprescolar->escuelac +
                                     $escuelaprimaria->escuelac +
                                     $escuelamedsup->escuelac +
                                     $hijodisc->hijodisc +
                                     $hijodiscesc->hijodiscesc;
               ?>
								<tr>
                  <td style="color:#000000;font-size:13px;"><?php echo $empleado->legempleado_apellido.", ".$empleado->legempleado_nombres; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $row->empleado; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $beneficiario->benapellido.", ".$beneficiario->bennombres; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $row->beneficiario; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $prenatal->prenatalc; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $hijomenor->hijom; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $escuelaprescolar->escuelac; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $escuelaprimaria->escuelac; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $escuelamedsup->escuelac; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $hijodisc->hijodisc; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $hijodiscesc->hijodiscesc; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $totalasignaciones; ?></td>
                  <td style="color:#000000;font-size:13px;">
                    <?php
                      //echo $fechafinal;
                      $familianum = 0;
                      if($totalasignaciones < 3){
                        //----- no tiene familia numerosa
                      }else{
                        $familianum = $totalasignaciones - 2;
                      }
                      echo $familianum;
                    ?>
                  </td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
          <br>
          <div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Novedades</h5>
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
	<script src="includes/js/otrosbeneficiarios.js"></script>
	<script>
		$('document').ready(function(){
				//load(1);
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],

				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"language": {
				"sProcessing":     "Procesando...",
    		"sLengthMenu":     "Mostrar _MENU_ registros",
    		"sZeroRecords":    "No se encontraron resultados",
    		"sEmptyTable":     "Ningún dato disponible en esta tabla",
    		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    		"sInfoPostFix":    "",
    		"sSearch":         "Buscar:",
    		"sUrl":            "",
    		"sInfoThousands":  ",",
    		"sLoadingRecords": "Cargando...",
    		"oPaginate": {
        /*
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
        */
        "sFirst":    "<<",
        "sLast":     ">>",
        "sNext":     ">",
        "sPrevious": "<"
    		},
    		"oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    	  }
				},
			});
		});
	</script>
</body>
</html>