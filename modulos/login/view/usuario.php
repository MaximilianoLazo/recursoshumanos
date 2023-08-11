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
	<?php include("includes/mdl/usuario-editar.php");?>
	<?php include("includes/mdl/usuario-eliminar.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Usuarios</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Usuarios</li>
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
							<h5 class="text-blue">Listado de Usuarios</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<button type="button" class="btn btn-info">EXCEL</button>
									<button type="button" class="btn btn-danger">PDF</button>
									<button type="button"
													class="btn btn-success"
													data-toggle="modal"
													data-target="#EmpleadoEditarDatosPersonales"
													data-titulo="<?php echo "AGREGAR NUEVO USUARIO"; ?>"
													data-empmovimiento="1">
													AGREGAR Usuario
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>Usuario</th>
									<th>Apellido y Nombres</th>
									<th>DNI</th>
									<th>Último Acceso</th>
									<th>Tipo Usuario</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							 	foreach($this->model->UsuariosListar() as $row):
									$ultimoacceso = date("d/m/Y H:i:s", strtotime($row->usuario_lastsession));
									//----secretaria----
									//$secdatos = $this->model->SecretariaObtener($secid);
									//----Dependencia----
									//$depdatos = $this->model->DependenciaObtener($depid);
									//---Tipo usuario---
									$usrtipodatos = $this->model->TipoUsuarioObtener($row->usuario_tipo_id);
							 ?>
								<tr>
									<td><?php echo $row->usuario_usuario; ?></td>
									<td><?php echo $row->usuario_apellido.", ".$row->usuario_nombres; ?></td>
									<td class="dt-right"><?php echo $row->usuario_dni; ?></td>
						   		<td data-order="<?php echo $row->usuario_lastsession; ?>" >
				              <?php echo $ultimoacceso; ?>
				          </td>
									<td><?php echo $usrtipodatos->usuario_tipo_nombre; ?></td>

									<td>
										<button type="button"
														class="btn btn-primary"
														data-toggle="modal"
														data-target="#UsuarioEditar"
														data-title="Editar Usuario">
														<i class='icon-copy fi-pencil'></i>
										</button>
											<!-- Boton deshabilitar -->
											<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDeleteUsuario" data-titulo="<?php echo "Borrar Usuario"; ?>" data-paramid="<?php echo $row->usuario_id; ?>"><i class="icon-copy fa fa-trash" aria-hidden="true"></i></button>

										<a  class="btn btn-danger"
												href="?c=login&a=Crud&id=<?php echo $row->usuario_id; ?>&startIndex=0">
												<i class="icon-copy fa fa-trash" aria-hidden="true"></i>
										</a>
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
	<script src="includes/js/usuario.js"></script>
	<!--
	<script src="includes/js/empleado-editar.js"></script>
-->
	<!-- Graficos estadisticos -->
	<!--
	<script src="../../src/plugins/highcharts-6.0.7/code/highcharts.js"></script>
	<script src="../../src/plugins/highcharts-6.0.7/code/highcharts-more.js"></script>
	-->
	<script type="text/javascript">
		$('document').ready(function(){
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					className: "dt-right"
        }],
				/*columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],*/

				/*columnDefs: [{
          targets: 6,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
					},
					{
					targets: 8,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
				}],*/

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
