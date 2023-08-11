<?php
  $nrodocto = $_POST['Empndoc'];
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
                      data-empid="<?php echo ""; ?>"
                      data-empnrodocto="<?php echo $nrodocto; ?>"
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
                       data-empnrodocto="<?php echo $nrodocto; ?>"
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
                       data-empnrodocto="<?php echo $nrodocto; ?>"
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
    //-----Carrito vacio -----
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
                      data-empid="<?php echo ""; ?>"
                      data-empnrodocto="<?php echo $nrodocto; ?>"
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
