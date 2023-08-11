<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['usuario_id'])) {
	header('Location: ../login/index.php');
}
$ndocconsultado = $_GET["id"];
// Esto evaluará a TRUE así que el texto se imprimirá.
if (isset($_GET["id"])) {
	//echo "Esta variable está definida, así que se imprimirá";
	$valorimput = $ndocconsultado;
} else {
	$valorimput = null;
}

?>
<!DOCTYPE html>
<html>

<head>
	<?php include('../../includes/head.php'); ?>
	<?php //include("../view/recibos-respuesta.php");
	?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
	<link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
	<link rel="stylesheet" type="text/css" href="includes/css/bd-callout.css">
	<link rel="stylesheet" type="text/css" href="includes/css/fieldset.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-steps/build/jquery.steps.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa1.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa2.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa3.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa4.css">
</head>

<body>

	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!--**********ventanas modal***********-->
	<?php include("includes/mdl/recibo-xmes.php"); ?>
	<?php //include("includes/mdl/licenciaanualordinaria-eliminar.php");
	?>
	<?php //include("includes/mdl/licenciaanualordinaria-info.php");
	?>
	<?php //include("includes/mdl/licenciaanualordinaria-agregar.php");
	?>
	<?php //include("includes/mdl/licenciaanualordinaria-cortar.php");
	?>

	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Listado de Recibos</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item" aria-current="page">Listado de Recibos</li>
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
							<h5 class="text-blue">Listado de Recibos</h5>
						</div>
					</div>
					<?php
					date_default_timezone_set("America/Buenos_Aires");
					$fecha_actual = date("Y-m-d");
					$hora_actual = date("H:i:s");
					$fecha_inicio = date("Y-01-01");
					?>
					<div class="row">
						<div class="col-md-4">
							<label for="cboperiodo" class="control-label">Seleccionar periodo:</label>
							<select name="cboperiodo" id="cboperiodo" class="custom-select form-control" required>
								<option value="">--Seleccione--</option>
								<?php foreach ($this->model->PeriodosTodosObtener() as $row) :
								?>
									<option value="<?php echo $row->periodo_id;
													?>"><?php echo $row->periodo_nombre;
														?></option>
								<?php endforeach;
								?>
							</select>
							
						</div>
						

					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<button type="button" class="btn btn-danger" id="BtnImprimirRecibos">Descargar</button>
							
								
							</div>
						</div>
					</div>

					<!-- <div class="row" id="tabladato">
						<div id="tabladatostres">

						</div>
					</div> -->

				</div>
				<?php include('../../includes/footer.php'); ?>
			</div>
		</div>
		<?php include('../../includes/script.php'); ?>
		<script src="includes/js/liquidacion.js"></script>
		<script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">

		<script>
  	jQuery(document).ready(function() {
    jQuery("#BtnImprimirRecibos").click(function() {
      //


      var turnoid = $("#cboperiodo").val();

      //--------llamada al fichero PHP con AJAX
      $.ajax({
        cache: false,
        type: 'POST',
        //dataType:"html",
        url: '?c=liquidacion&a=ImprimirLoteRecibos',
        //contentType: false,
        //processData: false,
        data: {
          val: turnoid
        },
        //xhrFields is what did the trick to read the blob to pdf
        xhrFields: {
          responseType: 'blob'
        },
        success: function(response, status, xhr) {
          var filename = "";
          var disposition = xhr.getResponseHeader('Content-Disposition');

          if (disposition) {
            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
            var matches = filenameRegex.exec(disposition);
            if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
          }
          var linkelem = document.createElement('a');
          try {
            var blob = new Blob([response], {
              type: 'application/octet-stream'
            });

            if (typeof window.navigator.msSaveBlob !== 'undefined') {
              //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were creaThese URLs will no longer resolve as the data backing the URL has been freed."
              window.navigator.msSaveBlob(blob, filename);
            } else {
              var URL = window.URL || window.webkitURL;
              var downloadUrl = URL.createObjectURL(blob);

              if (filename) {
                // use HTML5 a[download] attribute to specify filename
                var a = document.createElement("a");

                // safari doesn't support this yet
                if (typeof a.download === 'undefined') {
                  window.location = downloadUrl;
                } else {
                  a.href = downloadUrl;
                  a.download = filename;
                  document.body.appendChild(a);
                  a.target = "_blank";
                  a.click();
                }
              } else {
                window.location = downloadUrl;
              }
            }

          } catch (ex) {
            console.log(ex);
          }
        }
      });
    });

  });
</script>
</body>

</html>