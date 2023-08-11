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
	<?php include("includes/mdl/empleadoagregar.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Empleados</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Empleados</li>
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
							<h5 class="text-blue">Listado de Empleados</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<button type="button" class="btn btn-info">CSV</button>
									<button type="button" class="btn btn-danger">PDF</button>
									<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataAddEmpleado" data-titulo="<?php echo "Nuevo Empleado"; ?>">AGREGAR Empleado</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<!--<th class="table-plus datatable-nosort" width="8%">#- - - - - -</th>-->
									<th>Apellido y Nombres</th>
									<th>N&deg; Docto</th>
									<th>T Legajo</th>
									<th>N&deg; Legajo</th>
									<th>N&deg; CUIL</th>
									<th>Sexo</th>
									<th>Fec Nacimiento</th>
									<th>E Civil</th>
									<th>Fec Ingreso</th>
									<th>Celular</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							 <?php foreach($this->model->ListarEmpleados() as $row): ?>
								<tr>
									<!--
									<td class="table-plus">
										<?php
											$img = '../../imagenes/legajos/'.$row->legempleado_imagen.'.jpg';

											if (file_exists($img)) {
										?>
    										<img width="60px" height="60px" src="../../imagenes/legajos/<?php echo $row->legempleado_imagen; ?>.jpg" alt="image description" class="rounded-circle">
										<?php
											} else {
    										if($row->sexo_id == 1){
										?>
												<img width="60px" height="60px" src="../../imagenes/legajos/avatar-masculino.jpg" alt="image description" class="rounded-circle">
										<?php
												}else{
										?>
												<img width="60px" height="60px" src="../../imagenes/legajos/avatar-femenino.jpg" alt="image description" class="rounded-circle">
										<?php
												}
											}
										?>
									</td>
									-->
									<td><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
									<td><?php echo $row->legempleado_nrodocto; ?></td>
									<td>
										<?php
											$nrodocto = $row->legempleado_nrodocto;
											$legajotipo = $this->model->ObtenerTipoLegajo($nrodocto);
											echo $legajotipo->legtipo_nombre;
										?>
									</td>
									<td class="dt-right"><?php echo $row->legempleado_numero; ?></td>
									<td><?php echo $row->legempleado_nrocuil; ?></td>
									<td><?php echo $row->sexo_nombre; ?></td>
									<td><span style="display: none;"><?php echo $row->legempleado_fecnacto; ?></span><?php echo $row->legempleado_fecnacto; ?></td>
									<td><?php echo $row->estcivil_nombre; ?></td>
									<td><span style="display: none;"><?php echo $row->legempleado_fecingreso; ?></span><?php echo $row->legempleado_fecingreso; ?></td>
									<td><?php echo $row->legempleado_celular; ?></td>
									<td>
										<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataDelete" data-id=""  ><i class="icon-copy fa fa-eye" aria-hidden="true"></i></button>
										<a  class="btn btn-primary" href="?c=empleado&a=Crud&id=<?php echo $row->legempleado_id; ?>&startIndex=0"><i class='icon-copy fi-pencil'></i></a>
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDelete" data-id=""  ><i class="icon-copy fa fa-trash" aria-hidden="true"></i></button>


										<a class="btn btn-info" href="../marcaciones/?c=marcacion&a=ImprimirFichadaLoteI&id=<?php echo $row->legempleado_nrodocto; ?>"><i class="icon-copy fi-clock"></i></a>

										<a class="btn btn-warning" href="../marcaciones/?c=marcacion&a=ImprimirFichadaLoteSinFiltro&id=<?php echo $row->legempleado_nrodocto; ?>"><i class="icon-copy fi-clock"></i></a>

									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
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
	<!--<script src="../../src/plugins/datatables/dataRender/datetime.js"></script>-->
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
	<script src="includes/js/empleados.js"></script>
	<!-- Graficos estadisticos -->
	<!--
	<script src="../../src/plugins/highcharts-6.0.7/code/highcharts.js"></script>
	<script src="../../src/plugins/highcharts-6.0.7/code/highcharts-more.js"></script>
	-->
	<script type="text/javascript">
		$('document').ready(function(){
				//load(1);
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [
            {
							 className: "dt-right"

            }
        ],
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				/*columnDefs: [
					{
          	targets: 6,
          	render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
					},
					{
					targets: 8,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
					}
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
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    		},
    		"oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    	}

				},
			});
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
			var table = $('.select-row').DataTable();
			$('.select-row tbody').on('click', 'tr', function () {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
			var multipletable = $('.multiple-select-row').DataTable();
			$('.multiple-select-row tbody').on('click', 'tr', function () {
				$(this).toggleClass('selected');
			});
		});
	</script>
</body>
</html>
