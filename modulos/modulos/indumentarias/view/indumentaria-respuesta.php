<?php
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    echo '<meta http-equiv="refresh" content="0;URL=../login/index.php">';
  }

  $nrodocto = $_POST["NroDocto"];

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

  $empleadodatos = $this->model->EmpleadoObtener($nrodocto);
  if($empleadodatos->legtipo_id == 1){
    $situacionrevista = "Contratado";
  }elseif($empleadodatos->legtipo_id == 2){
    $situacionrevista = "Jornalero";
  }elseif($empleadodatos->legtipo_id == 3){
    $situacionrevista = "Planta Permanente";
  }elseif($empleadodatos->legtipo_id == 4){
    $situacionrevista = "Proveedor";
  }else{
    $situacionrevista = "?";
  }
  if($empleadodatos->legempleado_nrodocto > 0){
    //-----La variable existe, seguir con los datos
    ?>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <label class="font-14"><?php echo "Empleado: ".$situacionrevista; ?></label>
          <h4 class="text-blue">
            <?php echo $empleadodatos->legempleado_apellido.", ".$empleadodatos->legempleado_nombres ?>
            <!--<i class="ion-help-circled fa-lg"></i>-->
            <a href="#"
               data-toggle="modal"
               data-target="#IndumentariaCarroEditar"
               data-titulo="<?php echo "EDITAR Item"; ?>">
               <span style="color: #0099FF;">
                 <i class="ion-help-circled fa-lg"></i>
               </span>
            </a>
          </h4>
          <br>
        </div>
        <div class="col-md-6">

        </div>
      </div>
    </div>
    <br>
    <div class="col-md-6">
      <div id="tblindumentariacarro">
      <?php
      $datoscarritopendiente = $this->model->IndumentariaCarritoPendiente($nrodocto, $indordenultimoid);
      $datoscarritopendientec = count($datoscarritopendiente);
      if($datoscarritopendientec > 0){
        //----El carrito tiene productos ----
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="clearfix">
                <div align="right">
                  <!--
                  <a href="?c=indumentaria&a=IndumentariaEntregaGuardar&id=<?php //echo $datoscarritopendiente[0]->indumentaria_orden_id; ?>"
                    class="btn btn-primary">
                    <i class="ion-android-checkmark-circle fa-lg"></i>&nbsp;ENTREGAR Indumentaria
                  </a>
                  -->
                  <button type="button"
                          class="btn btn-primary"
                          data-toggle="modal"
                          data-target="#IndumentariaCarroCerrar"
                          data-titulo="CERRAR ORDEN"
                          data-indordenid="<?php echo $datoscarritopendiente[0]->indumentaria_orden_id; ?>">
                          <span class="ion-android-checkmark-circle fa-lg"></span>&nbsp;CERRAR Orden
                  </button>
                  <button type="button"
                          class="btn btn-success"
                          data-toggle="modal"
                          data-target="#IndumentariaCarroEditar"
                          data-titulo="AGREGAR Indumentaria"
                          data-empid="<?php echo $empleadodatos->legempleado_id; ?>"
                          data-empnrodocto="<?php echo $empleadodatos->legempleado_nrodocto; ?>"
                          data-indentregaid="<?php echo ""; ?>"
                          data-indumentaria="<?php echo ""; ?>"
                          data-indtalle="<?php echo ""; ?>"
                          data-indcolor="<?php echo ""; ?>"
                          data-indcantidad="<?php echo ""; ?>"
                          data-indobs="<?php echo ""; ?>">
                          <span class="ti-shopping-cart fa-lg"></span>&nbsp;AGREGAR Producto
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div id="no-more-tables">
              <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table table-striped table-hover table-fixed">
                  <thead>
                    <tr>
                      <th width="4%" style="font-size: 10px; text-align: center;">CANT.</th>
                      <th width="30%" style="font-size: 10px;">INDUMENTARIA</th>
                      <th width="4%" style="font-size: 10px; text-align: center;">TALLE</th>
                      <th width="14%" style="font-size: 10px;">COLOR</th>
                      <th width="40%"style="font-size: 10px;">OBSERVACION</th>
                      <th width="8%" style="font-size: 10px; text-align: right">OPCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($datoscarritopendiente as $row): ?>
                    <tr>
                      <td style="font-size: 10px; text-align: right" data-title="Licencia:">
                        <?php echo $row->indumentaria_entrega_cantidad; ?>
                      </td>
                      <td style="font-size: 10px; text-align: left;" data-title="Dias:">
                        <?php echo $row->indumentaria_nombre; ?>
                      </td>
                      <td style="font-size: 10px; text-align: center;" data-title="Dias:">
                        <?php echo $row->indumentaria_talle_nombre; ?>
                      </td>
                      <td style="font-size: 10px; text-align: left" data-title="Licencia:">
                        <?php echo $row->indumentaria_color_nombre; ?>
                      </td>
                      <td style="font-size: 10px; text-align: left;" data-title="Dias:">
                        <?php echo $row->indumentaria_entrega_observacion; ?>
                      </td>
                      <td style="font-size: 12px; text-align: right;" data-title="Dias:">
                        <a href="#"
                           data-toggle="modal"
                           data-target="#IndumentariaCarroEditar"
                           data-titulo="<?php echo "EDITAR Item"; ?>"
                           data-empid="<?php echo ""; ?>"
                           data-empnrodocto="<?php echo $empleadodatos->legempleado_nrodocto; ?>"
                           data-indentregaid="<?php echo $row->indumentaria_entrega_id; ?>"
                           data-indumentaria="<?php echo $row->indumentaria_id; ?>"
                           data-indtalle="<?php echo $row->indumentaria_talle_id; ?>"
                           data-indcolor="<?php echo $row->indumentaria_color_id; ?>"
                           data-indcantidad="<?php echo $row->indumentaria_entrega_cantidad; ?>"
                           data-indobs="<?php echo $row->indumentaria_entrega_observacion; ?>">
                           <span style="font-size: 15px; color: #3b83bd;">
                             <i class="ion-android-create"></i>
                           </span>
                        </a>
                        &nbsp;
                        &nbsp;
                        <a href="#"
                           data-toggle="modal"
                           data-target="#IndumentariaCarroBaja"
                           data-titulo="<?php echo "QUITAR Item"; ?>"
                           data-empnrodocto="<?php echo $empleadodatos->legempleado_nrodocto; ?>"
                           data-indentregaid="<?php echo $row->indumentaria_entrega_id; ?>">
                           <span style="font-size: 15px; color: #e61919;">
                             <i class="ion-android-close"></i>
                           </span>
                        </a>
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
        //----El carrito no tiene productos ----
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="clearfix">
                <div align="right">
                  <button type="button"
                          class="btn btn-success"
                          data-toggle="modal"
                          data-target="#IndumentariaCarroEditar"
                          data-titulo="AGREGAR Indumentaria"
                          data-empid="<?php echo $empleadodatos->legempleado_id; ?>"
                          data-empnrodocto="<?php echo $empleadodatos->legempleado_nrodocto; ?>"
                          data-indumentaria="<?php echo ""; ?>"
                          data-indtalle="<?php echo ""; ?>"
                          data-indcolor="<?php echo ""; ?>"
                          data-indcantidad="<?php echo ""; ?>"
                          data-indobs="<?php echo ""; ?>">
                          <span class="ti-shopping-cart fa-lg"></span>&nbsp;AGREGAR Producto
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="clearfix">
                <div align="right">
                  <div class="alert alert-info" role="alert">
                    No tienes artículos en el carro de indumentarias.
                    <!--<i class="fa fa-exclamation" aria-hidden="true"></i>-->
                    <i class="icon-copy fi-info fa-lg"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="clearfix">
              <div align="right">
                <button type="button" class="btn btn-danger" id="btnindumentariaimprimir">
                  <!--<span class="ti-printer fa-lg"></span>-->
                  <i class="fi-print fa-lg"></i>
                  &nbsp;IMPRIMIR Listado
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4">
              <label for="cboindumentariatipofil" style="font-size: 13px;">Tipo de Indumentaria :</label>
              <select name="cboindumentariatipofil" style="font-size: 12px;" id="cboindumentariatipofil" class="custom-select form-control" required>
                <option value="0">--Todas--</option>
                <?php foreach($this->model->IndumentariaListar() as $row): ?>
                <option value="<?php echo $row->indumentaria_id; ?>"><?php echo $row->indumentaria_nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="txtindumentariafeciniciofil" style="font-size: 13px;">Fecha Inicio :</label>
                <input type="date" style="font-size: 12px;" name="txtindumentariafeciniciofil" id="txtindumentariafeciniciofil" value="<?php echo $fecha_inicio; ?>" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="txtindumentariafecfinfil" style="font-size: 13px;">Fecha Fin :</label>
                <input type="date" style="font-size: 12px;" name="txtindumentariafecfinfil" id="txtindumentariafecfinfil" value="<?php echo $fecha_actual; ?>" class="form-control" required>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="tblindumentariaentregada">
      <?php
      $datetime = new DateTime();
      $fecha_actual = $datetime->format('Y-m-d');
      $fecha_inicio = $datetime->format('Y-01-01');
      $indentregadasdatos = $this->model->IndumentariasEntregasListar($nrodocto, $fecha_inicio, $fecha_actual);
      $indentregadasdatosc = count($indentregadasdatos);
      if($indentregadasdatosc > 0){
        //--hay indumentarias entregadas
        ?>
        <div class="row">
          <div class="col-md-12">
            <div id="no-more-tables">
              <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table table-striped table-hover table-fixed">
                  <thead>
                    <tr>
                      <th width="6%" style="font-size: 10px;">FECHA</th>
                      <th width="4%" style="font-size: 10px;">ORDEN</th>
                      <th width="4%" style="font-size: 10px;">CANT.</th>
                      <th width="25%" style="font-size: 10px;">INDUMENTARIA</th>
                      <th width="6%" style="font-size: 10px; text-align: center;">TALLE</th>
                      <th width="15%" style="font-size: 10px;">COLOR</th>
                      <th width="30%" style="font-size: 10px;">OBSERVACION</th>
                      <th width="10%" style="font-size: 10px;">ESTADO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      /*$datetime = new DateTime();
                      $fecha_actual = $datetime->format('Y-m-d');
                      $fecha_inicio = $datetime->format('Y-01-01');*/

                      foreach($indentregadasdatos as $row):
                        $indumentariaentfec = new DateTime($row->indumentaria_entrega_fecha);
                        $indumentaria_fec_pantalla = $indumentariaentfec->format('d/m/Y')
                    ?>
                    <tr>
                      <td style="font-size: 10px;" data-title="Dias:">
                        <?php echo $indumentaria_fec_pantalla; ?>
                      </td>
                      <td style="font-size: 10px; text-align: right;" data-title="Licencia:">
                        <?php echo $row->indumentaria_orden_id; ?>
                      </td>
                      <td style="font-size: 10px; text-align: right;" data-title="Licencia:">
                        <?php echo $row->indumentaria_entrega_cantidad; ?>
                      </td>
                      <td style="font-size: 10px;" data-title="Dias:">
                        <?php echo $row->indumentaria_nombre; ?>
                      </td>
                      <td style="font-size: 10px; text-align: center;" data-title="Licencia:">
                        <?php echo $row->indumentaria_talle_nombre; ?>
                      </td>
                      <td style="font-size: 10px;" data-title="Dias:">
                        <?php echo $row->indumentaria_color_nombre; ?>
                      </td>
                      <td style="font-size: 10px;" data-title="Dias:">
                        <?php echo $row->indumentaria_entrega_observacion; ?>
                      </td>
                      <td style="font-size: 10px;" data-title="Dias:">
                        <?php echo $row->indumentaria_entrega_estado; ?>
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
        //---No hay indumentarias entregadas
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="clearfix">
                <div align="right">
                  <div class="alert alert-danger" role="alert">
                    No hay datos para mostrar.
                    <!--<i class="fa fa-exclamation" aria-hidden="true"></i>-->
                    <i class="icon-copy fi-info fa-lg"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
      </div>
    </div>
    <script>
      jQuery(document).ready(function(){
        //--- resultado en vivo de marcaciones ---------
        //$('#price, #tax').on('keyup change paste', function() {
        //jQuery('#cboindumentariatipofil, #txtindumentariafeciniciofil, #txtindumentariafecfinfil').change(function(){
        //jQuery('#cboindumentariatipofil, #txtindumentariafeciniciofil, #txtindumentariafecfinfil').on('change', function prueba(){
        jQuery('#cboindumentariatipofil, #txtindumentariafeciniciofil, #txtindumentariafecfinfil').on('change', function(){
          //cogemos el valor del input
          var nrodocto = <?php echo $nrodocto; ?>;
          var indumentariatipo = jQuery("#cboindumentariatipofil").val();
          var indumentariafeci = jQuery("#txtindumentariafeciniciofil").val();
          var indumentariafecf = jQuery("#txtindumentariafecfinfil").val();
          var params = {
            "NroDocto" : nrodocto,
            "IndumentariaTipo" : indumentariatipo,
            "IndumentariaFecI" : indumentariafeci,
            "IndumentariaFecF" : indumentariafecf
          };
          //llamada al fichero PHP con AJAX
          $.ajax({
            data:  params,
            url: '?c=indumentaria&a=IndumentariaEntregada',
            dataType: 'html',
            type:  'post',
            beforeSend: function () {
              //mostramos gif "cargando"
              //jQuery('#loading_spinner').show();
              //antes de enviar la petición al fichero PHP, mostramos mensaje
              jQuery("#tblindumentariaentregada").html("Déjame pensar un poco...");
            },
            success:  function (response) {
              jQuery("#tblindumentariaentregada").html(response);
            }
          });
          //yield sleep(2000);
        });
        //setInterval(pruebatiempo, 3000);
      });
      //--------Descarga de PDF------
      jQuery("#btnindumentariaimprimir").click(function(){
        //--------Obtenemos el valor del input
        var nrodocto = <?php echo $nrodocto; ?>;
        var indumentariatipo = jQuery("#cboindumentariatipofil").val();
        var indumentariafeci = jQuery("#txtindumentariafeciniciofil").val();
        var indumentariafecf = jQuery("#txtindumentariafecfinfil").val();
        var params = {
          "NroDocto" : nrodocto,
          "IndumentariaTipo" : indumentariatipo,
          "IndumentariaFecI" : indumentariafeci,
          "IndumentariaFecF" : indumentariafecf
        };
        //--------llamada al fichero PHP con AJAX
        $.ajax({
          cache: false,
          type: 'POST',
          //dataType:"html",
          url: '?c=indumentaria&a=IndumentariaEntregaListadoEmp',
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
    </script>

    <?php
  }else{
    //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
    ?>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-danger">
            <br>
            <i class="fa fa-times-circle-o fa-lg"></i>&nbsp;<label style="font-size: 20px;"><?php echo "Datos no encontrados..."; ?></label>
          </h5>
        </div>
      </div>
    </div>
    <br><br><br><br>
    <?php
    //echo "estoy aqui";
  }
?>
