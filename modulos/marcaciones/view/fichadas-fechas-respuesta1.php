<?php
  set_time_limit(1800);
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    header('Location: ../login/index.php');
  }

  //----- datos extraidos
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
  $nrodocto = $_POST["NroDocto"];
  $fechai = $_POST["FechaI"];
  $fechaf = $_POST["FechaF"];
  //----- calculo para rango de fecahs ----
  $date_start = new DateTime($fechai);
  $date_end = new DateTime("$fechaf 23:59:59");

  $interval = '+1 days';
  $date_interval = DateInterval::createFromDateString($interval);
  $period = new DatePeriod($date_start, $date_interval, $date_end);

  $datosempleado = $this->model->EmpleadoObtener($nrodocto);
  /*$datoaccessid = $marcacion->ObtenerAccessId($nrodocto);
  $accessid = $datoaccessid->marcacion_accessid;*/

?>

  <div class="row">
    <div class="col-md-6">
      <div class="clearfix">
        <h5 class="text-blue"><?php echo "Empleado: ".$datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres; ?></h5>
      </div>
    </div>
    <div class="col-md-6">
      <div class="clearfix">
        <div align="right">
          <!--<a class="btn btn-danger" href="?c=marcacion&a=ImprimirFichadaLoteI&id=<?php echo $nrodocto; ?>">Imprimir Fichadas</a>-->
          <button type="button" class="btn btn-danger" id="btnbxfecimprimir">Imprimir Fichadas</button>
          <a class="btn btn-warning" href="?c=marcacion&a=MarcacionesReprocesar&id=<?php echo $accessid; ?>">Re-Procesar</a>
        </div>
      </div>
    </div>
  </div>
  <p></p>

  <div class="row">
    <div class="col-md-12">
      <div id="no-more-tables">
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table width="100%" border="1" class="table table-striped table-hover table-fixed">
            <thead>
              <tr>
                <th width="11%">Fecha</th>
                <th width="48%">HORARIOS</th>
                <th>Novedad</th>
                <th width="4%" style="text-align: center;">?</th>
              </tr>
            </thead>
            <tbody>
              <tr>
              <?php foreach($period as $dt):

                $fecha = $dt->format('m/d/Y');
                $fechasql = $dt->format('Y-m-d');
                $fecha_pantalla = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$fecha"))));
              ?>
              <tr>
                <td data-title="Salida:"><?php echo $fecha_pantalla; ?></td>
                <td data-title="Salida:"><?php echo ""; ?></td>
                <td data-title="Salida:"><?php echo ""; ?></td>
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
      jQuery("#btnbxfecimprimir").click(function(){
        //--------Obtenemos el valor del input
        var params = {
          "NroDni" : '<?php echo $nrodocto; ?>',
          "FechaI" : '<?php echo $fechai; ?>',
          "FechaF" : '<?php echo $fechaf; ?>',
        };
        //--------llamada al fichero PHP con AJAX
        $.ajax({
          cache: false,
          type: 'POST',
          //dataType:"html",
          url: 'includes/pdf/fichadas-periodoi.php',
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
