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
  <?php include("includes/modal/todopago-modificar.php");?>
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
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Listado de Todo Pago</h5>
						</div>
					</div>
					<div class="row">
            <form action="import.php" method="post" enctype="multipart/form-data" id="import_form">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<input type="file" class="btn btn-outline-success" name="file" />
                  <input type="submit" class="btn btn-primary" name="import_data" value="Importar">
								</div>
							</div>
						</div>
            </form>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
                  <th style="color:#000000;font-size:10px;">ID</th>
                  <th style="color:#000000;font-size:10px;">Empleado</th>
                  <th style="color:#000000;font-size:10px;">Nro Legajo</th>
									<th style="color:#000000;font-size:10px;">Nro Docto</th>
                  <th style="color:#000000;font-size:10px;">S Basico jun/19</th>
                  <th style="color:#000000;font-size:10px;">2,2 % B18</th>
                  <th style="color:#000000;font-size:10px;">10% del 2,2</th>
                  <th style="color:#000000;font-size:10px;">S Basico feb/19</th>
                  <th style="color:#000000;font-size:10px;">Conc 151</th>
                  <th style="color:#000000;font-size:10px;">S Basico feb/19 Comp</th>
                  <th style="color:#000000;font-size:10px;">SB feb/19 com + 10%</th>
                  <th style="color:#000000;font-size:10px;">Basico Nuevo</th>
								</tr>
							</thead>
							<tbody>
							 <?php
                foreach($this->model->ListarImportes() as $row):
                  //$importetotal = $row->importe_basico + $row->importe_147 + $row->importe_147_5 + $row->importe_151 + $row->importe_151_2;
                  $sbasicojun19 = number_format($row->importe_basico_jun19, 2, ',', '.');
                  $importefeb18_2_2 = number_format($row->importe_feb18_2_2, 2, ',', '.');
                  $importefeb18_2_2_10 = number_format($row->importe_feb18_2_2_10, 2, ',', '.');
                  $basicofeb19 = number_format($row->importe_basico_feb19, 2, ',', '.');
                  $concepto151 = number_format($row->importe_concepto151, 2, ',', '.');
                  $basicofeb19compuesto = number_format($row->importe_basico_comfeb19, 2, ',', '.');
                  $basicofeb19compuesto10 = number_format($row->importe_basico_comfeb19_10, 2, ',', '.');
                  $importetotal = number_format($row->importe_total, 2, ',', '.');
               ?>

								<tr>
                  <td style="color:#000000;font-size:13px;"><?php echo $row->importe_id; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $row->legajo_nombre; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $row->legajo_numero; ?></td>
									<td style="color:#000000;font-size:13px;"><?php echo $row->legajo_nrodocto; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo "$ ".$sbasicojun19; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo "$ ".$importefeb18_2_2; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo "$ ".$importefeb18_2_2_10; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo "$ ".$basicofeb19; ?></td>
									<td style="color:#000000;font-size:13px;"><?php echo "$ ".$concepto151; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo "$ ".$basicofeb19compuesto; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo "$ ".$basicofeb19compuesto10; ?></td>
                  <td style="color:#000000;font-size:13px;"><?php echo "$ ".$importetotal; ?></td>
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
	<script src="includes/js/todopago.js"></script>
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
        /*
        dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
				]
        */
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
