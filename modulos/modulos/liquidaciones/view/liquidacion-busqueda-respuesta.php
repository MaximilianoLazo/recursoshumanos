<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

$nrodocto = $_POST["NroDoctoEmpBen"];
//----Obtener periodo actual --------
$periodo = $this->model->PeriodoActualObtener();
$periodoid = $periodo->periodo_id;
//----Obtener si nrodocto esta liquidado
$datosliquidacion = $this->model->ObtenerLiquidacion($nrodocto,$periodoid);
$datosliquidacionc = COUNT($datosliquidacion);
if($datosliquidacionc > 0){
  //----Hay datos de liquidacion, preguntas si es empleado u otro beneficiario
  if($datosliquidacion[0]->legempleado_nrodocto == $datosliquidacion[0]->liquidacion_nrodocto){
    //------- Es empleado ----
    $datosempleado = $this->model->ObtenerEmpleado($nrodocto);
    $personaapellido = $datosempleado->legempleado_apellido;
    $personanombres = $datosempleado->legempleado_nombres;
    ?>
    <div class="clearfix">
      <h5 class="text-blue"><?php echo $personaapellido.", ".$personanombres; ?></h5>
      <p></p>
    </div>
    <?php
  }else{
    //----- Es Otro Beneficiario ----
    $datosbeneficiario = $this->model->ObtenerBeneficiario($nrodocto);
    $personaapellido = $datosbeneficiario->leghijo_benapellido;
    $personanombres = $datosbeneficiario->leghijo_bennombres;
    ?>
    <div class="clearfix">
      <h5 class="text-blue"><?php echo $personaapellido.", ".$personanombres; ?></h5>
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
            <button type="button"
                    class="btn btn-danger"
                    data-toggle="modal"
                    data-target="#LiquidacionAltaHaberes"
                    data-titulo="<?php echo "AGREGAR Haberes"; ?>"
                    data-licempndoc="<?php echo $nrodocto; ?>"
                    data-titular="<?php echo "2"; ?>">
                    AGREGAR Haberes
            </button>
            <button type="button"
                    class="btn btn-warning"
                    data-toggle="modal"
                    data-target="#LiquidacionAltaDescuentos"
                    data-titulo="<?php echo "AGREGAR Descuentos"; ?>"
                    data-ndoc="<?php echo $nrodocto; ?>"
                    data-empndoc="<?php echo $datosliquidacion[0]->legempleado_nrodocto; ?>"
                    data-periodo ="<?php echo $periodoid; ?>"
                    data-titular="<?php echo "2"; ?>">
                    AGREGAR Descuentos
            </button>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <table class="data-table table-bordered stripe hover nowrap">
        <thead>
          <tr>
            <th>CODIGO</th>
            <th>CONCEPTOS</th>
            <th>CANTIDAD</th>
            <th>HABERES</th>
            <th>DESCUENTOS</th>
            <th>ACCIONES</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($datosliquidacion as $row):
              $liquidacionimporte_formato = number_format($row->liquidacion_importe, 2, ',', '.');
          ?>
          <tr>
            <td class="dt-right"><?php echo $row->liqcod_id; ?></td>
            <td><?php echo $row->liqcod_descripcion; ?></td>
            <td class="dt-right"><?php echo $row->liquidacion_cantidad; ?></td>
            <td class="dt-right">
              <?php
                if($row->liqcodtipo_id != 4){
                  echo $liquidacionimporte_formato;
                }else{
                  echo "";
                }
              ?>
            </td>
            <td class="dt-right">
              <?php
                if($row->liqcodtipo_id == 4){
                  echo $liquidacionimporte_formato;
                }else{
                  echo "";
                }
              ?>
            </td>
            <td class="dt-right">
              <a  class="btn btn-success" href="#">Ver Detalles</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
  }
}else{
  //----No hay datos de liquidacion-----
  echo "Ningun dato de liquidacion encontrado";
}

?>

<script>
  $('document').ready(function(){
    $('.data-table').DataTable({
      scrollCollapse: true,
      autoWidth: false,
/*      rowReorder: {
            selector: 'td:nth-child(1)'
        },*/
      //responsive: true,
     responsive: {
         details: {
             display: $.fn.dataTable.Responsive.display.childRowImmediate,
             type: ''
         }
     },
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
    /*  columnDefs: [
        {
        targets: 3,
        render: $.fn.dataTable.render.number('.', ',', 2, ''),
        },
        {
        targets: 4,
        render: $.fn.dataTable.render.number('.', ',', 2, ''),
        },
        {
        targets: 5,
        render: $.fn.dataTable.render.number('.', ',', 2, ''),
        }
      ],*/

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
    jQuery("#BtnImprimirContratos").click(function(){
      //--------Obtenemos el valor del input
      //var nrodnis = jQuery('input:checkbox:checked').val();
      var nrodnis = [];
      console.log($("input[name='checkbox[]']"));
      $("input[name='checkbox[]']:checked").each(function(){
        console.log($(this).val());
        nrodnis .push($(this).val());
      });
      //var fechainicioc = "'.$variable_php.'";
      var fechainicioc = '<?php echo $fechainicionueva; ?>';
      var fechafinc = '<?php echo $fechafinnueva; ?>';
      var basiconuevo = '<?php echo $actualizacion; ?>';

      var params = {
        "NroDnis" : nrodnis,
        "FechaInicioNueva" : fechainicioc,
        "FechaFinNueva" : fechafinc,
        "BasicoNuevo" : basiconuevo,
      };
      //--------llamada al fichero PHP con AJAX
      $.ajax({
        cache: false,
        type: 'POST',
        dataType:"html",
        url: '?c=empleado&a=ActualizacionDeContratos',
        //contentType: false,
        //processData: false,
        data: params,
        //xhrFields is what did the trick to read the blob to pdf
        xhrFields:{
          responseType: 'blob'
        },
        beforeSend: function () {
          //mostramos gif "cargando"
          //jQuery('#loading_spinner').show();
          //antes de enviar la petición al fichero PHP, mostramos mensaje
          jQuery("#tabladato").html("Déjame pensar un poco...");
        },
        success: function (response, status, xhr){
          //window.location.href = "includes/pdf/contrato-general0.php?&id="+nrodnis+"&FecInicio="+fechainicioc+"&FecFin="+fechafinc+"&actualizacion="+basiconuevo;
          //window.location.href = "view/busquedaaumento-actualizado.php?&id="+nrodnis;
          window.location.href = "?c=empleado&a=ActualizacionDeContratosExitosa&id="+nrodnis;
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
