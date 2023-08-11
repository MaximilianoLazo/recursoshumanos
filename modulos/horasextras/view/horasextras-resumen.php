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
  <?php include("includes/mdl/horasextras-resumen-pdf.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Horas Extras</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Ingreso de Horas Extras</li>
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
							<h5 class="text-blue">Planilla de Resumen Horas Extras y Jornales</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
                  <button type="button"
                          class="btn btn-success"
                          data-toggle="modal"
                          data-target="#dataViewHorasExtrasResumenExcel"
                          data-titulo="<?php echo "Listado de Horas Extras Completo - Excel"; ?>">Excel
                  </button>
									<button type="button"
                          class="btn btn-danger"
                          data-toggle="modal"
                          data-target="#dataViewHorasExtrasResumenPDF"
                          data-titulo="<?php echo "Listado de Horas Extras Completo - PDF"; ?>">PDF
                  </button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>Lugar de Trabajo</th>
                  <th>Empleados</th>
                  <th>Hs Extras Simples</th>
		              <th>Horas Extras Dobles</th>
                  <th>Jornales</th>
								</tr>
							</thead>
							<tbody>
							 <?php
                foreach($this->model->ListarHorasExtrasResumen() as $row):
               ?>
								<tr>
									<td><?php echo $row->trabajo_nombre; ?></td>
                  <td class="dt-right"><?php echo $row->totalempleados; ?></td>
                  <td class="dt-right"><?php echo $row->totalhorasex_simples; ?></td>
                  <td class="dt-right"><?php echo $row->totalhorasex_dobles; ?></td>
                  <td class="dt-right"><?php echo $row->totalhoras_jornales; ?></td>
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
  <!--<script src="//cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js"></script>-->
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
	<script src="includes/js/horasextras.js"></script>
  <script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="includes/css/horasextras.css">
	<script>
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
        columnDefs: [
          {
					targets: 2,
          render: $.fn.dataTable.render.number('.', ',', 2, ''),
          },
          {
          targets: 3,
          render: $.fn.dataTable.render.number('.', ',', 2, ''),
          },
					{
					targets: 4,
          render: $.fn.dataTable.render.number('.', ',', 2, ''),
					}
				],

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
		});
	</script>
</body>
</html>
