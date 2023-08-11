<?php
  if (isset($_GET['term'])){

    error_reporting(0);
    session_start();
    if(!isset($_SESSION['usuario_id'])){
      header('Location: ../login/index.php');
    }

    require_once '../../database/Conexion.php';

    require_once 'model/marcacion.php';

    $marcacion = new Marcacion();

    $search = $_GET['term'];
    $return_arr = array();

    $empleadodatos = $marcacion->ObtenerEmpleadoDatos($search);

    foreach($empleadodatos as $row){
  		$row_array['value'] = $row->legempleado_nrodocto." ".$row->legempleado_apellido.", ".$row->legempleado_nombres;
  		$row_array['nrodocto'] = $row->legempleado_nrodocto;
  		//$row_array['descripcion']=$row['nombre_producto'];
  		array_push($return_arr,$row_array);
    }
    echo json_encode($return_arr);

  }
?>
