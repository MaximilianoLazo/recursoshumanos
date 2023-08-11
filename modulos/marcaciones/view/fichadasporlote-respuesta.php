<?php

  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    header('Location: ../login/index.php');
  }
  require_once '../../../database/Conexion.php';
  require_once '../model/marcacion.php';

  $marcacion = new Marcacion();


  $secretaria = $_POST["CboSecretaria"];
  $lugardetrabajo = $_POST["CboLugarDeTrabajo"];
  $tipodecontrato = $_POST["CboTipoDeContrato"];
  //--- Orden del listado ----
  $orden = $_POST["RdoOrden"];
  foreach($orden as $ordenc){
    $ordenci = $ordenc;
  }

?>
  <div class="row">
    <div class="col-md-6">
      <div class="clearfix">
        <h5 class="text-blue"><?php //echo "Empleado: ".$datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres; ?></h5>
      </div>
    </div>
    <div class="col-md-6">
      <div class="clearfix">
        <div align="right">
          <button type="button" class="btn btn-danger" id="BtnImprimirContratosC">Imprimir Fichadas LOTE</button>
        </div>
      </div>
    </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-md-12">
      <div id="no-more-tables">
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table border="1" class="table table-striped table-hover table-fixed">
            <thead>
              <tr>
                <th width="8%">DNI</th>
                <th>Empleado</th>
                <th>campo</th>
                <th>campo</th>
                <th>campo</th>
                <th>campo</th>
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
              foreach($marcacion->ObtenerEmpleadoXLTrabajo($lugardetrabajo) as $row):
              ?>
              <tr>
                <td data-title="DNI:"><?php echo $row->legempleado_nrodocto; ?></td>
                <td data-title="Empleado:"><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
                <td data-title="no nome:"><?php //echo $row->reloj_nombre; ?></td>
                <td data-title="no nome:"><?php //echo $row->mdireccion_descripcion; ?></td>
                <td data-title="no nome:"><?php //echo $row->mfuente_descripcion; ?></td>
                <td data-title="no nome:"><?php //echo $row->mestado_nombre; ?></td>
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
          url: 'includes/pdf/fichadas-periodoc.php',
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
    //---- Activar o Desactivar todos los checked ----
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
