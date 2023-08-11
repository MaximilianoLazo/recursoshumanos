<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

require_once '../../../../database/Conexion.php';
require_once '../../model/imputacion.php';
$imputacion = new Imputacion();

$imputacionid = $_POST['imputacionid'];
$search = $_POST['search'];
$empleadosximputacion = $imputacion->BuscarEmpleadosXImputaciones($imputacionid, $search);

?>
<div class="row">
  <div class="col-md-12">
    <div id="no-more-tables">
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-striped table-hover table-fixed">
          <thead>
            <tr>
              <th style="font-size: 12px;">N&deg; de Legajo</th>
              <th style="font-size: 12px;">DNI</th>
              <th style="font-size: 12px;">Apellido y Nombres</th>
              <th style="font-size: 12px;">Categoria</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach($empleadosximputacion as $row):
          ?>
            <tr>
              <td style="font-size: 12px;" data-title="N&deg; de Legajo:"><?php echo $row->legempleado_numero; ?></td>
              <td style="font-size: 12px;" data-title="Categoria:"><?php echo $row->legempleado_nrodocto; ?></td>
              <td style="font-size: 12px;" data-title="Empleado:"><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
              <td style="font-size: 12px;" data-title="Categoria:"><?php echo $row->legtipo_nombre; ?></td>
            </tr>
          <?php endforeach; ?>
         </tbody>
       </table>
     </div>
   </div>
  </div>
</div>
