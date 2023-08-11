<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

require_once '../../../../database/Conexion.php';
require_once '../../model/empleado.php';
$datoscontratoant = new Empleado();

$id = $_POST['Id'];
$datoscontratoid = $datoscontratoant->ObtenerContratoId($id);

$data = array();

$data["legajotipo"] = $datoscontratoid->legtipo_id;
//$data["categoria"] = $datoscontratoid->legcontrato_categoria;
$data["fecinicio"] = $datoscontratoid->legcontrato_fecinicio;
$data["fecfinal"] = $datoscontratoid->legcontrato_fecfin;
$data["secretaria"] = $datoscontratoid->secretaria_id;
$data["imputacion"] = $datoscontratoid->imputacion_id;

$data["impdependencia"] = $datoscontratoid->impdependencia_id;

$data["tarea"] = $datoscontratoid->legcontrato_tarea;
$data["trabajo"] = $datoscontratoid->trabajo_id;
$data["sbasico"] = $datoscontratoid->legcontrato_sbasico;

echo json_encode($data);



?>
