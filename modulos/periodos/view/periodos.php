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
	<?php include("modal_periodomodificar.php");?>
	<?php include("modal_periodocerrar.php");?>
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
                   		</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Periodos</h5>
						</div>
					</div>
					<?php
						$per = $this->model->PeriodoActual();
						if(!empty($per->periodo_id)){
					?>
					<div class="row">
						<div class="col-md-3">
							<div class="p-3 mb-2 bg-secondary text-white">Periodo Actual</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-info text-white"><?php echo "$per->periodo_nombre"; ?></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="p-3 mb-2 bg-secondary text-white">Horas Extras y Jornal</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-info text-white">Desde</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-success text-white">
								<?php
								$periodohsextjori = date("d/m/Y", strtotime($per->periodo_hsext_jor_i));
								echo "$periodohsextjori";
								?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-info text-white">Hasta</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-success text-white">
								<?php
								$periodohsextjorf = date("d/m/Y", strtotime($per->periodo_hsext_jor_f));
								echo "$periodohsextjorf";
								?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="p-3 mb-2 bg-secondary text-white">Presentismo</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-info text-white">Desde</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-success text-white">
								<?php
								 $periodopresentismoi = date("d/m/Y", strtotime($per->periodo_presentismo_i));
								 echo "$periodopresentismoi";
								 ?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-info text-white">Hasta</div>
						</div>
						<div class="col-md-2">
							<div class="p-3 mb-2 bg-success text-white">
								<?php
									$periodopresentismof = date("d/m/Y", strtotime($per->periodo_presentismo_f));
									echo "$periodopresentismof";
								?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dataUpdatePeriodo" data-titulo="<?php echo "Edicion de Periodo"; ?>" data-id="<?php echo $per->periodo_id; ?>" data-pernombre="<?php echo $per->periodo_nombre; ?>" data-perhorasjori="<?php echo $per->periodo_hsext_jor_i; ?>" data-perhorasjorf="<?php echo $per->periodo_hsext_jor_f; ?>" data-perpresentismoi="<?php echo $per->periodo_presentismo_i; ?>" data-perpresentismof="<?php echo $per->periodo_presentismo_f; ?>"><i class="fa fa-edit" aria-hidden="true"></i> Editar</button>
							<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dataClosePeriodo" data-titulo="<?php echo "Cerrar Periodo ".$per->periodo_nombre." ?"; ?>" data-id="<?php echo $per->periodo_id; ?>"><i class="ion-locked" aria-hidden="true"></i> Cerrar</button><br><br>
						</div>
					</div>
					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
						<div class="clearfix mb-20">
							<div class="pull-left">
								<h5 class="text-blue">Periodos Anteriores</h5>
							</div>
						</div>
						<div class="row">
							<table class="data-table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th>Periodo</th>
										<th>Horas Extras y Jornal</th>
										<th>Presentismo</th>
										<th class="table-plus datatable-nosort">Accion</th>
									</tr>
								</thead>
								<tbody>
								 <?php foreach($this->model->Periodos() as $row): ?>
									<tr>
										<td><?php echo $row->periodo_nombre; ?></td>
										<td>
											<?php
											$periodohsextjori = date("d/m/Y", strtotime($row->periodo_hsext_jor_i));
											$periodohsextjorf = date("d/m/Y", strtotime($row->periodo_hsext_jor_f));
											echo "Desde ".$periodohsextjori." Hasta ".$periodohsextjorf;
											?>
										</td>
										<td>
											<?php
												$periodopresentismoi = date("d/m/Y", strtotime($row->periodo_presentismo_i));
												$periodopresentismof = date("d/m/Y", strtotime($row->periodo_presentismo_f));
												echo "Desde ".$periodopresentismoi." Hasta ".$periodopresentismof;
											?>
										</td>
										<td>
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataDelete" data-id=""  >Re-abrir <i class="ti-unlock" aria-hidden="true" disabled></i></button>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php
						}else{
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="left">
									<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dataUpdatePeriodo" data-titulo="<?php echo "Nuevo Periodo"; ?>"><i class="ti-unlock fa-2x" aria-hidden="true"></i><i class="ion-plus-round"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
						<div class="clearfix mb-20">
							<div class="pull-left">
								<h5 class="text-blue">Periodos Anteriores</h5>
							</div>
						</div>
						<div class="row">
							<table class="data-table stripe hover nowrap">
								<thead>
									<tr>
										<th>Periodo</th>
										<th>Horas Extras y Jornal</th>
										<th>Presentismo</th>
										<th class="table-plus datatable-nosort">Accion</th>
									</tr>
								</thead>
								<tbody>
								 <?php foreach($this->model->Periodos() as $row): ?>
									<tr>
										<td><?php echo $row->periodo_nombre; ?></td>
										<td>
											<?php
											$periodohsextjori = date("d/m/Y", strtotime($row->periodo_hsext_jor_i));
											$periodohsextjorf = date("d/m/Y", strtotime($row->periodo_hsext_jor_f));
											echo "Desde ".$periodohsextjori." Hasta ".$periodohsextjorf;
											?>
										</td>
										<td>
											<?php
												$periodopresentismoi = date("d/m/Y", strtotime($row->periodo_presentismo_i));
												$periodopresentismof = date("d/m/Y", strtotime($row->periodo_presentismo_f));
												echo "Desde ".$periodopresentismoi." Hasta ".$periodopresentismof;
											?>
										</td>
										<td>
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataDelete" data-id=""  >Re-abrir<i class="ti-unlock" aria-hidden="true" disabled></i></button>
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
	<!-- <script src="../../src/scripts/jquery.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
	<script src="includes/periodos.js"></script>
	

	<script>
		$('document').ready(function(){
			
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				"order": [[ 0, "desc" ]],
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
