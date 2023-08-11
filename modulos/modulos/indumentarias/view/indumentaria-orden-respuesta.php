<?php
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    echo '<meta http-equiv="refresh" content="0;URL=../login/index.php">';
  }

  $ndocnord = $_POST["NroDocto"];

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

  $empleadodatos = $this->model->EmpleadoObtener($ndocnord);
  //$empleadodatosc = count($empleadodatos);
  $ordendatos = $this->model->OrdenPendienteObtener($ndocnord);
  $ordendatosc = count($ordendatos);
  //if($empleadodatosc > 0){
    // Se evalúa a true ya que $var está vacia
  if(!empty($empleadodatos)) {
    //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
    //---- si existe el empleado, Buscar Orden
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
      </div>
    </div>
    <br>
    <?php
  }elseif($ordendatosc > 0){
    //----Existe orden, buscar empleado
    $empleadodatos = $this->model->EmpleadoObtener($ordendatos[0]->legempleado_nrodocto);
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
      </div>
    </div>

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <div class="clearfix">
              <div align="left">
                <div class="alert alert-success" role="alert">
                  <?php echo "Numero de Orden: ".$ordendatos[0]->indumentaria_orden_id; ?>
                  <!--<i class="fa fa-exclamation" aria-hidden="true"></i>-->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <div class="clearfix">
              <div align="right">
                <?php
                if($ordendatos[0]->indumentaria_entrega_estado == 2){
                  //----la orden no esta entregada
                  ?>
                  <a class="btn btn-success"
                     href="../indumentarias/?c=indumentaria&a=IndumentariaEntregar&id=<?php echo $ordendatos[0]->indumentaria_orden_id; ?>">
                     <i class="fa fa-check-circle fa-lg" aria-hidden="true">

                     </i>
                     ENTREGAR Orden
                   </a>
                  <?php
                }else{
                  //----La orden ya fue entregada
                  ?>
                  <div class="form-group">
                    <div class="clearfix">
                      <div align="right">
                        <div class="alert alert-danger" role="alert">
                          Este numero de orden está entregado.
                          <!--<i class="fa fa-exclamation" aria-hidden="true"></i>-->
                          <i class="icon-copy fi-info fa-lg"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

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
                <th width="8%" style="font-size: 10px; text-align: right">ESTADO</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($ordendatos as $row): ?>
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
                  <?php echo $row->indumentaria_entrega_estado; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <br>
    <?php
  }else{
    //----- No existe empleado, ni orden
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
  }
  ?>
  <script>
    jQuery(document).ready(function(){
      jQuery('#btnindumentariaentregar').on('click', function(){
        //cogemos el valor del input
        var ordenid = <?php echo $ordendatos[0]->indumentaria_orden_id; ?>;
        var params = {
          "OrdenId" : ordenid
        };
        //llamada al fichero PHP con AJAX
        $.ajax({
          data:  params,
          url: '?c=indumentaria&a=IndumentariaEntregar',
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
      });
    });

  </script>
