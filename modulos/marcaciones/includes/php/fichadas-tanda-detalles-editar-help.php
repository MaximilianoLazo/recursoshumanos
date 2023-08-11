<?php
  if (isset($_POST['query'])){
  //if (isset($_GET['term'])){

    error_reporting(0);
    session_start();
    if(!isset($_SESSION['usuario_id'])){
      header('Location: ../login/index.php');
    }

    /*require_once '../../database/Conexion.php';

    require_once 'model/horasextras.php';

    $horasextras = new HorasExtras();*/

    //$search = $_GET['term'];
    $search = $_POST['query'];

    $data = array();

    $empleadodatos = $this->model->EmpleadoHelpObtener($search);

    foreach($empleadodatos as $row){
  		//$row_array['value'] = $row->legempleado_nrodocto." ".$row->legempleado_apellido.", ".$row->legempleado_nombres;
      $data1['Name'] = $row->legempleado_apellido.", ".$row->legempleado_nombres;
  		$data1['Id'] = $row->legempleado_nrodocto;
  		//$row_array['descripcion']=$row['nombre_producto'];
  		array_push($data,$data1);
    }
    echo json_encode($data);
  }
?>
