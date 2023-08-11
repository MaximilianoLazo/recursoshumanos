
<?php

  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    header('Location: ../login/index.php');
  }
  require_once '../../../database/Conexion.php';
  require_once '../model/marcacion.php';

  $marcacion = new Marcacion();

?>

<?php

  $nrodocto = $_POST["NroDocto"];
  $historicodi = $_POST["HistoricoDI"];
  $historicodf = $_POST["HistoricoDF"];

  $datosempleado = $marcacion->EmpleadoObtener($nrodocto);

?>
  <div class="row">
    <div class="col-md-12">
      <div class="clearfix">
        <h5 class="text-blue"><?php echo "Empleado: ".$datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres; ?></h5>
      </div>
    </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-md-12">
      <div id="no-more-tables">
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table border="1" class="table table-striped table-hover table-fixed">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Reloj</th>
                <th>Direccion</th>
                <th>Fuente</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($marcacion->ObtenerHistorico($nrodocto, $historicodi, $historicodf) as $row):
              $fecdmy = date("d/m/Y", strtotime($row->fecha));
              ?>
              <tr>
                <td data-title="Fecha:"><?php echo $fecdmy; ?></td>
                <td data-title="Hora:"><?php echo $row->hora; ?></td>
                <td data-title="Reloj:"><?php echo $row->reloj_nombre; ?></td>
                <td data-title="Direccion:"><?php echo $row->mdireccion_descripcion; ?></td>
                <td data-title="Fuente:"><?php echo $row->mfuente_descripcion; ?></td>
                <td data-title="Estado:"><?php echo $row->mestado_nombre; ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
