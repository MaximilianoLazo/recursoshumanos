<?php
  error_reporting(0);
 	session_start();
	if(!isset($_SESSION['usuario_id'])){
		header('Location: ../login/index.php');
	}
  //----sona horario y formato de fechas--------
  date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
  $datetime = new DateTime();
  $fecha_actual = $datetime->format('Y-m-d');
  $fecha_inicio = $datetime->format('Y-01-01');



  $cboleindumentaria = $_POST["CboLEIndumentaria"];

  /*$fechai = "2020-01-01";
  $fechaf = "2020-06-30";*/
  $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFecha($fecha_inicio, $fecha_actual);
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
  <!--
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
  -->
  <link rel="stylesheet" type="text/css" href="../../src/plugins/tabla-car/tabla-car.css">
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
							<h5 class="text-blue">Listados de Entrega de Indumentaria</h5>
						</div>
					</div>


          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="txtindumentarialefeciniciofil" style="font-size: 12px;">Fecha Inicio :</label>
                <input type="date"
                       style="font-size: 12px;"
                       name="txtindumentarialefeciniciofil"
                       id="txtindumentarialefeciniciofil"
                       value="<?php echo $fecha_inicio; ?>"
                       class="form-control"
                       required
                />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="txtindumentarialefecfinalfil" style="font-size: 12px;">Fecha Final :</label>
                <input type="date"
                       style="font-size: 12px;"
                       name="txtindumentarialefecfinalfil"
                       id="txtindumentarialefecfinalfil"
                       value="<?php echo $fecha_actual; ?>"
                       class="form-control"
                       required
                />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
              <label for="cboindumentarialesecretariafil" style="font-size: 12px;">Secretaria :</label>
              <select name="cboindumentarialesecretariafil"
                      style="font-size: 12px;"
                      id="cboindumentarialesecretariafil"
                      class="custom-select form-control"
                      required>
                <option value="0">--Todas--</option>
                <?php foreach($this->model->SecretariasListar() as $row): ?>
                <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
              <label for="cboindumentarialelugartrabajofil" style="font-size: 12px;">Lugar de Trabajo :</label>
              <select name="cboindumentarialelugartrabajofil"
                      style="font-size: 12px;"
                      id="cboindumentarialelugartrabajofil"
                      class="custom-select form-control" required>
                <option value="0">--Todas--</option>
                <?php foreach($this->model->LugaresTrabajoListar() as $row): ?>
                <option value="<?php echo $row->trabajo_id; ?>"><?php echo $row->trabajo_nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="btnindumentarialefil" style="font-size: 12px;"> </label><br>
                <button  type="button"
                         style="width: 100%;"
                         name="btnindumentarialefil"
                         class="btn btn-primary"
                         id="btnindumentarialefil">
                  <i class="fa fa-filter fa-lg" aria-hidden="true"></i>
                  &nbsp;Filtrar
                </button>
            </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class="clearfix">
                <div align="right">
                  <button  type="button"
                           name="btnindumentarialefil"
                           class="btn btn-success"
                           id="btnindumentarialefil">
                    <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i>
                    &nbsp;EXCEL
                  </button>
                  <button  type="button"
                           name="btnindumentarialefilpdf"
                           class="btn btn-danger"
                           id="btnindumentarialefilpdf">
                    <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>
                    &nbsp;PDF
                  </button>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div id="tblcontenidoentregas">
            <div class="row">
              <div class="col-md-12">
              <div id="no-more-tables">
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                  <table border="1" class="table table-striped table-hover table-fixed">
                    <thead>
                      <tr>
                        <th style="font-size: 10px;">FECHA</th>
                        <th style="font-size: 10px;">DNI</th>
                        <th style="font-size: 10px;">APELLIDO Y NOMBRES</th>
                        <th style="font-size: 10px;">ORDEN</th>
                        <th style="font-size: 10px;">CANT.</th>
                        <th style="font-size: 10px;">INDUMENTARIA</th>
                        <th style="font-size: 10px; text-align: center">TALLE</th>
                        <th style="font-size: 10px;">COLOR</th>
                        <th style="font-size: 10px;">OBSERVACION</th>
                        <th style="font-size: 10px;">LUGAR DE TRABAJO</th>
                        <th style="font-size: 10px;">SECRETARIA</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach($indumentariaentdatos as $row):
                          $indumentaria_fec = new DateTime($row->indumentaria_entrega_fecha);
                          $indumentaria_fec_pantalla = $indumentaria_fec->format('d/m/Y');
                      ?>
                      <tr>
                        <td style="font-size: 10px;" data-title="Licencia:">
                          <?php echo $indumentaria_fec_pantalla; ?>
                        </td>
                        <td style="font-size: 10px; text-align: right" data-title="Licencia:">
                          <?php echo $row->legempleado_nrodocto; ?>
                        </td>
                        <td style="font-size: 10px;" data-title="Licencia:">
                          <?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?>
                        </td>
                        <td style="font-size: 10px; text-align: right" data-title="Licencia:">
                          <?php echo $row->indumentaria_orden_id; ?>
                        </td>
                        <td style="font-size: 10px; text-align: right" data-title="Licencia:">
                          <?php echo $row->indumentaria_entrega_cantidad; ?>
                        </td>

                        <td style="font-size: 10px;" data-title="Licencia:">
                          <?php echo $row->indumentaria_nombre; ?>
                        </td>
                        <td style="font-size: 10px; text-align: center;" data-title="Dias:">
                          <?php echo $row->indumentaria_talle_nombre; ?>
                        </td>
                        <td style="font-size: 10px;" data-title="Dias:">
                          <?php echo $row->indumentaria_color_nombre; ?>
                        </td>
                        <td style="font-size: 10px;" data-title="Licencia:">
                          <?php echo $row->indumentaria_entrega_observacion; ?>
                        </td>
                        <td style="font-size: 10px; " data-title="Dias:">
                          <?php echo $row->trabajo_nombre; ?>
                        </td>
                        <td style="font-size: 12px; " data-title="Dias:">
                          <?php echo $row->secretaria_nombre; ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>


            </div>
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
  <!--
	<script src="../../src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../../src/plugins/datatables/media/js/dataTables.bootstrap4.js"></script>
	<script src="../../src/plugins/datatables/media/js/dataTables.responsive.js"></script>
	<script src="../../src/plugins/datatables/media/js/responsive.bootstrap4.js"></script>
-->
	<!-- buttons for Export datatable -->
  <!--
	<script src="../../src/plugins/datatables/media/js/button/dataTables.buttons.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.bootstrap4.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.print.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.html5.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.flash.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/pdfmake.min.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/vfs_fonts.js"></script>
-->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<!-- <script src="../../src/scripts/jquery.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
  <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
	<!--<script src="includes/js/busquedacontrato.js"></script>-->
	<script>
    jQuery(document).ready(function(){
      //--- resultado en vivo de marcaciones ---------
      jQuery("#btnindumentarialefil").click(function(){
        //--------Obtenemos el valor del input
        var indumentarialefecini = jQuery("#txtindumentarialefeciniciofil").val();
        var indumentarialefecfin = jQuery("#txtindumentarialefecfinalfil").val();
        var indumentarialesec = jQuery("#cboindumentarialesecretariafil").val();
        var indumentarialeltrabajo = jQuery("#cboindumentarialelugartrabajofil").val();
        var params = {
          "IndumentariaLEFecIni" : indumentarialefecini,
          "IndumentariaLEFecFin" : indumentarialefecfin,
          "IndumentariaLESec" : indumentarialesec,
          "IndumentariaLELTrabajo" : indumentarialeltrabajo
        };
        //--------llamada al fichero PHP con AJAX
        $.ajax({
          data:  params,
          url:   '?c=indumentaria&a=IndumentariaEntregadaListadosEmpleadosDatos',
          dataType: 'html',
          type:  'post',
          beforeSend: function () {
            //mostramos gif "cargando"
            //jQuery('#loading_spinner').show();
            //antes de enviar la petición al fichero PHP, mostramos mensaje
            jQuery("#tblcontenidoentregas").html("Déjame pensar un poco...");
          },
          success:  function (response) {
            //escondemos gif
            //jQuery('#loading_spinner').hide();
            //mostramos salida del PHP
            jQuery("#tblcontenidoentregas").html(response);
          }
        });
      });
      //------------PDF ----------------------------
      jQuery("#btnindumentarialefilpdf").click(function(){
        //--------Obtenemos el valor del input
        var indumentarialefecini = jQuery("#txtindumentarialefeciniciofil").val();
        var indumentarialefecfin = jQuery("#txtindumentarialefecfinalfil").val();
        var indumentarialesec = jQuery("#cboindumentarialesecretariafil").val();
        var indumentarialeltrabajo = jQuery("#cboindumentarialelugartrabajofil").val();
        var params = {
          "IndumentariaLEFecIni" : indumentarialefecini,
          "IndumentariaLEFecFin" : indumentarialefecfin,
          "IndumentariaLESec" : indumentarialesec,
          "IndumentariaLELTrabajo" : indumentarialeltrabajo
        };
        //--------llamada al fichero PHP con AJAX
        $.ajax({
          cache: false,
          type: 'POST',
          //dataType:"html",
          url: "?c=indumentaria&a=IndumentariaEntregadaListadosEmpleadosPDF",
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
    });
	</script>
</body>
</html>
