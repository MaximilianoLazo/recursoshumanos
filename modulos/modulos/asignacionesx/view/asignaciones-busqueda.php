<?php
  //error_reporting(0);
 	session_start();
	if(!isset($_SESSION['usuario_id'])){
		header('Location: ../login/index.php');
	}
  $ndocconsultado = $_GET["id"];
  // Esto evaluará a TRUE así que el texto se imprimirá.
  if(isset($_GET["id"])){
    //echo "Esta variable está definida, así que se imprimirá";
    $valorimput = $ndocconsultado;
  }else{
    $valorimput = null;
  }

?>
<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
  <link rel="stylesheet" type="text/css" href="includes/css/tablaadaptativa.css">
  <link rel="stylesheet" type="text/css" href="includes/css/tablaadaptativa-obbeneficiario.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
  <?php include("includes/mdl/busquedaobreajustemodificar.php");?>
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
							<h5 class="text-blue">Actualizacion de Contratos</h5>
						</div>
					</div>
					<div class="row">
	          <div class="col-xs-3 col-sm-3">
	            <div class="form-group">
	              <label for="txtnrodoctoempben" class="control-label">Nro Docto de Empleado o Beneficiario: </label>
	              <input type="number" name="txtnrodoctoempben" id="txtnrodoctoempben" value="<?php echo $valorimput; ?>" class="form-control" required>
	            </div>
	          </div>
	        </div>
  				<div class="row">
  						<div class="col-md-3">
  							<div class="form-group">
  								<button type="button" class="btn btn-primary" id="btneviarempben">Buscar</button>
  							</div>
  						</div>
  				</div>
  				<div class="row table-responsive">
  						<div class="col-md-12" id="tabladato">

  						</div>
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
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<!-- <script src="../../src/scripts/jquery.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
	<script src="includes/js/busquedacontrato.js"></script>
  <script src="includes/js/busquedaobreajuste.js"></script>
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
		jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#btneviarempben").click(function(){
				//--------Obtenemos el valor del input
				var nrodoctoempben = jQuery("#txtnrodoctoempben").val();


				var rdoorden = [];
	      console.log($("input[name='RdoOrden']"));
	      $("input[name='RdoOrden']:checked").each(function(){
	        console.log($(this).val());
	        rdoorden .push($(this).val());
	      });
				var params = {
					"NroDoctoEmpBen" : nrodoctoempben
					//"CboLugarDeTrabajo" : cbolugardetrabajo,
					//"RdoOrden" : rdoorden,
          //"CboFecIngreso" : cbofecingreso,
          //"CboNuevaFecInicio" : cbonuevafecinicio,
          //"CboNuevaFecFin" : cbonuevafecfin,
          //"CboActualizacion" : cboactualizacion
          //"RdoApellidoYNombres" : rdoapellidoynombres,
					//"RdoNroDocumento" : rdonrodocumento
				};
				//--------llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					url:   'view/asignaciones-busqueda-respuesta.php',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tabladato").html("Déjame pensar un poco...");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tabladato").html(response);
					}
				});
			});
      //var node = document.getElementById('txtnrodoctoempben');
      var node = jQuery("#txtnrodoctoempben").val();

      //if(node === null){
      if(node == ""){ //true

      }else{
        //--- resultado en vivo de marcaciones ---------
  			jQuery(document).ready(function(){
  				//--------Obtenemos el valor del input
  				var nrodoctoempben = jQuery("#txtnrodoctoempben").val();


  				var rdoorden = [];
  	      console.log($("input[name='RdoOrden']"));
  	      $("input[name='RdoOrden']:checked").each(function(){
  	        console.log($(this).val());
  	        rdoorden .push($(this).val());
  	      });
  				var params = {
  					"NroDoctoEmpBen" : nrodoctoempben
  					//"CboLugarDeTrabajo" : cbolugardetrabajo,
  					//"RdoOrden" : rdoorden,
            //"CboFecIngreso" : cbofecingreso,
            //"CboNuevaFecInicio" : cbonuevafecinicio,
            //"CboNuevaFecFin" : cbonuevafecfin,
            //"CboActualizacion" : cboactualizacion
            //"RdoApellidoYNombres" : rdoapellidoynombres,
  					//"RdoNroDocumento" : rdonrodocumento
  				};
  				//--------llamada al fichero PHP con AJAX
  				$.ajax({
  					data:  params,
  					url:   'view/busquedaobreajuste-respuesta.php',
  					dataType: 'html',
  					type:  'post',
  					beforeSend: function () {
  						//mostramos gif "cargando"
  						//jQuery('#loading_spinner').show();
  						//antes de enviar la petición al fichero PHP, mostramos mensaje
  						jQuery("#tabladato").html("Déjame pensar un poco...");
  					},
  					success:  function (response) {
  						//escondemos gif
  						//jQuery('#loading_spinner').hide();
  						//mostramos salida del PHP
  						jQuery("#tabladato").html(response);
  					}
  				});
  			});
      }

		});
	</script>
</body>
</html>
