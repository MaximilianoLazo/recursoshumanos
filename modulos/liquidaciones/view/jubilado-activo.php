<!DOCTYPE html>
<html>
<head>

	<?php include('../../includes/head.php'); ?>

	<!-- ******** ventanas modal ********** -->
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-steps/build/jquery.steps.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa1.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa2.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa3.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa4.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<?php include("includes/mdl/recibo-xempleado.php");?>

	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">

							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Recibo x Empleado</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Liquidación Previa x Jubilado </h5>
						</div>
					</div>

					<div class="row">
					<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>Apellido y Nombres</th>
									<th>N&deg; Legajo</th>
									<th>Tipo Docto</th>
									<th>N&deg; Docto</th>

									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							 	foreach($this->model->ListarJubiladosRec() as $row):
 							 ?>
								<tr>
				            <td><?php echo $row->legajo_apellido.",".$row->legajo_nombres; ?></td>
                		<td><?php	echo $row->legajo_id;	?></td>
                  	<td><?php echo $row->doctipo_abreviacion; ?></td>
								  	<td><?php echo $row->legajo_nrodocto; ?></td>
								  <td>

									<button type="button"
										class="btn btn-warning"
										data-toggle="modal"
										data-target="#dataTableViewRecibo"
										data-titulo="Editar Recibo"
										data-id="<?php echo $row->legajo_id; ?>">
										<i class="icon-copy fa fa-list" aria-hidden="true"></i>
									</button>

		     					 </td>
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

	<!-- script propio de formulario -->
	<script src="includes/js/liquidacion.js"></script>
	<script src="../../src/plugins/jquery-steps/build/jquery.steps.js"></script>


</body>
</html>
