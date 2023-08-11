 <?php
 		require_once '../../../../database/Conexion.php';
 		require_once '../../model/empleado.php';

    $mop_autocompletar = new Empleado();
		$nrodocto = $_POST['val'];

    $data = array();

    $datoshijo = $mop_autocompletar->MoPAutocompletar($nrodocto);

    $data["hjomoptdoc"] = $datoshijo->leghijo_moptdoc;
    //$data["hjomopndoc"] = $datoshijo->leghijo_mopndoc;
    $data["hjomopapellido"] = $datoshijo->leghijo_mopapellido;
    $data["hjomopnombres"] = $datoshijo->leghijo_mopnombres;

 		echo json_encode($data);
 ?>
