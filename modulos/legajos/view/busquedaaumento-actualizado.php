<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
	<link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/contratoactualizacion.php");?>
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
							<h5 class="text-blue">Listado de Contratos Actualizados</h5>
						</div>
					</div>
					<?php

						$nrodoctosact = $_REQUEST['id'];
						//echo var_dump($nrodoctos);
						$nrodoctos = explode(",", $nrodoctosact);
						//echo var_dump($nrodoctos);
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div align="right">

									<button type="button" class="btn btn-danger" id="BtnImprimirContratosC">Imprimir LOTE</button>

								</div>
							</div>
						</div>
					</div>



			<div class="row">
		    <div class="col-md-12">
		      <div id="no-more-tables">
		        <div class="table-wrapper-scroll-y my-custom-scrollbar">
		          <table border="1" class="table table-striped table-hover table-fixed">
								<thead>
									<tr>
										<th>N&deg; Docto</th>
										<th>Apellido y Nombres</th>
										<th>Lugar de Trabajo</th>
										<th>Imputación</th>
										<th>Fec Ingreso</th>
										<th>Fec Inicio</th>
										<th>Fec Final</th>
										<th>Tarea</th>
										<th>S. Basico</th>
										<th width="4%">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($nrodoctos as $nrodocto):
											$contratodatos = $this->model->ObtenerContratosactualizados($nrodocto);
											$contratofecingresodmy = date("d/m/Y", strtotime($contratodatos->legempleado_fecingreso));
											$contratofeciniciodmy = date("d/m/Y", strtotime($contratodatos->legcontrato_fecinicio));
											$contratofecfindmy = date("d/m/Y", strtotime($contratodatos->legcontrato_fecfin));

											$imputacionid = $contratodatos->imputacion_id;
			                $imputaciondatos = $this->model->ObtenerImputacion($imputacionid);
											$sbasiconuevo = number_format($contratodatos->legcontrato_sbasico, 2, ',', '.');
									?>
									<tr>
										<td data-title="DNI:"><?php echo $nrodocto; ?></td>
										<td data-title="Empleado:"><?php echo $contratodatos->legempleado_apellido.", ".$contratodatos->legempleado_nombres; ?></td>
										<td data-title="L. Trabajo:"><?php echo $contratodatos->trabajo_nombre; ?></td>
										<td data-title="Imputación:"><?php echo $imputaciondatos->imputacion_codigow; ?></td>
										<td data-title="Fec Ingreso:"><?php echo $contratofecingresodmy; ?></td>
										<td data-title="Fec Inicio:"><?php echo $contratofeciniciodmy; ?></td>
										<td data-title="Fec Final:"><?php echo $contratofecfindmy; ?></td>
										<td data-title="Tarea:"><?php echo $contratodatos->legcontrato_tarea; ?></td>
										<td align="right" data-title="S. Basico:"><?php echo "$ ".$sbasiconuevo; ?></td>
										<td data-title="Acciones:">
											<button type="button"
															class="btn btn-primary"
															data-toggle="modal"
															data-target="#dataUpdateContrato"
															data-titulo="<?php echo "Alta de Contrato: "; ?>"
															data-empnrodocto="<?php echo $contratodatos->legempleado_nrodocto; ?>"
															data-empid="<?php echo $contratodatos->legempleado_id; ?>"
															data-lcontid="<?php echo $contratodatos->legcontrato_id; ?>"
															data-tlegajo="<?php echo $contratodatos->legtipo_id; ?>"
															data-categoria="<?php echo $contratodatos->legcontrato_categoria; ?>"
															data-fecinicio="<?php echo $contratodatos->legcontrato_fecinicio; ?>"
															data-fecfinalizacion="<?php echo $contratodatos->legcontrato_fecfin; ?>"
															data-contratosec="<?php echo $contratodatos->secretaria_id; ?>"
															data-contimputacion="<?php echo $contratodatos->imputacion_id; ?>"
															data-contactividad="<?php echo $contratodatos->impdependencia_id; ?>"
															data-imputacion="<?php echo $contratodatos->imputacion_id."-".$contratodatos->impdependencia_id; ?>"
															data-secretaria="<?php echo $contratodatos->secretaria_id."-".$contratodatos->trabajo_id; ?>"
															data-conttarea="<?php echo $contratodatos->legcontrato_tarea; ?>"
															data-contltrabajo="<?php echo $contratodatos->trabajo_id; ?>"
															data-contsbasico="<?php echo $contratodatos->legcontrato_sbasico; ?>"
															data-nrosdocto="<?php echo $nrodoctosact; ?>">Editar
											</button>
										</td>
									</tr>
									<?php
										endforeach;
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
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
	<!-- <script src="../../src/scripts/jquery.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
	<script src="includes/js/contrato.js"></script>
	<script>
		$('document').ready(function(){
			jQuery("#BtnImprimirContratosC").click(function(){
	      //--------Obtenemos el valor del input
	      //var nrodnis = jQuery('input:checkbox:checked').val();
				/*
	      var nrodnis = [];
	      console.log($("input[name='checkbox[]']"));
	      $("input[name='checkbox[]']:checked").each(function(){
	        console.log($(this).val());
	        nrodnis .push($(this).val());
	      });
				*/
				var nrodnis = <?php echo json_encode($nrodoctos); ?>
	      //var nrodnis = jQuery("#checkbox").val();
	      //var historicodi = jQuery("#mbusquedahistoricodi").val();
	      //var historicodf = jQuery("#mbusquedahistoricodf").val();
	      var params = {
	        "NroDnis" : nrodnis,
	      };
	      //--------llamada al fichero PHP con AJAX
	      $.ajax({
	        cache: false,
	        type: 'POST',
	        //dataType:"html",
	        url: 'includes/pdf/contrato-general.php',
	        //contentType: false,
	        //processData: false,
	        data: params,
	        //xhrFields is what did the trick to read the blob to pdf
	        xhrFields:{
	          responseType: 'blob'
	        },
	        success: function (response, status, xhr){
	          var filename = "";
	          var disposition = xhr.getResponseHeader('Content-Disposition');

	          if(disposition){
	            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
	            var matches = filenameRegex.exec(disposition);
	            if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
	          }
	          var linkelem = document.createElement('a');
	          try{
	            var blob = new Blob([response], { type: 'application/octet-stream' });

	            if(typeof window.navigator.msSaveBlob !== 'undefined'){
	              //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were creaThese URLs will no longer resolve as the data backing the URL has been freed."
	              window.navigator.msSaveBlob(blob, filename);
	            }else{
	              var URL = window.URL || window.webkitURL;
	              var downloadUrl = URL.createObjectURL(blob);

	              if (filename){
	                // use HTML5 a[download] attribute to specify filename
	                var a = document.createElement("a");

	                // safari doesn't support this yet
	                if(typeof a.download === 'undefined'){
	                  window.location = downloadUrl;
	                }else{
	                  a.href = downloadUrl;
	                  a.download = filename;
	                  document.body.appendChild(a);
	                  a.target = "_blank";
	                  a.click();
	                }
	              }else{
	                window.location = downloadUrl;
	              }
	            }

	          }catch(ex){
	            console.log(ex);
	          }
	        }
	      });
	    });
				//load(1);
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
	</script>
</body>
</html>
