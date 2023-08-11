<!DOCTYPE html>
<html>

<head>
	<?php include('../../includes/head.php');

		$nrodocto=$_GET['id'];

  	$jubilado_datos = $this->model->JubiladoObtenerLeg($nrodocto);
  	$periodo=$this->model->PeriodoActivoListar();

   ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/alta-novedad.php");?>
	<?php include("includes/mdl/borra-novedad.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Novedades</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Novedades</li>
							</ol>
							</nav>
						</div>

					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Novedades de Empleado <?php echo $jubilado_datos->legajo_apellido.", ".$jubilado_datos->legajo_nombres .' - Período: ' . $periodo->periodo_nombre ; ?></h5>
						</div>
					</div>
          <div class="row">
		  <div class="row">
			<div class="col-md-12">
				<div class="row">

					<div class="col-md-3">
					<a href="#"
								class="btn btn-success"
								data-toggle="modal"
								data-target="#AltaNovedad"
								data-titulo="<?php echo "Nueva Novedad" ; ?>"
								data-jubidtar="<?php echo $nrodocto; ?>"
								data-periodo="<?php echo $periodo->periodo_id; ?>">
								<i class="ion-android-add-circle" style="font-weight: bold;"></i>
								Nueva Novedad
								</a>
					</div>

				</div>
			</div>
            <div class="col-md-12">

              <br>
            </div>
          </div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>Código</th>
									<th>Novedad</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$jubilado_novedad = $this->model->NovedadesJubListar($nrodocto,$periodo->periodo_id);
								foreach($jubilado_novedad as $row): ?>
									<tr>
										<td><?php echo $row->liqcod_jub_id; ?></td>
										<td><?php echo $row->liqcod_nombre; ?></td>
										<td><?php echo $row->importe_novedad; ?></td>
									</tr>
								<?php
								endforeach; ?>
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
	<script src="includes/js/liquidacion.js"></script>

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
				/*
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'pdf', 'print'
				]*/
			});
		});
	</script>
</body>
</html>
