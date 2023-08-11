<?php

require_once '../../database/Conexion.php';
require_once 'model/empleado.php';
require_once '../../src/plugins/arielcr/src/NumerosALetras.php';

//require_once 'rutinas.php';
$contratoi = new Empleado();
$nrodocto = $_GET['id'];
//------Obtencion de datos ------------------
$datoscontrato = $contratoi->ObtenerContrato($nrodocto);
$datosptemunicipal = $contratoi->ObtenerPteMuniciapal();
$secretariaid = $datoscontrato->secretaria_id;
$datossecretario = $contratoi->ObtenerSecretario($secretariaid);
//---- Nuevo Secretaria a Cargo ---
if($datossecretario->secretaria_id == 8){
  //texto si desarrollo
  $secac = "A/C de";
  $secacf = "A/C DE";
}else{
  //texto no desarrolo
  $secac = "de";
  $secacf = "DE";
}
//----Fin  Nuevo Secretaria a Cargo ---
//------Volcado de datos ----------------------
if($datosptemunicipal->sexo_id == 1){
  $ptemunicipalprefijo = "el";
  $ptemuniciaplcargo = "Presidente";
}else{
  $ptemunicipalprefijo = "la";
  $ptemunicipalcargo = "Presidenta";
}

$ptemunapellido = mb_strtoupper($datosptemunicipal->legempleado_apellido, 'UTF-8');
if($datoscontrato->sexo_id == 1){
  $empleadoprefijo = "el";
  $empleadoprofesion = "Sr.";
}else{
  $empleadoprefijo = "la";
  $empleadoprofesion = "Sra.";
}
$apellido = mb_strtoupper($datoscontrato->legempleado_apellido, 'UTF-8');
$nombres = mb_strtoupper($datoscontrato->legempleado_nombres, 'UTF-8');
$dependencia = mb_strtoupper($datoscontrato->impdependencia_nombre, 'UTF-8');
$imputacion = mb_strtoupper($datoscontrato->imputacion_nombre, 'UTF-8');

if($datossecretario->sexo_id == 1){
  if($datossecretario->secretaria_id == 6){
    $secretarioprefijo = "el";
    $secretariocargo = "Presidente";
    $secretariocargom = mb_strtoupper($secretariocargo, 'UTF-8');
  }else{
    $secretarioprefijo = "el";
    $secretariocargo = "Secretario";
    $secretariocargom = mb_strtoupper($secretariocargo, 'UTF-8');
  }
}else{
  if($datossecretario->secretaria_id == 6){
    $secretarioprefijo = "la";
    $secretariocargo = "Presidenta";
    $secretariocargom = mb_strtoupper($secretariocargo, 'UTF-8');
  }else{
    $secretarioprefijo = "la";
    $secretariocargo = "Secretaria";
    $secretariocargom = mb_strtoupper($secretariocargo, 'UTF-8');
  }
}

$secrtariacm = mb_strtoupper($datossecretario->secretaria_nombrec, 'UTF-8');
$secretarioapellido = mb_strtoupper($datossecretario->legempleado_apellido, 'UTF-8');
$secretarionombres = explode(" ", $datossecretario->legempleado_nombres);
$secretarionombre = $secretarionombres[0];

$dirnombre = mb_strtoupper($datoscontrato->legempleado_direccion, 'UTF-8');
// Se evalúa a true ya que $var está vacia
if (empty($datoscontrato->legempleado_direcnro)) {
    //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
    $empdirecnro = "S/N";
}else{
  if(is_numeric($datoscontrato->legempleado_direcnro)){
    //echo "'{$element}' es numérico", PHP_EOL;
    $direccion = $dirnombre." N&deg; ".$datoscontrato->legempleado_direcnro;
  }else{
    //echo "'{$element}' NO es numérico", PHP_EOL;
    $direccion = $dirnombre." ".$datoscontrato->legempleado_direcnro;
  }
}
//$letras = NumeroALetras::convertir(5200.92, 'colones', 'centimos');
//$numaletras = NumerosALetras::convertir($datoscontrato->legcontrato_sbasico);
//$monedanum = number_format($datoscontrato->legcontrato_sbasico, 2, ',', '.');

list($sbasicoe, $sbasicod) = explode(".", $datoscontrato->legcontrato_sbasico);
if($sbasicod > 0){
  $sbasiconum = number_format($datoscontrato->legcontrato_sbasico, 2, ',', '.');
  $sbasicoletra = NumerosALetras::convertir($sbasicoe);
  $sbasicoletra = $sbasicoletra." CON ".$sbasicod."/100";
}else{
  $sbasiconum = number_format($datoscontrato->legcontrato_sbasico, 0, ',', '.');
  $sbasicoletra = NumerosALetras::convertir($sbasicoe);
}
list($añoi, $mesi, $diai) = explode("-", $datoscontrato->legcontrato_fecinicio);
$mesletrai = $contratoi->MesEnLetra($mesi);
$contratofechai = $diai." DE $mesletrai DE ".$añoi;
list($añof, $mesf, $diaf) = explode("-", $datoscontrato->legcontrato_fecfin);
$mesletraf = $contratoi->MesEnLetra($mesf);
$contratofechaf = $diaf." DE $mesletraf DE ".$añof;

date_default_timezone_set("America/Buenos_Aires");
$fechahoy = date("Y/m/d");
list($añoimpresion, $mesimpresion, $diaimpresion) = explode("/", $fechahoy);
$meshoyletra = $contratoi->MesEnLetra($mesimpresion);
$fechaimpresion = $diaimpresion." DE $meshoyletra DE ".$añoimpresion;

$html = '
<div class="tituloc"><u class="titulo"><strong>CONTRATO DE LOCACION DE SERVICIOS</strong></u></div>
<p>
  Entre la Municipalidad de Gualeguay, representada en este acto por '.$ptemunicipalprefijo.' '.$ptemuniciaplcargo.' '.$datosptemunicipal->secretaria_profesion.' '.$datosptemunicipal->legempleado_nombres.' '.$ptemunapellido.' A/C de Presidencia Municipal, en adelante <strong>el contratante</strong> asistido por '.$secretarioprefijo.' '.$secretariocargo.' '.$secac.' '.$datossecretario->secretaria_nombrec.', '.$datossecretario->secretaria_profesion.' '.$datossecretario->legempleado_nombres.' '.$secretarioapellido.', quienes constituyen domicilio especial en 3 de Febrero N° 80, de esta ciudad, por una parte y por la otra '.$empleadoprefijo.' '.$empleadoprofesion.' <strong>'.$apellido.' '.$nombres.' – D.N.I. N° '.$datoscontrato->legempleado_nrodocto.' – C.U.I.L. N° '.$datoscontrato->legempleado_nrocuil.'</strong>, con domicilio en '.$direccion.', de esta ciudad, en adelante el contratado quienes acuerdan celebrar el presente contrato, sujeto a las siguientes cláusulas:<br>
  <strong><span class="articulo">PRIMERA:</span></strong> El <strong>contratante</strong> requiere los servicios del contratado para desempeñarse en la <strong>'.$datoscontrato->secretaria_nombre.', '.$datoscontrato->imputacion_codigow.'C – '.$imputacion.', '.$dependencia.', '.$datoscontrato->legcontrato_tarea.'</strong>, quedando obligado a cumplir sus servicios en el horario, tiempo, lugar y forma que el contratante lo determine; siéndole compatible desempeñar cualquier actividad privada, fuera del horario asignado y/o de los requerimientos de la Municipalidad.---------<br>
  <strong><span class="articulo">SEGUNDA:</span></strong> El <strong>contratado</strong> percibirá un haber mensual de <strong>$ '.$sbasiconum.' ('.$sbasicoletra.')</strong> con más la suma que proporcionalmente correspondiere en concepto de sueldo anual complementario, en la forma y modos establecidos por Leyes y Ordenanzas y el Presentismo.-------<br>
  <strong><span class="articulo">TERCERA:</span></strong> Los ingresos enunciados en las cláusulas anteriores sufrirán los descuentos para Aportes Jubilatorios, en un todo de acuerdo con lo dispuesto en la Ordenanza N° 2555/09.- Se deja expresa constancia que el presente contrato tendrá derecho a los beneficios que otorga El Instituto de Obra Social de la Provincia de Entre Ríos (I.O.S.P.E.R.), mientras dure su relación de dependencia con la Municipalidad de Gualeguay, debiendo efectuar dicha gestión en forma personal.--------------<br>
  <strong><span class="articulo">CUARTA:</span></strong> El <strong>contratado</strong> gozará de un periodo de Licencia conforme al régimen establecido para el personal de la Municipalidad de Gualeguay, como así también de los descansos y feriados obligatorios que establecen las Leyes Nacionales y Provinciales.---------------------------------------<br>
  <strong><span class="articulo">QUINTA:</span></strong> La vigencia del presente contrato será desde el día <strong>'.$contratofechai.'</strong> hasta el <strong>'.$contratofechaf.'</strong> inclusive.------------------------------------------<br>
  <strong><span class="articulo">SEXTA: </span></strong>Las partes se reservan el derecho de rescindir el presente contrato en cualquier oportunidad, debiendo comunicar dicha decisión a la otra parte por escrito, operando la resolución contractual a partir del día de la notificación. En caso de resolverse la contratación aún sin causa por parte del Ente Municipal antes del plazo fijado en el contrato, ello no generará derecho a retribución ni indemnización alguna a favor del contratado, que renuncia a formular cualquier tipo de reclamación por concepto alguno.------------------------------------------------------<br>
  <strong><span class="articulo">SEPTIMA: </span></strong>Vencida la fecha, este contrato caducará en forma automática, debiendo las partes en este último supuesto firmar un nuevo contrato que regule la relación administrativa de prestación de servicios. Así de conformidad, las partes previa lectura y ratificación de lo expuesto, firman el presente en tres (03) ejemplares de un mismo tenor y a un solo efecto, en la ciudad de Gualeguay, Provincia de Entre Ríos a 9 DE OCTUBRE DE 2020.----------------------
  <table width="100%">
    <tr>
      <td height="10px"></td>
      <td height="10px"><img src="../../imagenes/firmas/'.$datosptemunicipal->legempleado_firma.'" width="200px" /></td>
      <td height="10px"><img src="../../imagenes/firmas/'.$datossecretario->legempleado_firma.'" width="200px" /></td>
    </tr>
    <tr>
      <td width="30%" style="font-size:9.4pt"><strong>Firma:...............................</strong></td>
      <td width="37%" style="font-size:9.4pt"><strong><center>'.$datosptemunicipal->secretaria_profesion.' '.$datosptemunicipal->legempleado_nombres.' '.$ptemunapellido.'</center></strong></td>
      <td width="33%" style="font-size:9.4pt"><strong><center>'.$datossecretario->secretaria_profesion.' '.$secretarionombre.' '.$secretarioapellido.'</center></strong></td>
    </tr>
    <tr>

      <td></td>
      <td style="font-size:7.5pt"><center>A/C DE PRESIDENCIA<br>Municipalidad de Gualeguay</center></td>
      <td style="font-size:7.5pt"><center>'.$secretariocargom.' '.$secacf.' '.$secrtariacm.'</center></td>
    </tr>
    <tr>

      <td></td>
      <td></td>
      <td style="font-size:7.5pt"><center>Municipalidad de Gualeguay</center></td>
    </tr>
  </table>
</p>
';
//==============================================================
//==============================================================
//==============================================================
include("../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('s', 'Legal');
//$mpdf->WriteHTML('<pagebreak sheet-size="Letter" />');
//$mpdf=new mPDF();
//$mpdf->PDFA = true;
//$mpdf->PDFAauto = true;
$css = file_get_contents('includes/css/contrato-locacion.css');
//$mpdf->allow_charset_conversion=true;
//$mpdf->charset_in='UTF-8';
$mpdf->writeHTML($css, 1);
$mpdf->WriteHTML($html);
$mpdf->Output("Contrato_".$añoimpresion."".$mesimpresion."".$diaimpresion."_".$datoscontrato->legempleado_apellido."_".$datoscontrato->legempleado_nombres.".pdf", 'D');
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
?>
