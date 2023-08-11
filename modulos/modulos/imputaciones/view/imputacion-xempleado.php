<?php

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
	<?php include("includes/modal/imputacionmodificar.php");?>
  <?php include("includes/modal/imputacioneliminar.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Imputaciones</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Imputaciones</li>
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
          <!-- Data tables Imputaciones -->
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Imputaciones</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataUpdateImputacion" data-titulo="Nueva Imputacion">AGREGAR Imputacion</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table-imp table-bordered stripe hover nowrap">
							<thead>
								<tr>
                  <th>Apellido y Nombres</th>
                  <th>DNI</th>
                  <th>Legajo</th>
                  <th>CUIL</th>
                  <th>Sexo</th>
                  <th>Fec Nacimiento</th>
                  <th>E Civil</th>
                  <th>Fec Ingreso</th>
                  <th>Celular</th>
                  <th>Email</th>
                  <th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							 <?php foreach($imputacion as $row): ?>
								<tr>
                  <?php
                    //$imputacionid = $row->imputacion_id;
                    //$empleadosc = $this->model->EmpleadosXImputacion($imputacionid);
                  ?>
                  <td><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
                  <td><?php echo $row->legempleado_nrodocto; ?></td>
                  <td><?php echo $row->legempleado_numero; ?></td>
                  <td><?php echo $row->legempleado_nrocuil; ?></td>
                  <td><?php echo $row->sexo_nombre; ?></td>
                  <td><?php echo $row->legempleado_fecnacto; ?></td>
                  <td><?php echo $row->estcivil_nombre; ?></td>
                  <td><?php echo $row->legempleado_fecingreso; ?></td>
                  <td><?php echo $row->legempleado_celular; ?></td>
                  <td><?php echo $row->legempleado_email; ?></td>
									<td>
										<!-- Boton ver -->
										<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataViewEscuela" data-titulo="<?php echo "Nuev@ Escuela / Institucion"; ?>"><i class="icon-copy fa fa-eye" aria-hidden="true"></i></button>
										<!-- Boton editar -->
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateImputacion" data-titulo="Edicion de Imputacion" data-id="<?php echo $row->imputacion_id; ?>" data-impcodigow="<?php echo $row->imputacion_codigow; ?>" data-impcodigos="<?php echo $row->imputacion_codigos; ?>" data-impnombre="<?php echo $row->imputacion_nombre; ?>"><i class="icon-copy fi-pencil" aria-hidden="true"></i></button>
										<!-- Boton deshabilitar -->
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDeleteImputacion" data-id="<?php echo $row->imputacion_id; ?>"><i class="icon-copy fa fa-trash" aria-hidden="true"></i></button>
                    <!-- Boton Listado -->
                    <a  class="btn btn-info" href="?c=imputacion&a=ListadoEmpleadosXImputaciones&id=<?php echo $row->imputacion_id; ?>"><i class="icon-copy fa fa-list" aria-hidden="true"></i></a>
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
	<script src="includes/js/imputacion.js"></script>
	<script>
		$('document').ready(function(){
				load(1);
			$('.data-table-imp').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
        /*
        "columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 3 ],
                "visible": false
            }
        ]
        */
        "order": [[ 1, "asc" ]],
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
      $('.data-table-sec').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],

        "order": [[ 1, "asc" ]],
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
