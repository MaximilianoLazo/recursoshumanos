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
	<!--**********ventanas modal***********-->

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
							<h5 class="text-blue">Listado de Relojes</h5>
						</div>
					</div>
					<div class="row">
						<?php
							exec('c:\WINDOWS\system32\cmd.exe /c START /B C:\xampp\htdocs\controlhorario\itktool\online.bat');
							$lineas = file('../../itktool/online-respuesta.txt');
							foreach($lineas as $numero => $linea){
								$dato = explode(" ", $linea);
								//-----Datos a insertar ------
								$ippuerto = explode(":", $dato[0]);
								$ip = $ippuerto[0];
								$nodo = $dato[1];
								$codigoe = $dato[2];
								$accion = "PANEL";

									$this->model->RelojesSeg($ip, $nodo, $codigoe, $accion);
							}
						?>
						<div class="col-md-12">
							<div id="tabladato" class="table-responsive">
								<table class="table table-striped table-hover">
	  							<thead>
	    							<tr>
	      							<th scope="col">Nombre</th>
											<th scope="col">Tipo</th>
											<th scope="col">IP</th>
											<th scope="col">Nodo</th>
											<th scope="col">Empleados</th>
											<th scope="col">Estado</th>
	    							</tr>
	  							</thead>
	  							<tbody>
									<?php foreach($this->model->Relojes() as $row): ?>
									<?php
											foreach($lineas as $numero => $linea) {
												$dato = explode(" ", $linea);

												$ip = explode(":", $dato[0]);
												if($ip[0] == $row->reloj_ip && $dato[2] == 1){
													$estado = 1;
												}elseif($ip[0] == $row->reloj_ip && $dato[2] == 1014){
													$estado = 0;
												}else{

												}
											}

									?>
	    							<tr>
	      							<th scope="row"><?php echo $row->reloj_nombre; ?></th>
											<th scope="row"><?php echo $row->relojtipo_nombre; ?></th>
											<th scope="row"><?php echo $row->reloj_ip; ?></th>
											<th scope="row"><?php echo $row->reloj_nodo; ?></th>
											<th scope="row"><?php echo $row->empleados; ?></th>
											<th scope="row">
												<?php
													if($estado == 1){
														?>
															<span class="badge badge-success">En linea</span>
														<?php
													}elseif($estado == 0){
														?>
															<span class="badge badge-danger">Fuera de Linea</span>
														<?php
													}else{

													}
												?>
											</th>
	    							</tr>
									<?php endforeach; ?>
	  							</tbody>
								</table>
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
	<!-- <script src="../../src/scripts/jquery.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
	<script src="../../src/scripts/legempleados.js"></script>
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

		//setTimeout(refrescarTabla, 5000); //Se llamará cada 5 segundos y se refrescarán los datos de dicha tabla que
		function refrescarTabla(){
        $('#tabladato').load('view/prueba.php', function(){
               //Realizar las funciones pertinentes
        });
    }
		setInterval(function(){
   			refrescarTabla();
		}, 60000);

		/*
		function sendRequest() {
  		$.ajax({
    		url: "view/prueba.php",
    		success: function(result){
      		$('#tabladato').text(result);
    		}
  		});
		});
		setInterval(function(){
   		sendRequest();
		}, 3000);
		*/
	</script>
</body>
</html>
