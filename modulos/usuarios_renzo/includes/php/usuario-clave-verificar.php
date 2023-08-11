 <?php

  $usuario_id = $_POST['usrid'];
  $clave_actual = $_POST['claac'];

  $data = array();
  $usuario_datos = $this->model->UsuarioObtener_ID($usuario_id);

  $validaPassw = password_verify($clave_actual, $usuario_datos->usuario_password);

  if ($validaPassw) {
    //ok
    $data['respuesta'] = 1;
  } else {
    //$errors = "La contrase&ntilde;a es incorrecta";
    $data['respuesta'] = 0;
  }
  echo json_encode($data);
  /*$datosempleado = $this->model->EmpleadoAutocompletar($nrodocto);

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

 		echo json_encode($data);*/
  ?>
