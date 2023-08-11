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
  <link rel="stylesheet" type="text/css" href="includes/css/tabla-car.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
  <!-- ventanas modal -->
  <?php include("includes/mdl/asignacionesfam-pdf.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Asignaciones Familiares</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Asignaciones Familiares</li>
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
							<h5 class="text-blue">Asignaciones Familiares</h5>
						</div>
					</div>
          <div class="row">
						<div class="col-md-12">
							<div class="form-group">
                <?php
                $periodoactual = $this->model->PeriodoActualObtener();
                $periodoid = $periodoactual->periodo_id;
                $aobfechapase = $this->model->AOBFechaPaseLiqObtener($periodoid);
                $asignacionesc = $this->model->AsignacionesLiqFilasNum($periodoid);

                //date_default_timezone_set("America/Buenos_Aires");
                $date = new DateTime(date("$aobfechapase->AUD_asignacion_datetime"));
                $fecha_de_pase = $date->format('d/m/Y H:i:s');

                if($asignacionesc->asignacionc > 0){
                  //--- Pase echo --
                  $periodoidutimopase = $periodoactual->periodo_id;
                  ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    El pase del Periodo <strong><?php echo $periodoactual->periodo_nombre; ?></strong> Se realizo el día --/--/----.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div align="right">
                    <a  class="btn btn-success" href="#">Excel</a>
                    <button type="button"
                            class="btn btn-danger"
                            data-toggle="modal"
                            data-target="#dataViewAsignacionesFamPDF"
                            data-titulo="<?php echo "Listado de Asignaciones Familiares - PDF"; ?>">PDF
                    </button>
  								</div>
                  <?php
                }else{
                  //--- Pase no echo ---
                  $periodoidutimopase = $periodoactual->periodo_id - 1;
                  ?>
                  <div align="right">
                    <a  class="btn btn-success" href="#">Excel</a>
                    <button type="button"
                            class="btn btn-danger"
                            data-toggle="modal"
                            data-target="#dataViewAsignacionesFamPDF"
                            data-titulo="<?php echo "Listado de Asignaciones Familiares - PDF"; ?>">PDF
                    </button>
                    <!--<a  class="btn btn-success" href="?c=asignacion&a=PaseALiquidaciones">PASAR a Liquidaciones</a>-->
                    <a  class="btn btn-info" href="?c=asignacion&a=AsignacionesPaseALiq">PASAR a Liquidaciones</a>
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
                  <th style="color:#000000;font-size:13px;">Coyuge</th>
                  <th style="color:#000000;font-size:13px;">Pre-Natal</th>
                  <th style="color:#000000;font-size:13px;">H Menor</th>
                  <th style="color:#000000;font-size:13px;">Prescolar</th>
                  <th style="color:#000000;font-size:13px;">Esc Prim</th>
                  <th style="color:#000000;font-size:13px;">Esc Med & Sup</th>
                  <th style="color:#000000;font-size:13px;">DISC</th>
                  <th style="color:#000000;font-size:13px;">Esc DISC</th>
                  <th style="color:#000000;font-size:13px;">Fam Num</th>
                  <th style="color:#000000;font-size:13px;">Total Asig</th>
								</tr>
							</thead>
							<tbody>
							 <?php
                foreach($this->model->AsignacionesListado() as $row):

                $empleadonrodocto = $row->empleado;
                $beneficiarionrodocto = $row->beneficiario;
                $empleado = $this->model->EmpleadoObtener($empleadonrodocto);
                //------- Conyuge --------
                $conyuge = $this->model->ConyugeFilasNum($empleadonrodocto);
                //------- Pre Natal --------
                $prenatal = $this->model->PreNatalFilasNum($empleadonrodocto, $beneficiarionrodocto);
                //------- Hijo Menor ------------
                $fecha_actual = date("Y-m-d");
                $fecha_uno = date("Y-m-d",strtotime($fecha_actual."- 6 year"));//resto 5 años
				        $fecha_final = date("Y-m-d",strtotime($fecha_uno."- 1 month"));//resto 5 meses
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
                 //---------------Calculo de totales ----------
                 $conyuge_total = $conyuge_total + $conyuge->conyugec;
                 $prenatal_total = $prenatal_total + $prenatal->prenatalc;
                 $hijomenor_total = $hijomenor_total + $hijomenor->hijom;
                 $prescolar_total = $prescolar_total + $escuelaprescolar->escuelac;
                 $primaria_total = $primaria_total + $escuelaprimaria->escuelac;
                 $secsup_total = $secsup_total + $escuelamedsup->escuelac;
                 $hijodisc_total = $hijodisc_total + $hijodisc->hijodisc;
                 $escdisc_total = $escdisc_total + $hijodiscesc->hijodiscesc;

                 $totalasignaciones_total = $totalasignaciones_total + $totalasignaciones;

               ?>
								<tr>
                  <td style="color:#000000;font-size:13px;"><?php echo $empleado->legempleado_apellido.", ".$empleado->legempleado_nombres; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $row->empleado; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $conyuge->conyugec; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $prenatal->prenatalc; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $hijomenor->hijom; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $escuelaprescolar->escuelac; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $escuelaprimaria->escuelac; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $escuelamedsup->escuelac; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $hijodisc->hijodisc; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $hijodiscesc->hijodiscesc; ?></td>
                  <td style="color:#000000;font-size:13px;">
                    <?php
                      //echo $fechafinal;
                      $familianum = 0;
                      if($totalasignaciones < 3){
                        //----- no tiene familia numerosa
                      }else{
                        $familianum = $totalasignaciones - 2;
                        $familianum_total = $familianum_total + $familianum;
                      }
                      echo $familianum;
                    ?>
                  </td>
                  <td style="color:#000000;font-size:13px;"><?php echo $totalasignaciones; ?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
          <br>
          <!--
          <div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Novedades</h5>
						</div>
					</div>
          -->
          <div class="row">
            <div class="col-md-12">
							<div class="form-group">


                <div id="no-more-tables">
                  <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table width="100%" class="table table-striped table-hover table-fixed">
                      <thead>
                        <tr>
                          <td style="background: #FFFFFF; font-size: 12px;">PERIODO</td>
                          <td style="background: #FFFFFF" class="tbltdi">CONYUGE</td>
                          <td style="background: #FFFFFF" class="tbltdi">PRE-NATAL</td>
                          <td style="background: #FFFFFF" class="tbltdi">H MENOR</td>
                          <td style="background: #FFFFFF" class="tbltdi">PRESCOLAR</td>
                          <td style="background: #FFFFFF" class="tbltdi">ESC PRIM</td>
                          <td style="background: #FFFFFF" class="tbltdi">ESC MED Y SUP</td>
                          <td style="background: #FFFFFF" class="tbltdi">DISC</td>
                          <td style="background: #FFFFFF" class="tbltdi">ESC DISC</td>
                          <td style="background: #FFFFFF" class="tbltdi">FAM NUM</td>
                          <td style="background: #FFFFFF" class="tbltdi">TOTAL ASIG</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="font-size: 12px; text-align: left;" data-title="Periodo:">
                            <?php echo "******"; ?>
                          </td>
                          <td class="tbltdi" data-title="Conyuge">
                            <?php echo $conyuge_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Pre-Natal">
                            <?php echo $prenatal_total; ?>
                          </td>
                          <td class="tbltdi" data-title="H Menor">
                            <?php echo $hijomenor_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Prescolar">
                            <?php echo $prescolar_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Esc Prim">
                            <?php echo $primaria_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Esc Med & Sup">
                            <?php echo $secsup_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Disc">
                            <?php echo $hijodisc_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Esc Disc">
                            <?php echo $escdisc_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Fam Num">
                            <?php echo $familianum_total; ?>
                          </td>
                          <td class="tbltdi" data-title="Total Asig">
                            <?php echo $totalasignaciones_total; ?>
                          </td>
                        </tr>

                        <?php
                        $titular = 1;
                        $periodos = $this->model->PeriodosObtener(3);
                        //echo var_dump($periodos);
                        foreach ($periodos as $value) {
                          // code...
                          $asignacioesdatosres = $this->model->AsignacioenesResumenPeriodo($value->periodo_id, $titular);
                          foreach ($asignacioesdatosres as $row) {
                            // code...
                            switch ($row->asigtipo_id) {
                              case 1:
                                //----Prenatal;
                                $prenatal_total2 = $row->asignacion_total;
                                break;
                              case 2:
                                //---Hijo menor ---
                                $hijomenor_total2 = $row->asignacion_total;
                                break;

                              case 3:
                                //---Hijo discapacidad ---
                                $hijodisc_total2 = $row->asignacion_total;
                                break;

                              case 4:
                                //---Preescolar ---
                                $prescolar_total2 = $row->asignacion_total;
                                break;

                              case 5:
                                //---escuela primaria ---
                                $primaria_total2 = $row->asignacion_total;
                                break;

                              case 6:
                                //---escuela secundaria y superior ---
                                $secsup_total2 = $row->asignacion_total;
                                break;

                              case 7:
                                //---escuela con discapacidad ---
                                $escdisc_total2 = $row->asignacion_total;
                                break;

                              case 8:
                                //---familia numerosa ---
                                $familianum_total2 = $row->asignacion_total;
                                break;

                              case 9:
                                //---conyuge ---
                                $conyuge_total2 = $row->asignacion_total;
                                break;
                              }
                              $totalasignaciones2 = $hijomenor_total2 +
                                                    $hijodisc_total2 +
                                                    $prescolar_total2 +
                                                    $primaria_total2 +
                                                    $secsup_total2 +
                                                    $escdisc_total2;
                          }
                          ?>
                          <tr>
                            <td style="font-size: 12px; text-align: left;" data-title="Periodo:">
                              <?php echo $value->periodo_nombre; ?>
                            </td>
                            <td class="tbltdi" data-title="Conyuge">
                              <?php echo $conyuge_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Pre-Natal">
                              <?php echo $prenatal_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="H Menor">
                              <?php echo $hijomenor_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Prescolar">
                              <?php echo $prescolar_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Esc Prim">
                              <?php echo $primaria_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Esc Med & Sup">
                              <?php echo $secsup_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Disc">
                              <?php echo $hijodisc_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Esc Disc">
                              <?php echo $escdisc_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Total Asig">
                              <?php echo $familianum_total2; ?>
                            </td>
                            <td class="tbltdi" data-title="Fam Num">
                              <?php echo $totalasignaciones2; ?>
                            </td>
                          </tr>
                          <?php
                          //}
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--Asignaciones info detalles-->
          <div class="row">
            <div class="col-md-12">
							<div class="form-group">
                <?php
                $titular = 1;
                $asiginfodatos = $this->model->AsignacionesInfoListar_DNI($titular);
                foreach ($asiginfodatos as $value) {
                  //echo $value->legempleado_nrodocto."<br>";
                  $empdatos = $this->model->EmpleadoObtener($value->legempleado_nrodocto);
                  ?>
                  <p>
  								<?php echo $value->legempleado_nrodocto." - ".$empdatos->legempleado_apellido.", ".$empdatos->legempleado_nombres; ?>
                  </p>
                  <br>
                  <?php
                  $asiginfodetalles = $this->model->AsignacionesInfoListar_Detalles($titular, $value->legempleado_nrodocto);
                  ?>
                  <div id="no-more-tables">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                      <table width="100%" class="table table-striped table-hover table-fixed">
                        <thead>
                          <tr>
                            <td style="background: #FFFFFF; font-size: 12px;">ASIG T</td>
                            <td style="background: #FFFFFF; font-size: 12px;">INFO T</td>
                            <td style="background: #FFFFFF" class="tbltdi">CANTIDAD</td>
                            <td style="background: #FFFFFF" class="tbltdi">DNI</td>
                            <td style="background: #FFFFFF" class="tbltdi">APELLIDO Y NOMBRES</td>
                            <td style="background: #FFFFFF" class="tbltdi">FECHA</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            foreach ($asiginfodetalles as $value):
                              //
                              $asigtipodatos = $this->model->AsignacionTipoObtener($value->asigtipo_id);
                              $hijodatos = $this->model->HijoObtener_Id($value->asignacion_phc_id);
                              if($value->asignacion_info_tipo == 1){
                                $info_tipo = "Alta";
                              }elseif($value->asignacion_info_tipo == 2){
                                $info_tipo = "Modificacion";
                              }elseif($value->asignacion_info_tipo == 3){
                                $info_tipo = "Baja";
                              }else{
                                $info_tipo = "Error";
                              }
                          ?>
                          <tr>
                            <td style="font-size: 12px; text-align: left;" data-title="Periodo:">
                              <?php echo $info_tipo; ?>
                            </td>
                            <td style="font-size: 12px; text-align: left;" class="tbltdi" data-title="Conyuge">
                              <?php echo $asigtipodatos->asigtipo_nombre; ?>
                            </td>
                            <td class="tbltdi" data-title="Pre-Natal">
                              <?php echo $value->asignacion_cantidad; ?>
                            </td>
                            <td class="tbltdi" data-title="H Menor">
                              <?php echo $hijodatos->leghijo_nrodocto; ?>
                            </td>
                            <td class="tbltdi" data-title="H Menor">
                              <?php echo $hijodatos->leghijo_apellido.", ".$hijodatos->leghijo_nombres; ?>
                            </td>
                            <td class="tbltdi" data-title="Prescolar">
                              <?php echo $value->asignacion_info_actualizacion; ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
            <div class="col-md-12">
							<div class="form-group">



              </div>
            </div>
          </div>
          <!--Fin asignaciones info detalles-->

				</div>
				<!-- Simple Datatable End -->
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
	<!-- <script src="../../src/scripts/jquery.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
	<!--<script src="../../src/scripts/lugaresdetrabajo.js"></script>-->
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

        dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
        ]

			});


      /*
			$('.data-table-export').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"language": {

					"info": "_START_-_END_ of _TOTAL_ entries",
					searchPlaceholder: "Search"
				},
				dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
				]
			});
      */
      /*
			var table = $('.select-row').DataTable();
			$('.select-row tbody').on('click', 'tr', function () {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});*/
      /*
			var multipletable = $('.multiple-select-row').DataTable();
			$('.multiple-select-row tbody').on('click', 'tr', function () {
				$(this).toggleClass('selected');
			});*/
		});
	</script>
</body>
</html>
