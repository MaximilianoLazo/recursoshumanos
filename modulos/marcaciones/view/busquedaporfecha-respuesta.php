<?php
  set_time_limit(1800);
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    header('Location: ../login/index.php');
  }
  require_once '../../../database/Conexion.php';
  require_once '../model/marcacion.php';

  $marcacion = new Marcacion();

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

  $datosempleado = $marcacion->ObtenerEmpleado($nrodocto);
  $datoaccessid = $marcacion->ObtenerAccessId($nrodocto);
  $accessid = $datoaccessid->marcacion_accessid;

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
                <th width="8%">Entrada</th>
                <th width="8%">Salida</th>
                <th width="8%">Entrada</th>
                <th width="8%">Salida</th>
                <th width="8%">Entrada</th>
                <th width="8%">Salida</th>
                <th>Novedad</th>
                <th width="4%" style="text-align: center;">?</th>
              </tr>
            </thead>
            <tbody>
              <tr>
              <?php foreach($period as $dt):

                $fecha = $dt->format('m/d/Y');
                $fechasql = $dt->format('Y-m-d');
                $fechanombredia = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$fecha"))));


                $feriadosdiaactual = $marcacion->ObtenerFeriadosDia($fechasql);
                $licenciasempleadodia = $marcacion->ObtenerLicenciasDia($fechasql, $nrodocto);
                //---- Verificar novedades y feriados ---
                if(empty($feriadosdiaactual) AND empty($licenciasempleadodia)){
                  //--- No existe feriado ni licencias ---
                  $novedad = "";
                }else{
                  //--- Preguntar si no existe feriado---
                  if(empty($feriadosdiaactual)){
                    //---- No existe feriado, Si licencia
                    //$novedad = "Licencia: ".$licenciasempleadodia->licencia_nombre;
                    $novedad = null;
                    foreach($licenciasempleadodia as $key => $licenciaempleadodia){
                      //$novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
                      if ($licenciaempleadodia === end($licenciasempleadodia)) {
                        //echo "ÚLTIMO ELEMENTO";
                        $novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre;
                      }else{
                        $novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
                      }
                    }

                  }else{
                    //---Existe feriado, Preguntar licencia
                    if(empty($licenciasempleadodia)){
                      //--- No existe licencia, si feriado
                      //$novedad = "Feriado: ".$feriadodiaactual->feriado_observacion;
                      $novedad = null;
                      foreach($feriadosdiaactual as $key => $feriadodiaactual){
                        //$novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
                        if ($feriadodiaactual === end($feriadosdiaactual)) {
                          //echo "ÚLTIMO ELEMENTO";
                          $novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion;
                        }else{
                          $novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
                        }
                      }
                    }else{
                      //--- Existe licencia y feriado
                      //$novedad = "Feriado: ".$feriadosdiaactual->feriado_observacion."<br>Licencia: ".$licenciasempleadodia->licencia_nombre;
                      $novedad = null;
                      foreach($licenciasempleadodia as $key => $licenciaempleadodia){
                        //$novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
                        if ($licenciaempleadodia === end($licenciasempleadodia)) {
                          //echo "ÚLTIMO ELEMENTO";
                          $novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
                        }else{
                          $novedad = $novedad."Licencia: ".$licenciaempleadodia->licencia_nombre."<br>";
                        }
                      }
                      foreach($feriadosdiaactual as $key => $feriadodiaactual){
                        //$novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
                        if ($feriadodiaactual === end($feriadosdiaactual)) {
                          //echo "ÚLTIMO ELEMENTO";
                          $novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion;
                        }else{
                          $novedad = $novedad."Feriado: ".$feriadodiaactual->feriado_observacion."<br>";
                        }
                      }
                    }
                  }
                }
                $fichadasempleadoc = $marcacion->ObtenerFichadaDia($fechasql, $nrodocto);
                $fichadasdia = $marcacion->ObtenerMarcacionesDia($fechasql, $nrodocto);
                $fichadasdiac = count($fichadasdia);
                $horame1 = null;
                $horams1 = null;
                $horame2 = null;
                $horams2 = null;
                $horame3 = null;
                $horams3 = null;

                if($fichadasdiac == 0){
                  //---No tiene fichadas
                  //--- Preguntar si ese dia trabaja ---
                  $mensajeuno = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  $mensajedos = "<p style='color:#008f39;font-size:12px;'><strong>Día no laboral</strong></p>";
                  $mensajeferiado = "<p style='color:#0000FF;font-size:12px;'><strong>Día feriado</strong></p>";
                  if($fichadasempleadoc == 0){
                    //---dia no laboral
                    ?>
                    <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                    <td data-title="Entrada:"><?php echo $mensajedos; ?></td>
                    <td data-title="Salida:"><?php echo $mensajedos; ?></td>
                    <td data-title="Entrada:"><?php echo ""; ?></td>
                    <td data-title="Salida:"><?php echo ""; ?></td>
                    <td data-title="Entrada:"><?php echo ""; ?></td>
                    <td data-title="Salida:"><?php echo ""; ?></td>
                    <td data-title="Novedad:"><?php echo $novedad; ?></td>
                    <td data-title="Historico:">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                    </td>
                    <?php
                  }elseif($fichadasempleadoc == 1){
                    //---dia laboral 1
                    //---No es feriado ---
                    if(empty($feriadosdiaactual)){
                      ?>
                      <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                      <td data-title="Entrada:"><?php echo $mensajeuno; ?></td>
                      <td data-title="Salida:"><?php echo $mensajeuno; ?></td>
                      <td data-title="Entrada:"><?php echo ""; ?></td>
                      <td data-title="Salida:"><?php echo ""; ?></td>
                      <td data-title="Entrada:"><?php echo ""; ?></td>
                      <td data-title="Salida:"><?php echo ""; ?></td>
                      <td data-title="Novedad:"><?php echo $novedad; ?></td>
                      <td data-title="Historico:">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                      </td>
                      <?php
                    //--- Es firiado ---
                    }else{
                      ?>
                      <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                      <td data-title="Entrada:"><?php echo $mensajeferiado; ?></td>
                      <td data-title="Salida:"><?php echo $mensajeferiado; ?></td>
                      <td data-title="Entrada:"><?php echo ""; ?></td>
                      <td data-title="Salida:"><?php echo ""; ?></td>
                      <td data-title="Entrada:"><?php echo ""; ?></td>
                      <td data-title="Salida:"><?php echo ""; ?></td>
                      <td data-title="Novedad:"><?php echo $novedad; ?></td>
                      <td data-title="Historico:">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                      </td>
                      <?php
                    }
                  }elseif($fichadasempleadoc == 2){
                    //--- dia laboral 2
                    //---No es feriado ---
                    if(empty($feriadosdiaactual)){
                      ?>
                      <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                      <td data-title="Entrada:"><?php echo $mensajeuno; ?></td>
                      <td data-title="Salida:"><?php echo $mensajeuno; ?></td>
                      <td data-title="Entrada:"><?php echo $mensajeuno; ?></td>
                      <td data-title="Salida:"><?php echo $mensajeuno; ?></td>
                      <td data-title="Entrada:"><?php echo ""; ?></td>
                      <td data-title="Salida:"><?php echo ""; ?></td>
                      <td data-title="Novedad:"><?php echo $novedad; ?></td>
                      <td data-title="Historico:">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                      </td>
                      <?php
                    //--- Es firiado ---
                    }else{
                      ?>
                      <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                      <td data-title="Entrada:"><?php echo $mensajeferiado; ?></td>
                      <td data-title="Salida:"><?php echo $mensajeferiado; ?></td>
                      <td data-title="Entrada:"><?php echo $mensajeferiado; ?></td>
                      <td data-title="Salida:"><?php echo $mensajeferiado; ?></td>
                      <td data-title="Entrada:"><?php echo ""; ?></td>
                      <td data-title="Salida:"><?php echo ""; ?></td>
                      <td data-title="Novedad:"><?php echo $novedad; ?></td>
                      <td data-title="Historico:">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                      </td>
                      <?php
                    }
                  }else{
                    //---error
                    ?>
                    <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                    <td data-title="Entrada:"><?php echo ""; ?></td>
                    <td data-title="Salida:"><?php echo ""; ?></td>
                    <td data-title="Entrada:"><?php echo ""; ?></td>
                    <td data-title="Salida:"><?php echo ""; ?></td>
                    <td data-title="Entrada:"><?php echo ""; ?></td>
                    <td data-title="Salida:"><?php echo ""; ?></td>
                    <td data-title="Novedad:"><?php echo $novedad; ?></td>
                    <td data-title="Historico:">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                    </td>
                    <?php
                  }
                }elseif($fichadasdiac == 1){
                  //---Tine 1 Fichada ---
                  list($fechame1, $horame1) = explode(" ", $fichadasdia[0]->mprocesop_entrada);
                  list($fechams1, $horams1) = explode(" ", $fichadasdia[0]->mprocesop_salida);
                  if($fichadasdia[0]->mprocesop_entrada == "0000-00-00 00:00:00"){
                    $horame1m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horame1);
                    $horame1m = $hh.":".$mm;
                  }
                  if($fichadasdia[0]->mprocesop_salida == "0000-00-00 00:00:00"){
                    $horams1m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horams1);
                    $horams1m = $hh.":".$mm;
                  }
                  ?>
                  <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                  <td data-title="Entrada:"><?php echo $horame1m; ?></td>
                  <td data-title="Salida:"><?php echo $horams1m; ?></td>
                  <td data-title="Entrada:"><?php echo ""; ?></td>
                  <td data-title="Salida:"><?php echo ""; ?></td>
                  <td data-title="Entrada:"><?php echo ""; ?></td>
                  <td data-title="Salida:"><?php echo ""; ?></td>
                  <td data-title="Novedad:"><?php echo $novedad; ?></td>
                  <td data-title="Historico:">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                  </td>
                  <?php
                }elseif($fichadasdiac == 2){
                  //---Tiene 2 Fichadas ---
                  //---- Fichada 1
                  list($fechame1, $horame1) = explode(" ", $fichadasdia[0]->mprocesop_entrada);
                  list($fechams1, $horams1) = explode(" ", $fichadasdia[0]->mprocesop_salida);
                  if($fichadasdia[0]->mprocesop_entrada == "0000-00-00 00:00:00"){
                    $horame1m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horame1);
                    $horame1m = $hh.":".$mm;
                  }
                  if($fichadasdia[0]->mprocesop_salida == "0000-00-00 00:00:00"){
                    $horams1m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horams1);
                    $horams1m = $hh.":".$mm;
                  }
                  //---Fichada 2
                  list($fechame2, $horame2) = explode(" ", $fichadasdia[1]->mprocesop_entrada);
                  list($fechams2, $horams2) = explode(" ", $fichadasdia[1]->mprocesop_salida);
                  if($fichadasdia[1]->mprocesop_entrada == "0000-00-00 00:00:00"){
                    $horame2m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horame2);
                    $horame2m = $hh.":".$mm;
                  }
                  if($fichadasdia[1]->mprocesop_salida == "0000-00-00 00:00:00"){
                    $horams2m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horams2);
                    $horams2m = $hh.":".$mm;
                  }
                 ?>
                 <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                 <td data-title="Entrada:"><?php echo $horame1m; ?></td>
                 <td data-title="Salida:"><?php echo $horams1m; ?></td>
                 <td data-title="Entrada:"><?php echo $horame2m; ?></td>
                 <td data-title="Salida:"><?php echo $horams2m; ?></td>
                 <td data-title="Entrada:"><?php echo ""; ?></td>
                 <td data-title="Salida:"><?php echo ""; ?></td>
                 <td data-title="Novedad:"><?php echo $novedad; ?></td>
                 <td data-title="Historico:">
                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                 </td>
                 <?php
                }elseif($fichadasdiac == 3){
                  //---Tiene 3 Fichadas ---
                  //---- Fichada 1
                  list($fechame1, $horame1) = explode(" ", $fichadasdia[0]->mprocesop_entrada);
                  list($fechams1, $horams1) = explode(" ", $fichadasdia[0]->mprocesop_salida);
                  if($fichadasdia[0]->mprocesop_entrada == "0000-00-00 00:00:00"){
                    $horame1m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horame1);
                    $horame1m = $hh.":".$mm;
                  }
                  if($fichadasdia[0]->mprocesop_salida == "0000-00-00 00:00:00"){
                    $horams1m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horams1);
                    $horams1m = $hh.":".$mm;
                  }
                  //---Fichada 2
                  list($fechame2, $horame2) = explode(" ", $fichadasdia[1]->mprocesop_entrada);
                  list($fechams2, $horams2) = explode(" ", $fichadasdia[1]->mprocesop_salida);
                  if($fichadasdia[1]->mprocesop_entrada == "0000-00-00 00:00:00"){
                    $horame2m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horame2);
                    $horame2m = $hh.":".$mm;
                  }
                  if($fichadasdia[1]->mprocesop_salida == "0000-00-00 00:00:00"){
                    $horams2m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horame2);
                    $horams2m = $hh.":".$mm;
                  }
                  //---Fichada 3
                  list($fechame3, $horame3) = explode(" ", $fichadasdia[2]->mprocesop_entrada);
                  list($fechams3, $horams3) = explode(" ", $fichadasdia[2]->mprocesop_salida);
                  if($fichadasdia[2]->mprocesop_entrada == "0000-00-00 00:00:00"){
                    $horame3m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horame3);
                    $horame3m = $hh.":".$mm;
                  }
                  if($fichadasdia[2]->mprocesop_salida == "0000-00-00 00:00:00"){
                    $horams3m = "<p style='color:#FF0000;font-size:12px;'><strong>Fichada no encontrada</strong></p>";
                  }else{
                    //---
                    list($hh, $mm, $ss) = explode(":", $horams3);
                    $horams3m = $hh.":".$mm;
                  }
                  ?>
                  <td data-title="Fecha:"><?php echo $fechanombredia; ?></td>
                  <td data-title="Entrada:"><?php echo $horame1m; ?></td>
                  <td data-title="Salida:"><?php echo $horams1m; ?></td>
                  <td data-title="Entrada:"><?php echo $horame2m; ?></td>
                  <td data-title="Salida:"><?php echo $horams2m; ?></td>
                  <td data-title="Entrada:"><?php echo $horame3m; ?></td>
                  <td data-title="Salida:"><?php echo $horams3m; ?></td>
                  <td data-title="Novedad:"><?php echo $novedad; ?></td>
                  <td data-title="Historico:">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateFichadaDia" data-accessid="" data-fecha="<?php echo $fechasql; ?>">?</button>
                  </td>
                  <?php
                }else{
                  //---Tiene mas de 3 fichadas
                }
              ?>
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
