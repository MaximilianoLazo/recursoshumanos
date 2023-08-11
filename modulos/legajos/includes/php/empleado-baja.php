<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

//require_once '../../../../database/Conexion.php';
//require_once '../../model/imputacion.php';
//$imputacion = new Imputacion();

$id = $_POST['Id'];
//$empleadosximputacion = $imputacion->ObtenerEmpleadosXImputaciones($id);
?>
<div class="row">
  <div class="col-xs-12 col-sm-12">
    <div class="form-group">
      <div class="custom-control custom-checkbox mb-5">
        <input type="checkbox" class="custom-control-input" id="datosant" style="font-size: 35px;">
        <label class="custom-control-label" for="datosant" style="font-size: 14px;">Dar de baja Contrato</label>
      </div>
    </div>
    <div class="form-group">
      <div class="custom-control custom-checkbox mb-5">
        <input type="checkbox" class="custom-control-input" id="datosant" style="font-size: 35px;">
        <label class="custom-control-label" for="datosant" style="font-size: 14px;">Liquidar Asignaciones</label>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12">
    <div class="form-group">
      <div class="custom-control custom-checkbox mb-5">
        <input type="checkbox" class="custom-control-input" id="datosant" style="font-size: 35px;">
        <label class="custom-control-label" for="datosant" style="font-size: 14px;">Liquidar Adicionales</label>
      </div>
    </div>
  </div>
</div>
