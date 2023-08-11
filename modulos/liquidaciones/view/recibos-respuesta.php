<?php

  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    //header('Location: ../login/index.php');
    //echo '<meta http-equiv="refresh" content="0;URL=ordenmensajealta.php?id='.$numeroorden.'">';
    echo '<meta http-equiv="refresh" content="0;URL=../login/index.php">';
  }
  //require_once '../../../database/Conexion.php';
  //require_once '../model/listado.php';

  $nrodocto = $_POST["dni"];

  date_default_timezone_set("America/Buenos_Aires");
  $fecha_actual = date("Y-m-d");
  $hora_actual = date("H:i:s");
  $fecha_inicio = date("Y-01-01");

  $recibosdatos_emp= $this->model->JubiladoObtenerDoc($nrodocto);
  $recibosdatos= $this->model->ListarRecibosTodos($recibosdatos_emp->legajo_id);
  $cantidadrecibos=count($recibosdatos);

?>
<div class="col-md-12">
  <div class="row">
      <div class="form-group">
        <div align="left">
          <h5 class="text-blue"><?php echo "Empleado: ".$recibosdatos_emp->legajo_apellido.", ".$recibosdatos_emp->legajo_nombres; ?></h5>
        </div>
      </div>
  </div>
</div>

<div class="col-md-12">
<fieldset>
    <div class="col-md-12">
      <div class="row">
        <div id="no-more-tables">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table class="data-table table-bordered stripe hover nowrap">
  						<thead>
  						<tr>
  							<th>PERIODO</th>
              	<th>NOMBRE</th>
                <th></th>
  						</tr>
  						</thead>
  						<tbody>
                <?php
                  if($cantidadrecibos!=0){?>
                    <?php
                    foreach($recibosdatos as $row):  ?>
                        <tr>
                          <td><?php echo $row->periodo_nombre ; ?></td>
                          <td><?php echo $row->periodo_hsext_jor_i;?></td>
                          <td><button type="button"
          										class="btn btn-warning"
          										data-toggle="modal"
          										data-target="#dataTableViewReciboxmes"
          										data-titulo="Editar Recibo"
          										data-id="<?php echo $row->legajo_id;?>"
                              data-perio="<?php echo $row->periodo_id;?>">
          										<i class="icon-copy fa fa-list" aria-hidden="true"></i>
          									</button></td>
                  <?php endforeach;?>

               <?php } ?>
  						</tbody>
  						</table>
            </div>
          </div>
        </div>
    </div>
  </fieldset>
</div>
<script src="includes/js/liquidacion.js"></script>
