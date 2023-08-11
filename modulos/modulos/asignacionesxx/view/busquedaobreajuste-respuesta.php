<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}
//include("includes/modal/busquedaobreajustemodificar.php");
require_once '../../../database/Conexion.php';
require_once '../model/asignacion.php';

$asignacion = new Asignacion();

$nrodocto = $_POST["NroDoctoEmpBen"];
/*
$lugardetrabajo = $_POST["CboLugarDeTrabajo"];
$orden = $_POST["RdoOrden"];
foreach($orden as $ordenc){
  $ordenci = $ordenc;
}
$fechaingreso = $_POST["CboFecIngreso"];
$fechainicionueva = $_POST["CboNuevaFecInicio"];
$fechafinnueva = $_POST["CboNuevaFecFin"];
$actualizacion = $_POST["CboActualizacion"];
*/

?>
<div class="form-group">
  <div align="right">
    <!--<button type="button" class="btn btn-danger" id="BtnImprimirContratos">Aplicar Actualizacion</button>-->
    <!--<a  class="btn btn-danger" href="?c=asignacion&a=AplicarOBReajuste">Aplicar Reajuste</a>-->
  </div>
</div>
<?php
$periodo = $asignacion->ObtenerPeriodoActual();
$periodoid = $periodo->periodo_id;
$datosbeneficiario = $asignacion->DatosBeneficiarioReajuste($nrodocto,$periodoid);
$datosbeneficiarioc = count($datosbeneficiario);
//--- Preguntar si el calculo de importes esta echo
$importeobreajuste = $asignacion->ObtenerImporteOBReajuste($periodoid);
if($importeobreajuste->importeobr > 0){
  //--- Pregunta Nrodocto Tiene beneficiario
  if($datosbeneficiarioc > 0){
    //----Nrodocto tiene beneficiario
    ?>
    <div class="clearfix">
      <h5 class="text-blue"><?php echo "Beneficiario: ".$datosbeneficiario[0]->beneficiario_apellido.", ".$datosbeneficiario[0]->beneficiario_nombres; ?></h5>
      <p></p>
    </div>
    <table class="obbeneficiario">
      <thead>
        <tr>
          <th scope="col">Empleado</th>
          <th scope="col">Nro. Docto</th>
          <th scope="col">Hijo</th>
          <th scope="col">Nro. Docto</th>
          <th scope="col">Oficio</th>
          <th scope="col">Tipo de Asignacion</th>
          <th scope="col">CANT.</th>
          <th scope="col">IMP.</th>
          <th scope="col">Reajuste</th>
          <th scope="col">Observacones</th>
          <th width="18%" scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach($datosbeneficiario as $row):

        ?>
        <tr>
          <td><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
          <td><?php echo $row->legempleado_nrodocto; ?></td>
          <td>
            <?php
            $hijonombre = $row->leghijo_apellido.", ".$row->leghijo_nombres;
            //echo $row->leghijo_apellido.", ".$row->leghijo_nombres;
            if($hijonombre == ", "){
              echo "-";
            }else{
              echo $hijonombre;
            }
            ?>
          </td>
          <td>
            <?php
            if($row->leghijo_nrodocto == 0){
              echo "-";
            }else{
              echo $row->leghijo_nrodocto;
            }
            ?>
          </td>
          <td>
            <?php
            if($row->beneficiario_nrooficio == ""){
              echo "-";
            }else{
              echo $row->beneficiario_nrooficio;
            }
            ?>
          </td>
          <td>
            <?php
              $asignaciontipoid = $row->asigotro_tipo;
              $datotipoasignacion = $asignacion->ObtenerTipoAsignacion($asignaciontipoid);
              echo $datotipoasignacion->asigtipo_nombre;
            ?>
          </td>
          <td><?php echo $row->asigotro_cantidad; ?></td>
          <td>
            <?php
              $importemonedaob = number_format($row->asigotro_importe, 2, ',', '.');
              echo "$ ".$importemonedaob;
            ?>
          </td>
          <td>
            <?php
            $importemonedaobre = number_format($row->asigotro_reajuste, 2, ',', '.');
            echo "$ ".$importemonedaobre;
            ?>
          </td>
          <td><?php echo $row->asigotro_reajusteobs; ?></td>
          <td>
            <button type="button" class="btn btn-primary"
            data-toggle="modal"
            data-target="#dataUpdateReajuste"
            data-titulo="<?php echo "Reajuste: "; ?>"
            data-id="<?php echo $row->asigotro_id; ?>"
            data-ndocconsultado="<?php echo $nrodocto; ?>"
            data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
            data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
            data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
            data-asigobtipo="<?php echo $datotipoasignacion->asigtipo_nombre; ?>"
            data-asigobimporte="<?php echo $row->asigotro_importe; ?>"
            data-asigobreajuste="<?php echo $row->asigotro_reajuste; ?>"
            data-asigobimptotal="<?php echo $row->asigotro_imptotal; ?>"
            data-asigobreajusteobs="<?php echo $row->asigotro_reajusteobs; ?>">
            <i class="fa fa-calculator"></i> Reajustar </button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php
  }else{  //---Nrodocto no tiene beneficiario
    $datosempleado = $asignacion->DatosEmpleadoReajuste($nrodocto,$periodoid);
    $datosempleadoc = count($datosempleado);
    //--- Pregunta Nrodocto tiene empleado
    if($datosempleadoc > 0){
      //---Nrodocto tiene empleado
      ?>
      <div class="clearfix">
        <h5 class="text-blue"><?php echo "Empleado: ".$datosempleado[0]->legempleado_apellido.", ".$datosempleado[0]->legempleado_nombres; ?></h5>
        <p></p>
      </div>
      <table class="obbeneficiario">
        <thead>
          <tr>
            <th scope="col">Beneficiario</th>
            <th scope="col">Nro. Docto</th>
            <th scope="col">Hijo</th>
            <th scope="col">Nro. Docto</th>
            <th scope="col">Oficio</th>
            <th scope="col">Tipo de Asignacion</th>
            <th scope="col">CANT.</th>
            <th scope="col">IMP.</th>
            <th scope="col">Reajuste</th>
            <th scope="col">Observacones</th>
            <th width="18%" scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($datosempleado as $row):

          ?>
          <tr>
            <td><?php echo $row->beneficiario_apellido.", ".$row->beneficiario_nombres; ?></td>
            <td><?php echo $row->beneficiario_nrodocto; ?></td>
            <td>
              <?php
              $hijonombre = $row->leghijo_apellido.", ".$row->leghijo_nombres;
              //echo $row->leghijo_apellido.", ".$row->leghijo_nombres;
              if($hijonombre == ", "){
                echo "-";
              }else{
                echo $hijonombre;
              }
              ?>
            </td>
            <td>
              <?php
              if($row->leghijo_nrodocto == 0){
                echo "-";
              }else{
                echo $row->leghijo_nrodocto;
              }
              ?>
            </td>
            <td>
              <?php
              if($row->beneficiario_nrooficio == ""){
                echo "-";
              }else{
                echo $row->beneficiario_nrooficio;
              }
              ?>
            </td>
            <td>
              <?php
                $asignaciontipoid = $row->asigotro_tipo;
                $datotipoasignacion = $asignacion->ObtenerTipoAsignacion($asignaciontipoid);
                echo $datotipoasignacion->asigtipo_nombre;
              ?>
            </td>
            <td><?php echo $row->asigotro_cantidad; ?></td>
            <td>
              <?php
                $importemonedaob = number_format($row->asigotro_importe, 2, ',', '.');
                echo "$ ".$importemonedaob;
              ?>
            </td>
            <td>
              <?php
              $importemonedaobre = number_format($row->asigotro_reajuste, 2, ',', '.');
              echo "$ ".$importemonedaobre;
              ?>
            </td>
            <td><?php echo $row->asigotro_reajusteobs; ?></td>
            <td>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdateReajuste" data-id=""><i class="fa fa-calculator"></i> Reajustar </button>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php
    }else{
      //---Nrodocto No tiene empleado
    }
  }
}else{
  echo "El calculo de Importes no esta realizado";
}
?>

<script>
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
