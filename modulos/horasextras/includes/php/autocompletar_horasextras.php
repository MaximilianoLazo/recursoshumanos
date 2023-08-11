 <?php
 		require_once '../../../../database/Conexion.php';
 		require_once '../../model/horasextras.php';

    $horasextras = new HorasExtras();
		$nrodocto = $_POST['val'];

    $data = array();

    $datoshorasextras = $horasextras->AutocompletarHorasExtras($nrodocto);

    $data["hsexsimples"] = $datoshorasextras->horasex_simples;
    $data["hsexdobles"] = $datoshorasextras->horasex_dobles;
    $data["hsjornales"] = $datoshorasextras->horas_jornales;
    $data["hsobservaciones"] = $datoshorasextras->horas_observaciones;

 		echo json_encode($data);
 ?>
