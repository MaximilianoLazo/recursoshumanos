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
	<?php include("includes/modal/excepcion-modificar.php");?>
  <?php //include("modal_lugardetrabajoeliminar.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Excepciónes</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Ingreso de Excepciónes</li>
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
							<h5 class="text-blue">Listado de Excepciónes</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dataUpdateExcepcion" data-titulo="Ingreso de Excepciones" data-ficha="<?php echo "1"; ?>"><i class="ion-android-contact fa-2x" aria-hidden="true"></i><i class="ion-plus-round"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>Nro Docto</th>
                  <th>Apellido y Nombres</th>
									<th>Periodo</th>
                  <th>Fecha</th>
		              <th>Hora I.</th>
                  <th>Hora F.</th>
                  <th>Ficha?</th>
                  <th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							 <?php foreach($this->model->ListarExcepciones() as $row): ?>
								<tr>
									<td><?php echo $row->legempleado_nrodocto; ?></td>
                  <td><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
									<td><?php echo $row->periodo_nombre; ?></td>
                  <td>
                    <?php
                      //$hextrasfecha = date("d/m/Y", strtotime($row->hextras_fecha));
                      //echo $hextrasfecha;
                      echo $row->excepcion_fecha;
                    ?>
                  </td>
                  <td><?php echo $row->excepcion_horai; ?></td>
                  <td><?php echo $row->excepcion_horaf; ?></td>
                  <td>
                    <?php
                      //echo $row->hextras_ficha;
                    ?>
  										<div class="custom-control custom-checkbox mb-5">
  										   <input type="checkbox" name="" id="" value="<?php echo $row->excepcion_ficha; ?>" <?php if($row->excepcion_ficha==1){echo 'checked="checked"';}?> class="custom-control-input"/>
  										   <label class="custom-control-label" for=""></label>
                      </div>
                  </td>
									<td>
										<!-- Boton ver -->
										<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataViewEscuela" data-titulo="<?php echo "Nuev@ Escuela / Institucion"; ?>"><i class="icon-copy fa fa-eye" aria-hidden="true"></i></button>
										<!-- Boton editar -->
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateExcepcion" data-titulo="<?php echo "Edicion de Excepciones"; ?>" data-id="<?php echo $row->excepcion_id; ?>" data-periodo="<?php echo $row->periodo_id; ?>" data-fecha="<?php echo $row->excepcion_fecha; ?>" data-nrodocto="<?php echo $row->legempleado_nrodocto; ?>" data-horai="<?php echo $row->excepcion_horai; ?>" data-horaf="<?php echo $row->excepcion_horaf; ?>" data-ficha="<?php echo $row->excepcion_ficha; ?>"><i class="icon-copy fi-pencil" aria-hidden="true"></i></button>
										<!-- Boton deshabilitar -->
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDeleteLugarDeTrabajo" data-id=""><i class="icon-copy fa fa-trash" aria-hidden="true"></i></button>
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
	<script src="includes/js/excepcion.js"></script>
  <script src="//cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js"></script>
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
          //targets: 3,
          //render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
				}],

        columnDefs: [ {
          targets: 3,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
        }],


				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
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
