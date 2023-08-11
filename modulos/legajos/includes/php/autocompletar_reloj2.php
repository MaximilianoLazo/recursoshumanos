 <?php
 		require_once '../../../../database/Conexion.php';
 		require_once '../../model/empleado.php';

    $reloj = new Empleado();
		$relojid = $_POST['val'];

    $data = array();

    $datosreloj = $reloj->AutocompletarReloj2($relojid);

    $data["emprelip"] = $datosreloj->reloj_ip;
    $data["emprelnodo"] = $datosreloj->reloj_nodo;
    $data["empreltipo"] = $datosreloj->relojtipo_nombre;


 		echo json_encode($data);
 ?>
