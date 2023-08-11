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
  <?php include("includes/mdl/jubilado-editar.php");?>
  <?php include("includes/mdl/jubilado-editarjub.php");?>
  <?php include("includes/mdl/jubilado-alta.php");?>
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
              <!--<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>-->
              <?php
              //$destinodatos = $this->model->DestinoObtener($_SESSION["destino_id"]);
              ?>

            </div>
          </div>
        </div>
        <!-- Simple Datatable start -->
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
          <div class="clearfix mb-20">

            <!--<div class="pull-left">
							<h5 class="text-blue">Bienvenidos al nuevo Sistema de Expedientes!!!</h5>
              <h5 class="text-blue"><?php //echo $_SESSION['usuario_tipo_id'];
                                    ?></h5>
						</div>-->
          </div>
          <div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Empleados en Condiciones de Jubilar</h5>
							
						</div>

						<table class="data-table table-bordered stripe hover nowrap">
						
						<button type="button"
								class="btn btn-success"
								data-toggle="modal"
								data-target="#JubiladoAlta"
								data-titulo="<?php echo 'NUEVO JUBILADO'; ?>"
								>
								NUEVO JUBILADO
              			</button>
							<thead>
								<tr>
									<!--<th class="table-plus datatable-nosort" width="8%">#- - - - - -</th>-->
									<th>Apellido y Nombres</th>
									<th>N&deg; Legajo</th>
									<th>Tipo Docto</th>
									<th>N&deg; Docto</th>
									<th>N&deg; CUIL</th>
									<th>Fec Nacimiento</th>
									
									<th>Celular</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							 	foreach($this->model->ListarAJubilar() as $row):
									$fechanac= new datetime($row->legajo_fecnacto);
									$fechain=$fechanac->format('d/m/Y');
							 ?>
								<tr>
									<td><?php echo $row->legajo_apellido.",".$row->legajo_nombres; ?></td>
									<td><?php echo $row->legajo_id;	?></td>
									<td><?php echo $row->doctipo_abreviacion; ?></td>
									<td><?php echo $row->legajo_nrodocto; ?></td>
									<td><?php echo $row->legajo_cuil; ?></td>
									<td><?php echo $fechain; ?></td>
									
									<td><?php echo $row->legajo_celular; ?></td>
									<td>
									<!-- TRAER DATOS DEL LEGAJO SI ESTá EN HABER -->	
									<?php $jubilado_datos = $this->model->JubiladoObtenerEdicionHaber($row->legajo_id); $c=count($jubilado_datos);
									if ($c==1){ ?>
										<a href="index.php?c=legajo&a=JubiladoEditar&id=<?php echo $row->legajo_id?>&seccion=0"  style="color: green;">
                  							Editar Jubilación<i class ='icon-copy ion-android-done-all'></i>
                   						 </a> <?php } else{
									?>
									<?php if(empty($row->situacion_revista_fecingreso)){ ?>
											<a href="#"
											style="color: green;"
											data-toggle="modal"
											data-target="#JubiladoEditarSitRevJub"
											data-titulo="<?php echo "Tramitar Haber Jubilatorio" ; ?>"
											data-jubiladoidn="<?php echo $row->legajo_id; ?>"
											data-dni="<?php echo $row->doctipo_nombre.": ". $row->legajo_nrodocto; ?>"
											data-nombre="<?php echo $row->legajo_apellido.",".$row->legajo_nombres;?>"
											data-fecha="<?php echo $row->situacion_revista_fecegreso; ?>"
											data-periodo="<?php echo $per->periodo_id; ?>"
											data-anio="<?php echo $anio->anio; ?>"
											data-mes="<?php echo $per->mes; ?>"
											data-ventana="<?php echo "2"; ?>">
											<i class="icon-copy ion-android-done-all"></i>
											Tramitar Jubilación
											</a>
									<?php } else{	?>
										<a href="#"
											style="color: green;"
											data-toggle="modal"
											data-target="#JubiladoEditarSitRev"
											data-titulo="<?php echo "Tramitar Haber Jubilatorio" ; ?>"
											data-jubiladoidn="<?php echo $row->legajo_id; ?>"					   
											data-dni="<?php echo $row->doctipo_nombre.": ". $row->legajo_nrodocto; ?>"
											data-nombre="<?php echo $row->legajo_apellido.",".$row->legajo_nombres;?>"
											data-fecha="<?php echo $row->situacion_revista_fecingreso; ?>"
											data-periodo="<?php echo $per->periodo_id; ?>"
											data-anio="<?php echo $anio->anio; ?>"
											data-mes="<?php echo $per->mes; ?>"
											data-ventana="<?php echo "1"; ?>">
											<i class="icon-copy ion-android-done-all"></i>
											Tramitar Jubilación
										</a>
									<?php } }?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
        </div>
        <?php include('../../includes/footer.php'); ?>
      </div>

    </div>
    <?php include('../../includes/script.php'); ?>
    <script src="../../src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../src/plugins/jquery-steps/build/jquery.steps.js"></script>
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
    <script src="includes/js/legajo.js"></script>
    <script type="text/javascript">
		$('document').ready(function(){
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					className: "dt-right"
        }],
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],

				/*columnDefs: [{
          targets: 6,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
					},
					{
					targets: 8,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
				}],
					*/
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
		});
	</script>
</body>

</html>
