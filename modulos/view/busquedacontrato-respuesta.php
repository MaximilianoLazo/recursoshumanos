<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

require_once '../../../database/Conexion.php';
require_once '../model/empleado.php';

$empleado = new Empleado();

$secretaria = $_POST["CboSecretaria"];
$lugardetrabajo = $_POST["CboLugarDeTrabajo"];
$tipodecontrato = $_POST["CboTipoDeContrato"];
$sbasicodesde = $_POST["SBasicoDesde"];
$sbasicohasta = $_POST["SBasicoHasta"];

$orden = $_POST["RdoOrden"];
foreach($orden as $ordenc){
  $ordenci = $ordenc;
}

?>

    <?php
    if($tipodecontrato == 1){
      ?>
      <div class="form-group">
        <div align="right">
          <button type="button" class="btn btn-danger" id="BtnImprimirContratosC">Imprimir Contratos</button>
          <button type="button" class="btn btn-info" id="BtnListarContratos">Imprimir Listado</button>
        </div>
      </div>
      <?php
      $contratos = $empleado->ListarContratos($secretaria, $lugardetrabajo, $tipodecontrato, $sbasicodesde, $sbasicohasta, $ordenci);
      $contratosc = count($contratos);
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label"><?php echo "Cantidad de Contratados: ".$contratosc; ?></label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div id="no-more-tables">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table width="100%" border="1" class="table table-striped table-hover table-fixed">
                <thead>
                  <tr>
                    <th>Nro Documento</th>
                    <th>Apellido y Nombres</th>
                    <th>Lugar de Trabajo</th>
                    <th>Imputacion</th>
                    <th>Fec Igreso</th>
                    <th>Fec Inicio</th>
                    <th>Fec Final</th>
                    <th>Tarea</th>
                    <th>S. Basico</th>
                    <th width="3%">
                      <div class="custom-control custom-checkbox mb-5">
                        <input type="checkbox" class="custom-control-input check-all" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1"></label>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                    //foreach($empleado->ListarContratos($secretaria, $lugardetrabajo) as $row):
                    foreach($contratos as $row):
                      $fechaingreso = date("d/m/Y", strtotime($row->legempleado_fecingreso));
                      $contratofeci = date("d/m/Y", strtotime($row->legcontrato_fecinicio));
                      $contratofecf = date("d/m/Y", strtotime($row->legcontrato_fecfin));
                      $sbasico = number_format($row->legcontrato_sbasico, 2, ',', '.');
                      $nrodocto = $row->legempleado_nrodocto;
                      $imputacionid = $row->imputacion_id;
                      $datoimputacion = $empleado->ObtenerImputacion($imputacionid);
                      $sbasicobase = $empleado->ObtenerActualizacion($nrodocto);

                      $cantidad = $sbasicobase->legajo_importeb;
                      $porciento = 10;
                      $decimales = 2;
                      $sbasiconuevo = $empleado->Porcentaje($cantidad,$porciento,$decimales);
                      $sbasiconuevo2 = $cantidad + $sbasiconuevo;
                  ?>
                  <tr>
                    <td data-title="no name:"><?php echo $row->legempleado_nrodocto; ?></td>
                    <td data-title="no name:"><?php echo $row->legempleado_apellido.", <br>".$row->legempleado_nombres; ?></td>
                    <td data-title="no name:"><?php echo $row->trabajo_nombre; ?></td>
                    <td data-title="no name:"><?php echo $datoimputacion->imputacion_codigow; ?></td>
                    <td data-title="no name:"><?php echo $fechaingreso; ?></td>
                    <td data-title="no name:"><?php echo $contratofeci; ?></td>
                    <td data-title="no name:"><?php echo $contratofecf; ?></td>
                    <td data-title="no name:"><?php echo $row->legcontrato_tarea; ?></td>
                    <td data-title="no name:"><?php echo "$ ".$sbasico; ?></td>
                    <td data-title="no name:">
                      <div class="custom-control custom-checkbox mb-5">
                        <input type="checkbox" class="custom-control-input check-cont" name="checkbox[]" value="<?php echo $row->legempleado_nrodocto; ?>" id="checkbox[<?php echo $row->legempleado_nrodocto; ?>]">
                        <label class="custom-control-label" for="checkbox[<?php echo $row->legempleado_nrodocto; ?>]"></label>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php
    }else{
      ?>
      <div class="form-group">
        <div align="right">
          <button type="button"
                  class="btn btn-danger"
                  id="BtnImprimirContratosP">
                  Imprimir Contratos Proveedores
          </button>
          <button type="button"
                  class="btn btn-info"
                  id="BtnListarContratosP">
                  Imprimir Listado
          </button>
        </div>
      </div>
      <!--//////////////////////////////////////////////////////-->
      <?php
      $contratos = $empleado->ListarContratosProveedor($secretaria, $lugardetrabajo, $tipodecontrato, $sbasicodesde, $sbasicohasta, $ordenci);
      $contratosc = count($contratos);
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label"><?php echo "Cantidad de Proveedores: ".$contratosc; ?></label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div id="no-more-tables">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table width="100%" border="1" class="table table-striped table-hover table-fixed">
                <thead>
                  <tr>
                    <th>Nro Documento</th>
                    <th>Apellido y Nombres</th>
                    <th>Lugar de Trabajo</th>

                    <th>Fec Igreso</th>
                    <th>Fec Inicio</th>
                    <th>Fec Final</th>
                    <th>Tarea</th>
                    <th>S. Basico</th>
                    <th width="3%">
                      <div class="custom-control custom-checkbox mb-5">
                        <input type="checkbox" class="custom-control-input check-all" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1"></label>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                    //foreach($empleado->ListarContratos($secretaria, $lugardetrabajo) as $row):
                    foreach($contratos as $row):
                      $fechaingreso = date("d/m/Y", strtotime($row->legempleado_fecingreso));
                      $contratofeci = date("d/m/Y", strtotime($row->legproveedor_fecinicio));
                      $contratofecf = date("d/m/Y", strtotime($row->legproveedor_fecfin));
                      $sbasico = number_format($row->legproveedor_sbasico, 2, ',', '.');
                      $nrodocto = $row->legempleado_nrodocto;
                      $imputacionid = $row->imputacion_id;
                      //$datoimputacion = $empleado->ObtenerImputacion($imputacionid);
                      $sbasicobase = $empleado->ObtenerActualizacionProveedor($nrodocto);

                      $cantidad = $sbasicobase->legajo_importeb;
                      $porciento = 10;
                      $decimales = 2;
                      $sbasiconuevo = $empleado->Porcentaje($cantidad,$porciento,$decimales);
                      $sbasiconuevo2 = $cantidad + $sbasiconuevo;
                  ?>
                  <tr>
                    <td data-title="no name:"><?php echo $row->legempleado_nrodocto; ?></td>
                    <td data-title="no name:"><?php echo $row->legempleado_apellido.", <br>".$row->legempleado_nombres; ?></td>
                    <td data-title="no name:"><?php echo $row->trabajo_nombre; ?></td>

                    <td data-title="no name:"><?php echo $fechaingreso; ?></td>
                    <td data-title="no name:"><?php echo $contratofeci; ?></td>
                    <td data-title="no name:"><?php echo $contratofecf; ?></td>
                    <td data-title="no name:"><?php echo $row->legproveedor_tarea; ?></td>
                    <td data-title="no name:"><?php echo "$ ".$sbasico; ?></td>
                    <td data-title="no name:">
                      <div class="custom-control custom-checkbox mb-5">
                        <input type="checkbox" class="custom-control-input check-cont" name="checkbox[]" value="<?php echo $row->legempleado_nrodocto; ?>" id="checkbox[<?php echo $row->legempleado_nrodocto; ?>]">
                        <label class="custom-control-label" for="checkbox[<?php echo $row->legempleado_nrodocto; ?>]"></label>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
    ?>

<script>
  jQuery(document).ready(function(){
    jQuery("#BtnImprimirContratosC").click(function(){
      //--------Obtenemos el valor del input
      //var nrodnis = jQuery('input:checkbox:checked').val();
      var nrodnis = [];
      console.log($("input[name='checkbox[]']"));
      $("input[name='checkbox[]']:checked").each(function(){
        console.log($(this).val());
        nrodnis .push($(this).val());
      });
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
    jQuery("#BtnImprimirContratosP").click(function(){
      //--------Obtenemos el valor del input
      //var nrodnis = jQuery('input:checkbox:checked').val();
      var nrodnis = [];
      console.log($("input[name='checkbox[]']"));
      $("input[name='checkbox[]']:checked").each(function(){
        console.log($(this).val());
        nrodnis .push($(this).val());
      });
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
        url: 'includes/pdf/proveedor-general.php',
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
    jQuery("#BtnListarContratos").click(function(){
      //--------Obtenemos el valor del input
      //var nrodnis = jQuery('input:checkbox:checked').val();
      var nrodnis = [];
      console.log($("input[name='checkbox[]']"));
      $("input[name='checkbox[]']:checked").each(function(){
        console.log($(this).val());
        nrodnis .push($(this).val());
      });
      //var nrodnis = jQuery("#checkbox").val();
      //var historicodi = jQuery("#mbusquedahistoricodi").val();
      //var historicodf = jQuery("#mbusquedahistoricodf").val();
      var params = {
        "NroDnis" : nrodnis,
        "ContratosC" : '<?php echo $contratosc;?>',
        "Secretaria" : '<?php echo $secretaria;?>',
      };
      //--------llamada al fichero PHP con AJAX
      $.ajax({
        cache: false,
        type: 'POST',
        //dataType:"html",
        url: 'includes/pdf/contrato-listado.php',
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
    jQuery("#BtnListarContratosP").click(function(){
      //--------Obtenemos el valor del input
      //var nrodnis = jQuery('input:checkbox:checked').val();
      var nrodnis = [];
      console.log($("input[name='checkbox[]']"));
      $("input[name='checkbox[]']:checked").each(function(){
        console.log($(this).val());
        nrodnis .push($(this).val());
      });
      //var nrodnis = jQuery("#checkbox").val();
      //var historicodi = jQuery("#mbusquedahistoricodi").val();
      //var historicodf = jQuery("#mbusquedahistoricodf").val();
      var params = {
        "NroDnis" : nrodnis,
        "ContratosC" : '<?php echo $contratosc;?>',
        "Secretaria" : '<?php echo $secretaria;?>',
      };
      //--------llamada al fichero PHP con AJAX
      $.ajax({
        cache: false,
        type: 'POST',
        //dataType:"html",
        url: 'includes/pdf/proveedor-listado.php',
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
  var checked = false;

  $('.check-all').on('click',function(){

    if(checked == false){
      $('.check-cont').prop('checked', true);
      checked = true;
    }else{
      $('.check-cont').prop('checked', false);
      checked = false;
    }
  });
</script>
