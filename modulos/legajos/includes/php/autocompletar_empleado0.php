 <?php
 		require_once '../../../../database/Conexion.php';
 		require_once '../../model/empleado.php';

    $empleado_autocompletar = new Empleado();
		$nrodocto = $_POST['val'];

    $data = array();

    $datosempleado = $empleado_autocompletar->EmpleadoAutocompletar($nrodocto);

    $data["empid"] = $datosempleado->legempleado_id;
    $data["empdni"] = $datosempleado->legempleado_nrodocto;
    $data["empcuil"] = $datosempleado->legempleado_nrocuil;
    $data["emplegajov"] = $datosempleado->legempleado_numerov;
    $data["empapellido"] = $datosempleado->legempleado_apellido;
    $data["empnombres"] = $datosempleado->legempleado_nombres;
    $data["empecivil"] = $datosempleado->estcivil_id;
    $data["empsexo"] = $datosempleado->sexo_id;
    $data["empfecnacto"] = $datosempleado->legempleado_fecnacto;
    $data["empfecingreso"] = $datosempleado->legempleado_fecingreso;
  /*$data["hjoapellido"] = $datoshijo->leghijo_apellido;
    $data["hjonombres"] = $datoshijo->leghijo_nombres;
    $data["hjocuil"] = $datoshijo->leghijo_nrocuil;
    $data["hjosexo"] = $datoshijo->sexo_id;
    $data["hjodireccion"] = $datoshijo->leghijo_direccion;
    $data["hjodirecnro"] = $datoshijo->leghijo_direcnro;
    $data["hjodirepiso"] = $datoshijo->leghijo_direcpiso;
    $data["hjodireccpostal"] = $datoshijo->leghijo_codpostal;
    $data["hjofecnacto"] = $datoshijo->leghijo_fecnacto;
    $data["hjoescuela"] = $datoshijo->escuela_id;
    $data["hjoescnvl"] = $datoshijo->escnivel_id;
    $data["hjoescest"] = $datoshijo->escestado_id;
    $data["hjomoptdoc"] = $datoshijo->leghijo_moptdoc;
    $data["hjomopndoc"] = $datoshijo->leghijo_mopndoc;
    $data["hjomopapellido"] = $datoshijo->leghijo_mopapellido;
    $data["hjomopnombres"] = $datoshijo->leghijo_mopnombres;
    $data["hjobentdoc"] = $datoshijo->leghijo_bentdoc;
    $data["hjobenndoc"] = $datoshijo->leghijo_benndoc;
    $data["hjobenapellido"] = $datoshijo->leghijo_benapellido;
    $data["hjobennombres"] = $datoshijo->leghijo_bennombres;
    $data["hjonrooficio"] = $datoshijo->leghijo_bennoficio;
    $data["hjoppdl"] = $datoshijo->pais_id."-".$datoshijo->provincia_id."-".$datoshijo->departamento_id."-".$datoshijo->localidad_id;
    $data["hjopais"] = $datoshijo->pais_id;
    $data["hjoprovincia"] = $datoshijo->provincia_id;
    $data["hjodepartamento"] = $datoshijo->departamento_id;
    $data["hjolocalidad"] = $datoshijo->localidad_id;

    $data["hjoescuelacheck"] = $datoshijo->leghijo_esc;
    $data["hjodisccheck"] = $datoshijo->leghijo_disc;*/


 		echo json_encode($data);
 ?>
