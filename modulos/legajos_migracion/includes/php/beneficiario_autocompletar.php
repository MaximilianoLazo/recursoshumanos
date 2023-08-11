 <?php

		$nrodocto = $_POST['val'];
    $data = array();
    $empleadodatos = $this->model->EmpleadoAutocompletar($nrodocto);

    $data["hjobenid"] = $empleadodatos->legempleado_id;
    $data["hjobenapellido"] = $empleadodatos->legempleado_apellido;
    $data["hjobennombres"] = $empleadodatos->legempleado_nombres;
    
 		echo json_encode($data);
 ?>
