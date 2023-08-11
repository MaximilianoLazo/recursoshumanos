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
	<?php include("includes/mdl/fichadas-tanda-editar.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Fichas Por Tanda</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Empleados</li>
								</ol>
							</nav>
						</div
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Listado de Fichadas por Tanda</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<a  class="btn btn-info" href="?c=marcacion&a=FichadasTanda">Ir a TANDAS</a>
									<button type="button" class="btn btn-success">EXCEL</button>
									<button type="button" class="btn btn-danger">PDF</button>
									<!--<a class="btn btn-primary" href="?c=marcacion&a=FichadasTandaDetallesArchivo">ARCHIVO</a>-->
									<!--<button type="button" class="btn btn-primary">ARCHIVO</button>-->
									<button type="button"
													class="btn btn-primary"
													data-toggle="modal"
													data-target="#FichadasTandaEditar"
													data-titulo="<?php echo "AGREGAR NUEVA TANDA"; ?>">
													AGREGAR Tanda
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>NOMBRE DE TANDA</th>
									<th>FECHA DESDE</th>
									<th>FECHA HASTA</th>
									<th>FECHA DE PROCESO</th>
									<th>EMPLEADOS (C)</th>
									<th>ESTADO</th>
									<th class="datatable-nosort" width="8%">ACCIONES</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							 	foreach($this->model->FichadasTandaArchivoListar() as $row):
									/*$tanda_fecha_desde = date("d/m/Y", strtotime($row->mtanda_fecha_desde));
									$tanda_fecha_hasta = date("d/m/Y", strtotime($row->mtanda_fecha_hasta));*/
									/*$nrodocto = $row->legempleado_nrodocto;
									$legajotipo = $this->model->ObtenerTipoLegajo($nrodocto);*/
									$fictandadetalleiddatosc = $this->model->FichadasTandasDetallesIdFilasNum($row->mtanda_id);
							 ?>
								<tr>
									<td><?php echo $row->mtanda_nombre; ?></td>
									<td class="dt-right">
										<?php
											//echo "Desde ".$tanda_fecha_desde." Hasta ".$tanda_fecha_hasta;
											echo $row->mtanda_fecha_desde;
											?>
									</td>
									<td class="dt-right"><?php echo $row->mtanda_fecha_hasta; ?></td>
									<td class="dt-right"><?php echo $row->mtanda_fecha_proceso; ?></td>
									<td class="dt-right"><?php echo $fictandadetalleiddatosc->tandadetallec; ?></td>
									<td>
										<?php
											if($row->mtanda_estado == 1){
												?>
													<span class="badge badge-warning">
														<i class="fa fa-spinner" aria-hidden="true"></i>&nbsp;Pendiente
													</span>
												<?php
											}elseif($row->mtanda_estado == 2){
												?>
													<span class="badge badge-success">
														<i class="icon-copy fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Disponible
													</span>
												<?php
											}else{

											}
										?>
									</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<!--<i class="fa fa-ellipsis-h"></i>-->
												OPCIONES
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="?c=marcacion&a=FichadasTandaDetalles&id=<?php echo $row->mtanda_id; ?>"><i class="fa fa-eye fa-lg"></i>&nbsp;&nbsp;&nbsp;Detalles</a>
												<?php
													if($row->mtanda_estado == 2){
														?>
															<a class="dropdown-item" href="?c=marcacion&a=FichadasTandaDescarga&id=<?php echo $row->mtanda_archivo; ?>"><i class="fa fa-file-pdf-o fa-lg"></i>&nbsp;&nbsp;&nbsp;Descargar</a>
														<?php
													}
												?>

												<a class="dropdown-item" href="#"><i class="fa fa-archive fa-lg"></i>&nbsp;&nbsp;&nbsp;Archivar</a>
											</div>
										</div>
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
	<script src="includes/js/fichadas-tanda.js"></script>

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

				columnDefs: [{
          targets: 1,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
				},
				{
					targets: 2,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
				},
				{
					targets: 3,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
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
				/*dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
			]*/
			});
		});
	</script>
</body>
</html>
