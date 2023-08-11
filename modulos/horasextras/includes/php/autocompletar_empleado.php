 <?php
 		require_once '../../../../database/Conexion.php';
 		require_once '../../model/horasextras.php';

    $empleado = new HorasExtras();
		$nrodocto = $_POST['val'];

    $data = array();

    $datosempleado = $empleado->AutocompletarEmpleado($nrodocto);

    $data["hsexempleado"] = $datosempleado->legempleado_apellido.", ".$datosempleado->legempleado_nombres;
    $data["hsexltrabajoid"] = $datosempleado->trabajo_id;
    $data["hsexltrabajonombre"] = $datosempleado->trabajo_nombre;
    $data["hddhsexltrabajonombre"] = $datosempleado->trabajo_nombre;

 		echo json_encode($data);
 ?>
