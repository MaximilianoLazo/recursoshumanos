<?php
/*
$dia = "2018-08-23 09:23:06";
$diamuestra = strftime("%w", strtotime("$dia"));

echo "$diamuestra";
*/
?>
<?php
	/*
	include_once '../database/Conexion.php';




		$cn = Conexion::getInstance();
		$db = $cn->getConnection();
    /*
    $sqlconsulta = "SELECT * FROM ordenes_pro a, destinos b WHERE a.destino_id=b.destino_id AND a.destino_actual=:desactual AND a.estado_id<:estado ORDER BY a.ordenpro_numero";
    $resultado = $db->prepare($sqlconsulta);
    $parametro = array("desactual"=>$_SESSION['usuario_destino'], "estado"=>3);
    $resultado->execute($parametro);
    */
		/*
    $marcacionaccesid = 36583053;
    $marcaciondatetime = "10";
    $diferencia = "00:55:00";
		$diferencia2 = "-00:55:00";
		$hoy = "2018-08-28";


    $sql = 'SELECT * FROM legajos_reloj WHERE marcacion_accessid = ? AND legreloj_domingo = 1 AND TIMESTAMPDIFF(MINUTE,legreloj_domingohe,"$marcaciondatetime") < 50 AND legreloj_activo = 1';

		/*
    $sql = 'SELECT * FROM legajos_reloj WHERE marcacion_accessid = ? AND legreloj_domingo = 1 AND TIMEDIFF(legreloj_domingohe,"$marcaciondatetime") < "$diferencia" AND legreloj_activo = 1 ';
		*/
		/*
    $stm = $db->prepare($sql);
    $stm->bindValue(1, $marcacionaccesid, PDO::PARAM_STR);
    $stm->execute();
    $row =  $stm->fetchAll(PDO::FETCH_OBJ);

    var_dump($row);
		*/

		// Traducción del ejemplo del usuario Learner (publicado: Dec 1, 2016)
// Post Original: "calculate the difference between 2 timestamps in php";
// https://stackoverflow.com/questions/40905174/calculate-the-difference-between-2-timestamps-in-php

//$fecha1 = new DateTime('2018-11-29 04:55:06');//fecha inicial
//$fecha2 = new DateTime('2018-11-30 11:55:06');//fecha de cierre


/*
$date = date('2018-08-30 00:00:00');
echo $date;
echo "   -";

$newDate = strtotime('-50 minute', strtotime($date));
//$newDate = strtotime('+10 nimute', $newDate);
//$newDate = strtotime('-30 second', $newDate);
$newDate = date ('Y-m-d H:i:s', $newDate);
echo $newDate."<br>";
//----------------------
*/
/*
$fechaInicio=strtotime("25-02-2018");
$fechaFin=strtotime("01-04-2018");
for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
    echo date("Y-m-d", $i)."<br>";
    //$dia = strftime("%w", strtotime("$i"));
    $dia = strftime("%w", strtotime(date("Y-m-d", $i)));
    echo $dia."<br>";
}
*/
/*
$datetime = "2018-09-03 11:59:00";
$i = "2018-09-02";
$date = new DateTime("$datetime");
$def = $date->format('H:i:s');
$defi = $i." ".$def;
echo $defi;
*/
//---------------------------------------
/*
$dia = "2018-08-30";
$horario = "07:00:00";
$horfec = $dia." ".$horario;
$horarioti = strtotime('-50 minute', strtotime($horfec));
$horarioti = date ('Y-m-d H:i:s', $horarioti);
$horariotf = strtotime('+50 minute', strtotime($horfec));
$horariotf = date ('Y-m-d H:i:s', $horariotf);

//-----------------

$marcaciondatetime = date("2018-08-30 06:02:00");
//$marcaciondatetime = strtotime($marcaciondatetime);
//$horarioti = strtotime($horarioti);
//$horariotf = strtotime($horariotf);


if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
  //------------Se encontro la marcacion---------
  echo "Se cumple - Marcacion: ".$marcaciondatetime." FechaI ".$horarioti." FechaF ".$horariotf;
}else{
  //------------No se encontro marcacion--------
  echo "No se cumple - $marcaciondatetime";
}

*/
date_default_timezone_set("America/Buenos_Aires");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$periodofinal = "2018-09-13";


if($fecha <= $periodofinal){
  echo "fecha actual".$fecha."<br>";

}else {
  echo "fecha de periodo".$periodofinal."<br>";

}


?>
