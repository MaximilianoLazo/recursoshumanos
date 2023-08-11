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

	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Listados</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Listados</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">

							<div class="clearfix mb-20">
								<div class="pull-left">
									<?php $periodomax = $this->model->CJMDGPeriodoObtener(); ?>
									<h5 class="text-blue">Totales a Procesar - Período: <?php echo substr($periodomax->periodo_presentismo_f,5,2) .'/'.substr($periodomax->periodo_presentismo_f,0,4); ?></h5>
								</div>

							</div>
					</div>
					<div class="row">

						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>Concepto</th>
									<th>Descripción</th>
									<th>Cantidad</th>
                  <th>Importe</th>
	     						<th>Observaciones</th>
								</tr>
							</thead>
							<tbody>
							 <?php $sum_total =0;foreach($this->model->ListarTotales($periodomax->periodo_id) as $row): ?>
								<tr>
                  <td><?php echo $row->codigo;?></td>
      						<td><?php echo $row->detalle; ?></td>
								 	<td><?php echo $row->cantidad;?></td>
								 	<td><?php echo $row->total;?></td>
								 	<td><?php echo "";?></td>
								</tr>
							<?php if($row->impacto=='+'){$sum_total=$sum_total+$row->total;}else{$sum_total=$sum_total-$row->total;} endforeach; ?>
							<input type="hidden" class="form-control" id="sumatoria" name="sumatoria" value=<?php echo $sum_total;?>>
							</tbody>
						</table>
					</div>
					<div class="row">
					<div class="col-md-12">
							<table class="table" >
								<thead>
									<tr>
									<th scope="col" class="text-blue">TOTAL A PROCESAR : <?php echo $sum_total; ?></th>
									</tr>
								</thead>

							</table>
						</div>
				  </div>
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="row">
						<div class="col-md-12">
							<table class="table">
								<thead>
									<tr>
									<th scope="col" class="text-blue">TOTALES GENERALES</th>
									</tr>
									<tr>
									<th scope="col" class="text-blue">Descripción</th>
									<th scope="col" class="text-blue">Importe</th>
									</tr>
								</thead>
								<tbody>
								<?php $suma_total=0; foreach($this->model->ListarTotalesxCat($periodomax->periodo_id) as $row): ?>
									<tr>
									<td><?php echo $row->categoria_jub_descripcion.'('.$row->cant_cat.')';?></td>
									<td><?php echo $row->importe_cat;$suma_total=$suma_total+$row->importe_cat;?></td>
									</tr>
								<?php endforeach; ?><tr>
									<td><?php echo "TOTAL GENERAL";?></td>
									<td><?php echo $suma_total;?></td>
									</tr>
								</tbody>
							</table>
						</div>
				  	</div>
					<div class="row">
						<div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                  <th scope="col" class="text-blue">TOTALES GENERALES</th>
                  </tr>
                  <tr>
                  <th scope="col" class="text-blue">Descripción</th>
                  <th scope="col" class="text-blue">Importe</th>
                  </tr>
                </thead>
                <tbody>
                <?php $suma_total=0; foreach($this->model->ListarTotalesxCat($periodomax->periodo_id) as $row): ?>
                  <tr>
                  <td><?php echo $row->categoria_jub_descripcion.'('.$row->cant_cat.')';?></td>
                  <td><?php echo $row->importe_cat;$suma_total=$suma_total+$row->importe_cat;?></td>
                  </tr>
                <?php endforeach; ?><tr>
                  <td><?php echo "TOTAL GENERAL";?></td>
                  <td><?php echo $suma_total;?></td>
                  </tr>
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
	<script src="includes/js/listado.js"></script>
	<script>
		$('document').ready(function(){

			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false
          //targets: [0],
          //visible: false,
          //searchable: false
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
        "order": [[ 0, "asc" ]],
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"language": {
				"sProcessing":     "Procesando...",
    		"sLengthMenu":      "Mostrar _MENU_ registros",
    		"sZeroRecords":    "No se encontraron resultados",
    		"sEmptyTable":     "Ningún dato disponible en esta tabla",
    		"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
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
