<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php');
   $exp_tipo_motivo = $this->model->MotivosTipoListar();
   $exp_motivoc = count($exp_tipo_motivo);
   ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/alta-tipo-motivo.php");?>
	<?php include("includes/mdl/modi-tipo-motivo.php");?>
	<?php include("includes/mdl/borrar-tipo-motivo.php");?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Tipos de Motivo</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Tipo de Motivo</li>
							</ol>
							</nav>
						</div>

					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Tipos de Motivo</h5>
						</div>
					</div>
          <div class="row">
            <div class="col-md-12">
              <div class="align:right">
								<?php
									$url_dato = explode("=", $_SERVER['HTTP_REFERER']);
								 	$url_anterior = end($url_dato);
									//echo $_GET["id"]."<br>";
									//echo $url_anterior."<br>";

									//if($_GET["id"] > 0){
										?>
									<!--	<a href="?c=expediente&a=ExpedienteBuscar&id=<?php //echo $_GET["id"]; ?>&tab=3"
											 class="btn btn-primary">
											 <i class="fa fa-history"></i>
		                   Volver a Expediente
		                </a> !-->
										<?php
									//}
								?>
                <a href="#"
                   class="btn btn-success"
                   data-toggle="modal"
                   data-target="#AltaTipoMotivo"
                   data-titulo="<?php echo "Nuevo Tipo Motivo" ; ?>"
									 data-expidtar="<?php //echo $_GET["id"]; ?>">
                   <i class="ion-android-add-circle" style="font-weight: bold;"></i>
                   Nuevo Tipo Motivo
                </a>

              </div>
              <br>
            </div>
          </div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>Tipo Motivo</th>
									<th>Motivo</th>
									<th>Destino</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($exp_tipo_motivo as $value): ?>
              	<tr>
									<td><?php echo $value->expediente_tipo_nombre; ?></td>
                  <td><?php echo $value->expediente_motivo_nombre; ?></td>
									<td><?php echo $value->destino_nombre; ?></td>
	                <td class="dt-right">
		                 <a href="#"
										    class="btn btn-primary"
		                    data-toggle="modal"
		                    data-target="#ModiTipoMotivo"
		                    data-titulo="<?php echo "Modificar Tipo Motivo" ; ?>"
												data-expmotivoid="<?php echo $value->expediente_motivo_id; ?>"
												data-expmotivodesc="<?php echo $value->expediente_motivo_nombre; ?>"
												data-exptipoid="<?php echo $value->expediente_tipo_id; ?>"
												data-exptiposec="<?php echo $value->destino_id; ?>">
		                    <i class='icon-copy fi-pencil'></i>
		                 </a>

										 <a href="#"
												class="btn btn-danger"
												data-toggle="modal"
												data-target="#BorraTipoMotivo"
												data-titulo="<?php echo "Borrar tipo de motivo?" ; ?>"
												data-expmotivoid="<?php echo $value->expediente_motivo_id; ?>">
												<i class="fa fa-trash" aria-hidden="true"></i>
										 </a>
                  </td>
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
	<script src="includes/js/expediente.js"></script>

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
