<?php
  set_time_limit(1800);
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    echo '<meta http-equiv="refresh" content="0;URL=../login/index.php">';
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
<div class="clearfix">
  <h5 class="text-blue"><?php //echo $personaapellido.", ".$personanombres; ?></h5>
  <p></p>
</div>
<?php

//----- Es Otro Beneficiario ----
/*$datosbeneficiario = $this->model->ObtenerBeneficiario($nrodocto);*/
/*$personaapellido = $datosbeneficiario->leghijo_benapellido;
$personanombres = $datosbeneficiario->leghijo_bennombres;*/
?>
  <div class="clearfix">
    <h5 class="text-blue"><?php //echo $personaapellido.", ".$personanombres; ?></h5>
    <p></p>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="clearfix">
        <h5 class="text-blue"><?php //echo "Empleado: ".$datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres; ?></h5>
      </div>
    </div>
    <div class="col-md-6">
      <div class="clearfix">
        <div align="right">
          <!--<a class="btn btn-danger" href="?c=marcacion&a=ImprimirFichadaLoteI&id=">AGREGAR Haberes</a>-->

        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="clearfix">
        <h5 class="text-blue"><?php echo "Empleado: ".$datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres; ?></h5>
      </div>
    </div>
    <div class="col-md-6">
      <div class="clearfix">
        <div align="right">
          <button type="button" class="btn btn-success" id="">DESCARGAR CSV</button>
          <button type="button" class="btn btn-danger" id="btnfichadasfechaspdf">DESCARGAR PDF</button>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <table class="data-table table-bordered stripe hover nowrap">
      <thead>
        <tr>
          <th class="datatable-nosort" width="10%">FECHA</th>
          <th class="datatable-nosort" width="">HORARIOS</th>
          <th class="datatable-nosort" width="20%">NAVEDADES</th>
        </tr>
      </thead>
      <tbody>
        <?php
         foreach($period as $dt):

          $fecha = $dt->format('m/d/Y');
          $fecha_sql = $dt->format('Y-m-d');
          $fecha_pantalla = (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$fecha"))));

          $fichadasinprocesardia = $this->model->FichadasHistoricoDiaObtener($nrodocto, $fecha_sql);
          $feriadosdiaactual = $this->model->FeriadosDiaObtener($fecha_sql);
          $licenciasempleadodia = $this->model->LicenciasDiaObtener($fecha_sql, $nrodocto);
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
        ?>
        <tr>
          <!--<td><?php //echo $fechasql; ?></td>-->
          <td data-order="<?php echo $fecha_sql; ?>" >
              <?php echo $fecha_pantalla; ?>
          </td>
          <td>
            <?php
            foreach($fichadasinprocesardia as $row3){
              ?><label><?php echo $row3->emp_fichada." - "; ?></label><?php
            }
            ?>
          </td>
          <!--<td class="dt-right"><?php //echo $row->liquidacion_cantidad; ?></td>-->
          <td><?php echo $novedad; ?></td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>

  <script>

    $('document').ready(function(){
      $('.data-table').DataTable({
        scrollCollapse: true,
        autoWidth: false,
        /*rowReorder: {
              selector: 'td:nth-child(1)'
        },*/
        responsive: true,
        /*responsive: {
           details: {
               display: $.fn.dataTable.Responsive.display.childRowImmediate,
               type: ''
           }
        },*/
        paging: false,
        searching: false,
        info: false,
        columnDefs: [{
          className: "dt-right"
        }],
        columnDefs: [{
          targets: "datatable-nosort",
          orderable: false,
        }],
        /*columnDefs: [{
          targets: 0,
          render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'dddd L', 'es'),
        }],*/

        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
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
    });

    jQuery(document).ready(function(){
      jQuery("#btnfichadasfechaspdf").click(function(){
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
          url: "?c=marcacion&a=FichadasFechasPDF",
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
