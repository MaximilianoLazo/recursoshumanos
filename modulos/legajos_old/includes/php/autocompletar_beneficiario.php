 <?php
 		require_once '../../../../database/Conexion.php';
 		require_once '../../model/empleado.php';

    $beneficiario_autocompletar = new Empleado();
		$nrodocto = $_POST['val'];

    $data = array();

    $datoshijo = $beneficiario_autocompletar->BeneficiarioAutocompletar($nrodocto);

    $data["hjobentdoc"] = $datoshijo->leghijo_bentdoc;
    $data["hjobenndoc"] = $datoshijo->leghijo_benndoc;
    $data["hjobenapellido"] = $datoshijo->leghijo_benapellido;
    $data["hjobennombres"] = $datoshijo->leghijo_bennombres;
    $data["hjonrooficio"] = $datoshijo->leghijo_bennoficio;



 		echo json_encode($data);
 ?>
