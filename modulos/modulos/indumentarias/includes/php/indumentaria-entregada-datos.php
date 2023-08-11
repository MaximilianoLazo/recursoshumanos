<?php
  $nrodocto = $_POST['NroDocto'];
  $indumentariatipo = $_POST['IndumentariaTipo'];
  $indumentariafeci = $_POST['IndumentariaFecI'];
  $indumentariafecf = $_POST['IndumentariaFecF'];

  if($indumentariatipo > 0){
    //---Filtrar tipo de indumentaria
    $indentregadasdatos = $this->model->IndumentariasEntregasListarFil($indumentariatipo, $nrodocto, $indumentariafeci, $indumentariafecf);
  }else{
    //---Sin filtro
    $indentregadasdatos = $this->model->IndumentariasEntregasListar($nrodocto, $indumentariafeci, $indumentariafecf);
  }

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
                  <th width="40%" style="font-size: 10px;">OBSERVACION</th>
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
