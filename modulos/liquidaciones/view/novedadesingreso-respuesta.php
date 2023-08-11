<?php

  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    //header('Location: ../login/index.php');
    //echo '<meta http-equiv="refresh" content="0;URL=ordenmensajealta.php?id='.$numeroorden.'">';
    echo '<meta http-equiv="refresh" content="0;URL=../login/index.php">';
  }
  
  $nrodocto=$_GET['id'];

	//$jub=5081;
  $jubilado_datos = $this->model->JubiladoObtenerLeg($nrodocto);

  
  //$licenciatipo = $_POST["LicenciaTipo"];
  //$fechainicio = $_POST["FechaI"];
  //$fechafinal = $_POST["FechaF"];

  date_default_timezone_set("America/Buenos_Aires");
  $fecha_actual = date("Y-m-d");
  $hora_actual = date("H:i:s");
  $fecha_inicio = date("Y-01-01");
  //$empleadodatosresumidos = $licencia->ObtenerEmpleadoDatosRes($nrodocto);
  //$fechaingresofecdmy = date("d/m/Y", strtotime($empleadodatosresumidos->legempleado_fecingreso));
  //$datoultimafeclic = $licencia->ObtenerUltimaFecLicEmp($nrodocto);
  //$fecha_licenciau = $datoultimafeclic->lproceso_fecha;
  $licenciaid = "T";
?>

<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
	<link rel="stylesheet" type="text/css" href="includes/css/tablaresp-correoargentino.css">
	<link rel="stylesheet" type="text/css" href="includes/css/bd-callout.css">
	<link rel="stylesheet" type="text/css" href="includes/css/fieldset.css">
</head>
<div class="row">
<div class="col-md-12">
  <div class="row">
    <div class="col-md-3">
      <div class="bd-callout bd-callout-primary">
        <h5 id="asynchronous-methods-and-transitions">
          <?php echo "Empleado: "; ?>
        </h5>
        <p class="text-success">
          <?php echo $jubilado_datos->legajo_apellido.", ".$jubilado_datos->legajo_nombres; ?>
        </p>
      </div>
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
      <div class="bd-callout bd-callout-primary">
        <h5 id="asynchronous-methods-and-transitions">
          <?php echo "Acciones: "; ?>
        </h5>
        <button type="button"
                class="btn btn-danger"
                data-toggle="modal"
                data-target="#dataDeleteNovedades"
                data-titulo="<?php echo "Listado de Novedades"; ?>"
                data-empnrodocto="<?php echo $nrodocto; ?>"
                data-fecini="<?php echo $fecha_actual; ?>"
                data-fecfin="<?php echo $fecha_licenciau; ?>">Eliminar Novedad
        </button>
      </div>
    </div>
  </div>
</div>

<div class="col-md-4">
  <fieldset>
    <legend>Datos de Licencia:</legend>
    <div class="row" >
	     <div class="col-md-12">
        <div class="form-group">
          <label for="cbonovedadtipo" class="control-label">Seleccione Tipo de Novedad:</label>
          <select name="cbonovedadtipo" style="font-size: 12px;" id="cbonovedadtipo" class="custom-select form-control" required>
            <option value="">-- SELECCIONE --</option>
             <?php foreach($this->model->ListarNovedades() as $row): ?>
              <option value="<?php echo $row->liqcod_id; ?>"><?php echo $row->liqcod_nombre; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="txtlicenciadesde">Desde :</label>
          <input type="date" style="font-size: 12px;" name="txtlicenciadesde" id="txtlicenciadesde" value="<?php echo $fecha_actual; ?>" class="form-control" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="txtlicenciahasta">Hasta :</label>
          <input type="date" style="font-size: 12px;" name="txtlicenciahasta" id="txtlicenciahasta" value="<?php echo $fecha_actual; ?>" class="form-control" required>
        </div>
      </div>
    </div>
    <div class="row" id="tabladatodos">

    </div>
  </fieldset>
</div>

<div class="col-md-8">
  <fieldset>
    <legend>Filtros de Busqueda:</legend>
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <label for="cbolicenciatipobus">Licencias :</label>
            <select name="cbolicenciatipobus" style="font-size: 12px;" id="cbolicenciatipobus" class="custom-select form-control" required>
              <option value="T">Todas --></option>
              <?php //foreach($licencia->ListarLicencias() as $row): ?>
              <option value="<?php //echo $row->licencia_id; ?>"><?php //echo $row->licencia_nombre; ?></option>
              <?php //endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="mbusquedahistoricodi">Fecha Inicio :</label>
              <input type="date" style="font-size: 11.5px;" name="mbusquedahistoricodi" id="mbusquedahistoricodi" value="<?php echo $fecha_inicio; ?>" class="form-control" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="mbusquedahistoricodf">Fecha Fin :</label>
              <input type="date" style="font-size: 11.5px;" name="mbusquedahistoricodf" id="mbusquedahistoricodf" value="<?php //echo $datoultimafeclic->lproceso_fecha; ?>" class="form-control" required>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="tabladatotres">
      <div class="row">
        <div class="col-md-6">
          <div id="no-more-tables">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table class="table table-striped table-hover table-fixed">
                <thead>
                  <tr>
                    <th style="font-size: 12px;">Licencia</th>
                    <th style="font-size: 12px; text-align: right;">Dias</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    date_default_timezone_set("America/Buenos_Aires");
                    $fecha_actual = date("Y-m-d");
                    $hora_actual = date("H:i:s");
                    $fecha_inicio = date("Y-01-01");

                    //foreach($licencia->ObtenerLicenciasAgrupadas($licenciaid, $nrodocto, $fecha_inicio, $fecha_licenciau) as $row):
                  ?>
                  <tr>
                    <td style="font-size: 12px;" data-title="Licencia:"><?php //echo $row->licencia_nombre; ?></td>
                    <td style="font-size: 12px; text-align: right;" data-title="Dias:"><?php //echo $row->licenciasac; ?></td>
                  </tr>
                  <?php //endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div id="no-more-tables">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table width="100%" class="table table-striped table-hover table-striped">
                <thead>
                  <tr>
                    <th width="15%" style="font-size: 12px;">Fecha</th>
                    <th width="85%" style="font-size: 12px;">Licencia</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  //foreach($licencia->ObtenerLicencias($licenciaid, $nrodocto, $fecha_inicio, $fecha_licenciau) as $row):
                  //$lprocesofecdmy = date("d/m/Y", strtotime($row->lproceso_fecha));
                  ?>
                  <tr>
                    <td style="font-size: 12px;" data-title="Fecha:"><?php //echo $lprocesofecdmy; ?></td>
                    <td style="font-size: 12px;" data-title="Licencia:"><?php //echo $row->licencia_nombre; ?></td>
                  </tr>
                  <?php //endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
</div>
</div>
<?php include('../../includes/script.php'); ?>
	<script src="includes/js/liquidacion.js"></script>
	<script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">

<script>
  jQuery(document).ready(function(){
    //--- resultado en vivo de marcaciones ---------
    jQuery("#cbonovedadtipo").change(function(){
      //cogemos el valor del input
      var nrodocto = <?php echo $_GET['id']; ?>;
      var licenciaid = jQuery("#cbonovedadtipo").val();
      var fechai = jQuery("#txtlicenciadesde").val();
      var fechaf = jQuery("#txtlicenciahasta").val();

      var params = {
        /*"NroDocto" : nrodocto,
        "LicenciaTipo" : licenciatipo,*/
        "NroDocto" : nrodocto,
        "LicenciaId" : licenciaid,
        "FechaI" : fechai,
        "FechaF" : fechaf
      };

      //llamada al fichero PHP con AJAX
      $.ajax({
        data:  params,
        url:   'includes/php/autocompletar_licenciadia.php',
        dataType: 'html',
        type:  'post',
        beforeSend: function () {
          //mostramos gif "cargando"
          //jQuery('#loading_spinner').show();
          //antes de enviar la petición al fichero PHP, mostramos mensaje
          jQuery("#tabladatodos").html("Déjame pensar un poco...");
        },
        success:  function (response) {
          jQuery("#tabladatodos").html(response);
        }
      });
    });
    jQuery("#txtlicenciadesde").change(function(){
      //cogemos el valor del input
      var nrodocto = <?php echo $_GET['id']; ?>;
      var licenciaid = jQuery("#cbonovedadtipo").val();
      var fechai = jQuery("#txtlicenciadesde").val();
      var fechaf = jQuery("#txtlicenciahasta").val();

      var params = {
        /*"NroDocto" : nrodocto,
        "LicenciaTipo" : licenciatipo,*/
        "NroDocto" : nrodocto,
        "LicenciaId" : licenciaid,
        "FechaI" : fechai,
        "FechaF" : fechaf
      };

      //llamada al fichero PHP con AJAX
      $.ajax({
        data:  params,
        url:   'includes/php/autocompletar_licenciadia.php',
        dataType: 'html',
        type:  'post',
        beforeSend: function () {
          //mostramos gif "cargando"
          //jQuery('#loading_spinner').show();
          //antes de enviar la petición al fichero PHP, mostramos mensaje
          jQuery("#tabladatodos").html("Déjame pensar un poco...");
        },
        success:  function (response) {
          jQuery("#tabladatodos").html(response);
        }
      });
    });
    jQuery("#txtlicenciahasta").change(function(){
      //cogemos el valor del input
      var nrodocto = <?php echo $_GET["id"]; ?>;
      var licenciaid = jQuery("#cbonovedadatipo").val();
      var fechai = jQuery("#txtlicenciadesde").val();
      var fechaf = jQuery("#txtlicenciahasta").val();

      var params = {
        /*"NroDocto" : nrodocto,
        "LicenciaTipo" : licenciatipo,*/
        "NroDocto" : nrodocto,
        "LicenciaId" : licenciaid,
        "FechaI" : fechai,
        "FechaF" : fechaf
      };

      //llamada al fichero PHP con AJAX
      $.ajax({
        data:  params,
        url:   'includes/php/autocompletar_licenciadia.php',
        dataType: 'html',
        type:  'post',
        beforeSend: function () {
          //mostramos gif "cargando"
          //jQuery('#loading_spinner').show();
          //antes de enviar la petición al fichero PHP, mostramos mensaje
          jQuery("#tabladatodos").html("Déjame pensar un poco...");
        },
        success:  function (response) {
          jQuery("#tabladatodos").html(response);
        }
      });
    });
    jQuery("#cbolicenciatipobus").change(function(){
      //cogemos el valor del input
      var licenciaid = jQuery("#cbolicenciatipobus").val();
      var fechai = jQuery("#mbusquedahistoricodi").val();
      var fechaf = jQuery("#mbusquedahistoricodf").val();
      var nrodocto = <?php echo $nrodocto; ?>;

      var params = {
        "LicenciaId" : licenciaid,
        "NroDocto" : nrodocto,
        "FechaI" : fechai,
        "FechaF" : fechaf
      };

      //llamada al fichero PHP con AJAX
      $.ajax({
        data:  params,
        url:   'includes/php/busqueda_licencia.php',
        dataType: 'html',
        type:  'post',
        beforeSend: function () {
          //mostramos gif "cargando"
          //jQuery('#loading_spinner').show();
          //antes de enviar la petición al fichero PHP, mostramos mensaje
          jQuery("#tabladatotres").html("Déjame pensar un poco...");
        },
        success:  function (response) {
          jQuery("#tabladatotres").html(response);
        }
      });
    });
    jQuery("#mbusquedahistoricodi").change(function(){
      //cogemos el valor del input
      var licenciaid = jQuery("#cbolicenciatipobus").val();
      var fechai = jQuery("#mbusquedahistoricodi").val();
      var fechaf = jQuery("#mbusquedahistoricodf").val();
      var nrodocto = <?php echo $nrodocto; ?>;

      var params = {
        "LicenciaId" : licenciaid,
        "NroDocto" : nrodocto,
        "FechaI" : fechai,
        "FechaF" : fechaf
      };

      //llamada al fichero PHP con AJAX
      $.ajax({
        data:  params,
        url:   'includes/php/busqueda_licencia.php',
        dataType: 'html',
        type:  'post',
        beforeSend: function () {
          //mostramos gif "cargando"
          //jQuery('#loading_spinner').show();
          //antes de enviar la petición al fichero PHP, mostramos mensaje
          jQuery("#tabladatotres").html("Déjame pensar un poco...");
        },
        success:  function (response) {
          jQuery("#tabladatotres").html(response);
        }
      });
    });
    jQuery("#mbusquedahistoricodf").change(function(){
      //cogemos el valor del input
      var licenciaid = jQuery("#cbolicenciatipobus").val();
      var fechai = jQuery("#mbusquedahistoricodi").val();
      var fechaf = jQuery("#mbusquedahistoricodf").val();
      var nrodocto = <?php echo $nrodocto; ?>;

      var params = {
        "LicenciaId" : licenciaid,
        "NroDocto" : nrodocto,
        "FechaI" : fechai,
        "FechaF" : fechaf
      };

      //llamada al fichero PHP con AJAX
      $.ajax({
        data:  params,
        url:   'includes/php/busqueda_licencia.php',
        dataType: 'html',
        type:  'post',
        beforeSend: function () {
          //mostramos gif "cargando"
          //jQuery('#loading_spinner').show();
          //antes de enviar la petición al fichero PHP, mostramos mensaje
          jQuery("#tabladatotres").html("Déjame pensar un poco...");
        },
        success:  function (response) {
          jQuery("#tabladatotres").html(response);
        }
      });
    });
  });
</script>
