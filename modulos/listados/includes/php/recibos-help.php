<?php
  if (isset($_GET['term'])){

    error_reporting(0);
    session_start();
    if(!isset($_SESSION['usuario_id'])){
      header('Location: ../login/index.php');
    }

    $search = $_GET['term'];
    $return_arr = array();

    $empleadodatos = $this->model->ObtenerReciboEmpleado($search);

    foreach($empleadodatos as $row){
  		$row_array['value'] = $row->legempleado_nrodocto." ".$row->legempleado_apellido.", ".$row->legempleado_nombres;
  		$row_array['nrodocto'] = $row->legempleado_nrodocto;
  		//$row_array['descripcion']=$row['nombre_producto'];
  		array_push($return_arr,$row_array);
    }
    echo json_encode($return_arr);

  }
?>
