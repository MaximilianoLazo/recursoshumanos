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
  $situacionrevista = $_POST["CboSituacionRevista"];
  $orden = $_POST["RdoOrden"];
  foreach($orden as $ordenc){
    $ordenci = $ordenc;
  }
  $fechaingreso = $_POST["CboFecIngreso"];
  $fechainicionueva = $_POST["CboNuevaFecInicio"];
  $fechafinnueva = $_POST["CboNuevaFecFin"];
  $actualizacion = $_POST["CboActualizacion"];

?>


<?php
  if($situacionrevista == 1){
    //contratado
    ?>
    <div class="form-group">
      <div align="right">
        <button type="button" class="btn btn-danger" id="BtnImprimirContratos">Aplicar Actualizacion</button>
        <!--<button type="button" class="btn btn-info" id="BtnListarContratos">Imprimir Listado</button>-->
        <!--<a  class="btn btn-danger" href="?c=empleado&a=ActualizacionDeContratosExitosa&id=<?php echo $_POST['checkbox[]']; ?>&startIndex=0">Aplicar</a>-->
      </div>
    </div>
    <?php
    $contratos = $empleado->ListarContratosActualizacion($secretaria, $lugardetrabajo, $ordenci, $fechaingreso);
    $contratosc = count($contratos);

    ?>
    <div class="form-group">
      <label class="control-label"><?php echo "Cantidad de Contratados: ".$contratosc; ?></label>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div id="no-more-tables">
          <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table border="1" class="table table-striped table-hover table-fixed">
              <thead>
                <tr>
                  <th>Nro Documento</th>
                  <th>Apellido y Nombres</th>
                  <th>Lugar de Trabajo</th>
                  <th>Imputación</th>
                  <th>Fec Igreso</th>
                  <th>Fec Inicio</th>
                  <th>Fec Final</th>
                  <th>Tarea</th>
                  <th>S. Basico</th>
                  <th>S. Base</th>
                  <th>Actualizacion</th>
                  <th>
                    <div class="custom-control custom-checkbox mb-5">
                      <input type="checkbox" class="custom-control-input check-all" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1"></label>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach($contratos as $row):
                    $fechaingreso = date("d/m/Y", strtotime($row->legempleado_fecingreso));
                    $contratofeci = date("d/m/Y", strtotime($row->legcontrato_fecinicio));
                    $contratofecf = date("d/m/Y", strtotime($row->legcontrato_fecfin));
                    $fechainicionuevaformato = date("d/m/Y", strtotime($fechainicionueva));
                    $fechafinnuevaformato = date("d/m/Y", strtotime($fechafinnueva));

                    $sbasico = number_format($row->legcontrato_sbasico, 2, ',', '.');
                    $nrodocto = $row->legempleado_nrodocto;
                    //---- Importe Base ----
                    $sbasicobase = $empleado->ObtenerActualizacion($nrodocto);
                    $sbasicobasec = $sbasicobase->importe_basico_comfeb19;
                    if($sbasicobasec > 0){
                      $cantidad = $sbasicobase->importe_basico_comfeb19;
                    }else{
                      $cantidad = $row->legcontrato_sbasico;
                    }
                    $cantidadformato = number_format($cantidad, 2, ',', '.');
                    //--- Fin Importe Base ----
                    //--- Calculo nuevo importe ---
                    if($sbasicobasec > 0){
                      $porciento = $actualizacion;
                      $decimales = 2;
                      $sbasiconuevo = $empleado->Porcentaje($cantidad,$porciento,$decimales);
                      $sbasiconuevo2 = $row->legcontrato_sbasico + $sbasiconuevo;
                    }else{
                      $porciento = $actualizacion;
                      $decimales = 2;
                      //$cantidad = $row->legcontrato_sbasico;
                      $sbasiconuevo = $empleado->Porcentaje($cantidad,$porciento,$decimales);
                      $sbasiconuevo2 = $row->legcontrato_sbasico + $sbasiconuevo;
                    }
                    $sbasiconuevo3 = number_format($sbasiconuevo2, 2, ',', '.');
                    //--- fin calculo nuevo importe ---
                    $imputacionid = $row->imputacion_id;
                    $imputaciondatos = $empleado->ObtenerImputacion($imputacionid);
                ?>
                <tr>
                  <td data-title="DNI:"><?php echo $row->legempleado_nrodocto; ?></td>
                  <td data-title="Empleado:"><?php echo $row->legempleado_apellido.", <br>".$row->legempleado_nombres; ?></td>
                  <td data-title="L. Trabajo:"><?php echo $row->trabajo_nombre; ?></td>
                  <td data-title="Imputación:"><?php echo $imputaciondatos->imputacion_codigow; ?></td>
                  <td data-title="Fec Ingreso:"><?php echo $fechaingreso; ?></td>
                  <td data-title="Fec Inicio:"><?php echo "FV: ".$contratofeci."<br> FN: ".$fechainicionuevaformato; ?></td>
                  <td data-title="Fec Final:"><?php echo "FV: ".$contratofecf."<br> FN: ".$fechafinnuevaformato; ?></td>
                  <td data-title="Tarea:"><?php echo $row->legcontrato_tarea; ?></td>
                  <td align="right" data-title="S. Basico:"><?php echo "$ ".$sbasico; ?></td>
                  <td data-title="S. Base:"><?php echo "$ ".$cantidadformato; ?></td>
                  <td data-title="Actualizacion:"><?php echo "$ ".$sbasiconuevo3; ?></td>
                  <td align="center" data-title="Check:">
                    <div align="center" class="custom-control custom-checkbox mb-5">
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
  }elseif($situacionrevista == 4){
    //proveedor
    ?>
    <div class="form-group">
      <div align="right">
        <button type="button" class="btn btn-danger" id="btnapliactualizacionproveedores">Aplicar Actualizacion</button>
      </div>
    </div>
    <?php
    $contratos = $empleado->ListarProveedorActualizacion($secretaria, $lugardetrabajo, $ordenci, $fechaingreso);
    $contratosc = count($contratos);

    ?>
    <div class="form-group">
      <label class="control-label"><?php echo "Cantidad de Contratados: ".$contratosc; ?></label>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div id="no-more-tables">
          <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table border="1" class="table table-striped table-hover table-fixed">
              <thead>
                <tr>
                  <th>DNI</th>
                  <th>APELLIDO Y NOMBRES</th>
                  <th>LUGAR DE TRABAJO</th>
                  <th>FEC INGRESO</th>
                  <th>FEC INICIO</th>
                  <th>FEC FINAL</th>
                  <th>TAREA</th>
                  <th>S. BASICO</th>
                  <th>S. BASE</th>
                  <th>ACTUALIZACION</th>
                  <th>
                    <div class="custom-control custom-checkbox mb-5">
                      <input type="checkbox" class="custom-control-input check-all" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1"></label>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach($contratos as $row):
                    $fechaingreso = date("d/m/Y", strtotime($row->legempleado_fecingreso));
                    $contratofeci = date("d/m/Y", strtotime($row->legproveedor_fecinicio));
                    $contratofecf = date("d/m/Y", strtotime($row->legproveedor_fecfin));
                    $fechainicionuevaformato = date("d/m/Y", strtotime($fechainicionueva));
                    $fechafinnuevaformato = date("d/m/Y", strtotime($fechafinnueva));

                    $sbasico = number_format($row->legproveedor_sbasico, 2, ',', '.');
                    $nrodocto = $row->legempleado_nrodocto;
                    //---- Importe Base ----
                    $sbasicobase = $empleado->ObtenerActualizacionProveedor($nrodocto);
                    $sbasicobasec = $sbasicobase->sbasico_importe;
                    if($sbasicobasec > 0){
                      $cantidad = $sbasicobase->sbasico_importe;
                    }else{
                      $cantidad = $row->legproveedor_sbasico;
                    }
                    $cantidadformato = number_format($cantidad, 2, ',', '.');
                    //--- Fin Importe Base ----
                    //--- Calculo nuevo importe ---
                    if($sbasicobasec > 0){
                      $porciento = $actualizacion;
                      $decimales = 2;
                      $sbasiconuevo = $empleado->Porcentaje($cantidad,$porciento,$decimales);
                      $sbasiconuevo2 = $row->legproveedor_sbasico + $sbasiconuevo;
                    }else{
                      $porciento = $actualizacion;
                      $decimales = 2;
                      //$cantidad = $row->legcontrato_sbasico;
                      $sbasiconuevo = $empleado->Porcentaje($cantidad,$porciento,$decimales);
                      $sbasiconuevo2 = $row->legproveedor_sbasico + $sbasiconuevo;
                    }
                    $sbasiconuevo3 = number_format($sbasiconuevo2, 2, ',', '.');
                    //--- fin calculo nuevo importe ---
                ?>
                <tr>
                  <td data-title="DNI:"><?php echo $row->legempleado_nrodocto; ?></td>
                  <td data-title="Empleado:"><?php echo $row->legempleado_apellido.", <br>".$row->legempleado_nombres; ?></td>
                  <td data-title="L. Trabajo:"><?php echo $row->trabajo_nombre; ?></td>
                  <td data-title="Fec Ingreso:"><?php echo $fechaingreso; ?></td>
                  <td data-title="Fec Inicio:"><?php echo "FV: ".$contratofeci."<br> FN: ".$fechainicionuevaformato; ?></td>
                  <td data-title="Fec Final:"><?php echo "FV: ".$contratofecf."<br> FN: ".$fechafinnuevaformato; ?></td>
                  <td data-title="Tarea:"><?php echo $row->legproveedor_tarea; ?></td>
                  <td align="right" data-title="S. Basico:"><?php echo "$ ".$sbasico; ?></td>
                  <td data-title="S. Base:"><?php echo "$ ".$cantidadformato; ?></td>
                  <td data-title="Actualizacion:"><?php echo "$ ".$sbasiconuevo3; ?></td>
                  <td align="center" data-title="Check:">
                    <div align="center" class="custom-control custom-checkbox mb-5">
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
    //error
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
    jQuery("#btnapliactualizacionproveedores").click(function(){
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
        url: '?c=empleado&a=ActualizacionDeContratosProveedores',
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
          window.location.href = "?c=empleado&a=ActualizacionDeContratosProveedoresExitosa&id="+nrodnis;
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
