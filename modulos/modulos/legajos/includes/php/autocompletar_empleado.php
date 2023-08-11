 <?php
 		/*require_once '../../../../database/Conexion.php';
 		require_once '../../model/empleado.php';

    $empleado_autocompletar = new Empleado();*/
		$nrodocto = $_POST['val'];

    $data = array();

    $datosempleado = $this->model->EmpleadoAutocompletar($nrodocto);

    $data["empid"] = $datosempleado->legempleado_id;
    $data["empdni"] = $datosempleado->legempleado_nrodocto;
    $data["empcuil"] = $datosempleado->legempleado_nrocuil;
    $data["emplegajo"] = $datosempleado->legempleado_numerop;
    $data["empapellido"] = $datosempleado->legempleado_apellido;
    $data["empnombres"] = $datosempleado->legempleado_nombres;
    $data["empecivil"] = $datosempleado->estcivil_id;
    $data["empsexo"] = $datosempleado->sexo_id;
    $data["empfecnacto"] = $datosempleado->legempleado_fecnacto;
    $data["empfecingreso"] = $datosempleado->legempleado_fecingreso;
    $data["empactivo"] = $datosempleado->legempleado_activo;

 		echo json_encode($data);
 ?>
