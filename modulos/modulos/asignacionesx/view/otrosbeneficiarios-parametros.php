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
	<?php include("includes/mdl/obconfprenatalmodificar.php");?>
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
							<h5 class="text-blue">Configuracion de Asignaciónes</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="card">
  							<h5 class="card-header">Asignación por Pre-Natal</h5>
  							<div class="card-body">
									<?php
										$dprenatal = $this->model->ParametrosPreNatal();
										$prenatalhastauno = number_format($dprenatal[0]->paramprenatal_hasta, 2, ',', '.');
										$prenataldesdedos = number_format($dprenatal[1]->paramprenatal_desde, 2, ',', '.');
										$prenatalhastados = number_format($dprenatal[1]->paramprenatal_hasta, 2, ',', '.');
										$prenataldesdetres = number_format($dprenatal[2]->paramprenatal_desde, 2, ',', '.');
										$prenatalhastatres = number_format($dprenatal[2]->paramprenatal_hasta, 2, ',', '.');
										$prenataldesdecuatro = number_format($dprenatal[3]->paramprenatal_desde, 2, ',', '.');
									?>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprenataldesdeuno" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenataldesdeuno" name="txtprenataldesdeuno" Value="" placeholder="#" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprenatalhastauno" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenatalhastauno" name="txtprenatalhastauno" Value="<?php echo "$ ".$prenatalhastauno; ?>" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprenataldesdedos" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenataldesdedos" name="txtprenataldesdedos" Value="<?php echo "$ ".$prenataldesdedos; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprenatalhastados" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenatalhastados" name="txtprenatalhastados" Value="<?php echo "$ ".$prenatalhastados; ?>" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprentaldesdetres" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprentaldesdetres" name="txtprentaldesdetres" Value="<?php echo "$ ".$prenataldesdetres; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprenatalhastatres" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenatalhastatres" name="txtprenatalhastatres" Value="<?php echo "$ ".$prenatalhastatres; ?>" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprenataldesdecuatro" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenataldesdecuatro" name="txtprenataldesdecuatro" Value="<?php echo "$ ".$prenataldesdecuatro; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprentalhastacuatro" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprentalhastacuatro" name="txtprentalhastacuatro" Value="" placeholder="#" disabled>
										</div>
									</div>
									<br>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateOBConfPreNatal" data-titulo="<?php echo "Edicion: "; ?>" data-obcpniduno="<?php echo $dprenatal[0]->paramprenatal_id; ?>" data-obcpnhastauno="<?php echo $dprenatal[0]->paramprenatal_hasta; ?>" data-obcpniddos="<?php echo $dprenatal[1]->paramprenatal_id; ?>"	data-obcpndesdedos="<?php echo $dprenatal[1]->paramprenatal_desde; ?>"	data-obcpnhastados="<?php echo $dprenatal[1]->paramprenatal_hasta; ?>" data-obcpnidtres="<?php echo $dprenatal[2]->paramprenatal_id; ?>" data-obcpndesdetres="<?php echo $dprenatal[2]->paramprenatal_desde; ?>" data-obcpnhastatres="<?php echo $dprenatal[2]->paramprenatal_hasta; ?>" data-obcpnidcuatro="<?php echo $dprenatal[3]->paramprenatal_id; ?>"	data-obcpndesdecuatro="<?php echo $dprenatal[3]->paramprenatal_desde; ?>">Editar</button>
  							</div>
							</div>
						</div>
						<br>
						<div class="col-md-6">
							<div class="card">
  							<h5 class="card-header">Asignación por Hijo</h5>
  							<div class="card-body">
									<?php
										$dhijo = $this->model->ParametrosHijo();
										$hijohastauno = number_format($dhijo[0]->paramhijo_hasta, 2, ',', '.');
										$hijodesdedos = number_format($dhijo[1]->paramhijo_desde, 2, ',', '.');
										$hijohastados = number_format($dhijo[1]->paramhijo_hasta, 2, ',', '.');
										$hijodesdetres = number_format($dhijo[2]->paramhijo_desde, 2, ',', '.');
										$hijohastatres = number_format($dhijo[2]->paramhijo_hasta, 2, ',', '.');
										$hijodesdecuatro = number_format($dhijo[3]->paramhijo_desde, 2, ',', '.');
									?>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprenataldesdeuno" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenataldesdeuno" name="txtprenataldesdeuno" Value="" placeholder="#" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprenatalhastauno" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenatalhastauno" name="txtprenatalhastauno" Value="<?php echo "$ ".$hijohastauno; ?>" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprenataldesdedos" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenataldesdedos" name="txtprenataldesdedos" Value="<?php echo "$ ".$hijodesdedos; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprenatalhastados" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenatalhastados" name="txtprenatalhastados" Value="<?php echo "$ ".$hijohastados; ?>" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprentaldesdetres" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprentaldesdetres" name="txtprentaldesdetres" Value="<?php echo "$ ".$hijodesdetres; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprenatalhastatres" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenatalhastatres" name="txtprenatalhastatres" Value="<?php echo "$ ".$hijohastatres; ?>" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="txtprenataldesdecuatro" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprenataldesdecuatro" name="txtprenataldesdecuatro" Value="<?php echo "$ ".$hijodesdecuatro; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="txtprentalhastacuatro" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="txtprentalhastacuatro" name="txtprentalhastacuatro" Value="" placeholder="#" disabled>
										</div>
									</div>
									<br>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateOBConfHijo" data-titulo="<?php echo "Edicion: "; ?>" data-obchiduno="<?php echo $dhijo[0]->paramhijo_id; ?>" data-obchhastauno="<?php echo $dhijo[0]->paramhijo_hasta; ?>" data-obchiddos="<?php echo $dhijo[1]->paramhijo_id; ?>"	data-obchdesdedos="<?php echo $dhijo[1]->paramhijo_desde; ?>"	data-obchhastados="<?php echo $dhijo[1]->paramhijo_hasta; ?>" data-obchidtres="<?php echo $dhijo[2]->paramhijo_id; ?>" data-obchdesdetres="<?php echo $dhijo[2]->paramhijo_desde; ?>" data-obchhastatres="<?php echo $dhijo[2]->paramhijo_hasta; ?>" data-obchidcuatro="<?php echo $dhijo[3]->paramhijo_id; ?>"	data-obchdesdecuatro="<?php echo $dhijo[3]->paramhijo_desde; ?>">Editar</button>
  							</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
  							<h5 class="card-header">Asignación por Hijo con Discapacidad</h5>
  							<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
									</div>
									<br>
    							<a href="#" class="btn btn-primary">Editar</a>
  							</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
  							<h5 class="card-header">Otras Asignaciónes</h5>
  							<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Desde:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
										<div class="col-md-6">
											<label for="TxtEmpFechaInicioAdd" class="control-label">Hasta:</label>
				              <input type="text" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd" Value="$ 22.839, 00" disabled>
										</div>
									</div>
									<br>
    							<a href="#" class="btn btn-primary">Editar</a>
  							</div>
							</div>
						</div>
					</div>
					<div class="row">

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
	<script src="includes/js/obconfasignacion.js"></script>
	<script>
		$('document').ready(function(){
				load(1);
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
