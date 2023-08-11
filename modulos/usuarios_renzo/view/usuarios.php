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
	<?php include("includes/mdl/usuario-editar.php");	?>
	<?php include("includes/mdl/usuario-baja.php");	?>
	<?php include("includes/mdl/usuario-habilitar.php"); ?>
	<?php include("includes/mdl/usuario-clave-resetear.php"); ?>
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
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-end">
							<!--<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>-->

						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<!--<div class="pull-left">
							<h5 class="text-blue">Bienvenidos al nuevo Sistema de Expedientes!!!</h5>
              <h5 class="text-blue"><?php //echo $_SESSION['usuario_tipo_id'];
																		?></h5>

						</div>-->
					</div>
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Listado de Usuarios</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 text-end">
							<!--<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ClienteEXCEL" data-titulo="<?php echo "Listado en Excel"; ?>">
								<i class="ion-archive"></i>
								Excel
							</button>-->
							<!--<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ClientePDF" data-titulo="<?php echo "Listado en PDF"; ?>">
								<i class="fa-1x ion-archive"></i>
								PDF
							</button>-->
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UsuarioEditar" data-titulo="<?php echo "Nuevo Usuario"; ?>">
								<!--<i class="fa fa-user-o" aria-hidden="true"></i>-->
								<i class="icon-copy fa fa-user-circle" aria-hidden="true"></i>
								Agregar Usuario
							</button>
						</div>
					</div>
					<br>
					<div class="row">
						<table border="1" class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<!--<th class="table-plus datatable-nosort" width="8%">#- - - - - -</th>-->
									<th>DNI</th>
									<th>Usuario</th>

									<th>Tipo de Usuario</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($this->model->UsuariosListar() as $row) :
									$tipousu = $this->model->UsuarioTipoObtener($row->usuario_tipo_id);
								?>
									<tr>
										<td><?php echo $row->usuario_usuario;	?></td>
										<td><?php echo $row->usuario_apellido.", ".$row->usuario_nombres; ?></td>
										<td><?php echo $tipousu->usuario_tipo_nombre; ?></td>

										<td class="dt-right">

											<button type="button"
														class="btn btn-warning"
														data-bs-toggle="modal"
														data-bs-target="#UsuarioClaveRes"
														data-titulo="<?php echo "Resetear Clave"; ?>"
														data-usridres="<?php echo $row->usuario_id; ?>"
														data-usuariores="<?php echo $row->usuario_usuario; ?>">
														<i class="icon-copy ion-android-unlock"></i>
											</button>

											<button type="button"
															class="btn btn-primary"
															data-bs-toggle="modal"
															data-bs-target="#UsuarioEditar"
															data-titulo="<?php echo "Editar Usuario"; ?>"
															data-usrid="<?php echo $row->usuario_id; ?>"
															data-usr="<?php echo $row->usuario_usuario; ?>"
															data-usrtipo="<?php echo $row->usuario_tipo_id; ?>">
												<i class="icon-copy fa fa-pencil-square-o" aria-hidden="true"></i>
											</button>
											<!--Boton Eliminar-->
											<?php
											if($row->usuario_estado == 1){
												//---activo
												?>
												<button type="button"
															class="btn btn-danger"
															data-bs-toggle="modal"
															data-bs-target="#UsuarioBaja"
															data-titulo="<?php echo "Deshabilitar Usuario"; ?>"
															data-usridbaja="<?php echo $row->usuario_id; ?>">
															<i class="fa fa-arrow-down" aria-hidden="true"></i>
												</button>
												<?php
											}elseif($row->usuario_estado == 0){
												//---inactivo
												?>
												<button type="button"
															class="btn btn-success"
															data-bs-toggle="modal"
															data-bs-target="#UsuarioHab"
															data-titulo="<?php echo "Habilitar Usuario"; ?>"
															data-usridhab="<?php echo $row->usuario_id; ?>">
															<i class="fa fa-arrow-up" aria-hidden="true"></i>
												</button>
												<?php
											}else{
												//---error
											}
											?>
										</td>
									</tr>

								<?php
								endforeach;
								?>
							</tbody>
						</table>
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
		<script src="includes/js/usuarios.js"></script>
		<script type="text/javascript">
			$('document').ready(function() {
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

					/*columnDefs: [{
							targets: 6,
							render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss', 'DD/MM/YYYY HH:mm:ss')
						}
					],*/

					"lengthMenu": [
						[10, 25, 50, -1],
						[10, 25, 50, "All"]
					],
					"language": {
						"sProcessing": "Procesando...",
						"sLengthMenu": "Mostrar _MENU_ registros",
						"sZeroRecords": "No se encontraron resultados",
						"sEmptyTable": "Ningún dato disponible en esta tabla",
						"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix": "",
						"sSearch": "Buscar:",
						"sUrl": "",
						"sInfoThousands": ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst": "<<",
							"sLast": ">>",
							"sNext": ">",
							"sPrevious": "<"
						},
						"oAria": {
							"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
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
