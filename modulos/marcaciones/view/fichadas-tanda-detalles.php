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
	<?php include("includes/mdl/fichadas-tanda-importar.php");?>
	<?php include("includes/mdl/fichadas-tanda-detalles-editar.php");?>
	<?php include("includes/mdl/fichadas-tanda-detalles-baja.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Fichas Por Tanda</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Empleados</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Listado de Fichadas por Tanda</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<a  class="btn btn-info" href="?c=marcacion&a=FichadasTanda">Ir a TANDAS</a>
									<button type="button" class="btn btn-success">AGREGAR LUGAR DE TRABAJO</button>
									<button type="button"
													class="btn btn-danger"
													data-toggle="modal"
													data-target="#FichadasTandaDetallesGuardar"
													data-titulo="<?php echo "AGREGAR Empleado - Individual"; ?>"
													data-mtandaid="<?php echo $_REQUEST['id']; ?>">
													AGREGAR Empleado
									</button>
									<button type="button"
													class="btn btn-primary"
													data-toggle="modal"
													data-target="#FichadasTandaImportar"
													data-titulo="<?php echo "Importar Listado de Empleados"; ?>"
													data-mtandaid="<?php echo $_REQUEST['id']; ?>">
													IMPORTAR listado
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<?php //var_dump($fictandadetalles); ?>
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>DNI</th>
									<th>APELLIDO Y NOMBRES</th>
									<th>LUGAR DE TRABAJO</th>
									<th>SECRETARIA</th>
									<th>RELOJ</th>
									<th class="datatable-nosort" width="8%">ACCIONES</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							 	foreach($fictandadetalles as $row):
									/*$tanda_fecha_desde = date("d/m/Y", strtotime($row->mtanda_fecha_desde));
									$tanda_fecha_hasta = date("d/m/Y", strtotime($row->mtanda_fecha_hasta));*/
									/*$nrodocto = $row->legempleado_nrodocto;
									$legajotipo = $this->model->ObtenerTipoLegajo($nrodocto);*/
							 ?>
								<tr>
									<td><?php echo $row->legempleado_nrodocto; ?></td>
									<td><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
									<td><?php echo $row->trabajo_nombre; ?></td>
									<td><?php echo $row->secretaria_nombre; ?></td>
									<td><?php echo $row->reloj_nombre; ?></td>
									<td>
										<button type="button"
														class="btn btn-danger"
														data-toggle="modal"
														data-target="#FichadasTandaDetallesBaja"
														data-titulo="<?php echo "Quitar Empleado de Lista"; ?>"
														data-mtandadetalleid="<?php echo $row->mtanda_detalle_id; ?>"
														data-mtandaid="<?php echo $_REQUEST['id']; ?>">
														<i class="fi-prohibited fa-lg" aria-hidden="true"></i>
														&nbsp;Eliminar
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="../../src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
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
	<script src="includes/js/fichadas-tanda.js"></script>

	<!-- FORMULARIO DE IMPORTACION DE ARCHIVOS -->
	<!--<link rel="stylesheet" type="text/css" href="includes/css/normalize.css" />-->
	<link rel="stylesheet" type="text/css" href="includes/css/demo.css" />
	<link rel="stylesheet" type="text/css" href="includes/css/component.css" />
	<!--<script src="includes/js/custom-file-input.js"></script>-->
	<!--<script src="includes/js/jquery-v1.min.js"></script>-->
	<script src="includes/js/jquery.custom-file-input.js"></script>
	<!-- Libreria Ui para ayuda de busqueda -->
	<!--
  <script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="includes/css/fichadas-tanda-detalles.css">
	-->

	<!--- script para busqueda de empleados -->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
	<link rel="stylesheet" type="text/css" href="includes/css/fichadas-tanda-detalles.css">
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
				"order": [[1, "asc"]],
			/*columnDefs: [{
          targets: 6,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
				},
					{
					targets: 2,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
				},
			],*/

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
				/*dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
			]*/

			});
		});
	</script>
</body>
</html>
