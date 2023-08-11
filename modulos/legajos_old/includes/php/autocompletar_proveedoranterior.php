<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

require_once '../../../../database/Conexion.php';
require_once '../../model/empleado.php';
$dcontratoanteriorproveedor = new Empleado();

$id = $_POST['Id'];
$dcontratoproveedorid = $dcontratoanteriorproveedor->ObtenerContratoProveedorId($id);

$data = array();


$data["profecinicio"] = $dcontratoproveedorid->legproveedor_fecinicio;
$data["profecfinal"] = $dcontratoproveedorid->legproveedor_fecfin;
$data["prosecretaria"] = $dcontratoproveedorid->secretaria_id;
$data["proltrabajo"] = $dcontratoproveedorid->trabajo_id;
$data["protarea"] = $dcontratoproveedorid->legproveedor_tarea;
$data["prosbasico"] = $dcontratoproveedorid->legproveedor_sbasico;

echo json_encode($data);



?>
