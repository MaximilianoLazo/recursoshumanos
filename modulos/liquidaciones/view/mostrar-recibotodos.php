<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<?php $jub=$_REQUEST['id'];

	  $jubilado_datos = $this->model->JubiladoObtenerLeg($jub); ?>
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

	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Liquidación</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Liquidación Provisoria</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<?php $periodomax = $this->model->CJMDGPeriodoObtener(); ?>
							<h5 class="text-blue">Liquidación Provisoria Jubilado: <?php echo $jub .'-'. $jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres?> - Periodo: <?php echo substr($periodomax->periodo_presentismo_f,5,2) .'/'.substr($periodomax->periodo_presentismo_f,0,4); ?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">
									<?php $recibosdatos = $this->model->ListarSueldos($periodomax->periodo_id,$jub) ;
								  	$cantidadrecibos=count($recibosdatos);
									echo 'periodo'.$periodomax->periodo_id;
									echo 'legajo'.$jub;
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th>ID</th>
									<th>DATO</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if($cantidadrecibos!=0){		?>
										<?php $i=0; $c=0;
										foreach($recibosdatos as $row):  		
													if($i<>$row->legajo_id){ ?>
														<tr>
															<th align="right"><?php if($c!=0){echo "TOTAL"; }?></th>
															<th><?php if($c!=0){echo $c;} ?></th>
														</tr>
													<tr>
														<th><?php //echo $row->legajo_apellido.",".$row->legajo_nombres; ?></th>
													</tr>
													<tr>
														<td><?php echo $row->cjmdg_detsueldo_detconcep; ?></td>
														<td><?php echo $row->cjmdg_detsueldo_importe; $c=0;$c=$c+$row->cjmdg_detsueldo_importe; ?></td>
														<td></td>
													</tr>
												<?php }else{ ?>
												<tr>
													<td><?php echo $row->cjmdg_detsueldo_detconcep; ?></td>
													<td><?php echo $row->cjmdg_detsueldo_importe; $c=$c+$row->cjmdg_detsueldo_importe;  ?></td>
												</tr>
										<?php } $i=$row->legajo_id; endforeach; ?>

								 <?php } ?>
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
	<!-- FORMULARIO DE IMPORTACION DE ARCHIVOS -->
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-custon-file-input/demo.css" />
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-custon-file-input/component.css" />
	<script src="../../src/plugins/jquery-custon-file-input/jquery.custom-file-input.js"></script>
	<!-- script propio de formulario -->
	<script src="includes/js/liquidacion.js"></script>
	<script src="../../src/plugins/jquery-steps/build/jquery.steps.js"></script>

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
				"order": [[0, "asc"]],
			/*columnDefs: [{
          targets: 6,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY')
				},
					{
					targets: 2,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'),
				},
			],*/

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

	<script>

			$(".tab-wizard").steps({
				headerTag: "h5",
				bodyTag: "section",
				transitionEffect: "fade",
				//saveState: true,
				enableAllSteps: true,
				startIndex: <?php echo $_REQUEST['seccion']; ?>,
				titleTemplate: '<span class="step">#index#</span> #title#',
				labels: {
					current: "current step:",
        	pagination: "Pagination",
        	finish: "Ir a Listado",
        	next: "Siguiente",
        	previous: "Anterior",
        	loading: "Loading ..."
				},
				/*
				onStepChanging: function (event, currentIndex, newIndex){

					var form = $(this);
        	form.validate().settings.ignore = ":disabled,:hidden";

        	return form.valid();


    		},
				*/
				/*
    		onFinishing: function (event, currentIndex){
        	form.validate().settings.ignore = ":disabled";
        	return form.valid();
    		},
				*/
				onFinished: function (event, currentIndex){
					var form = $(this);
          form.submit();
				}
			});
	</script>
</body>
</html>
