<?php

require_once '../../database/Conexion.php';
require_once 'model/empleado.php';
require_once '../../src/plugins/arielcr/src/NumerosALetras.php';

//require_once 'rutinas.php';
$contratoi = new Empleado();
$nrodocto = $_GET['id'];
//------Obtencion de datos ------------------
$datoscontrato = $contratoi->ObtenerProveedor($nrodocto);
$datosptemunicipal = $contratoi->ObtenerPteMuniciapal();
$secretariaid = $datoscontrato->secretaria_id;
$datossecretario = $contratoi->ObtenerSecretario($secretariaid);
//---- Nuevo Secretaria a Cargo ---
if($datossecretario->secretaria_id == 17){
  //texto si desarrollo
  $secac = "A/C de";
  $secacf = "A/C";
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
//$lugtrabajo = mb_strtoupper($datoscontrato->trabajo_nombre);
$imputacion = mb_strtoupper($datoscontrato->imputacion_nombre, 'UTF-8');
if($datossecretario->sexo_id == 1){
  $secretarioprefijo = "el";
  $secretariocargo = "Secretario";
  $secretariocargom = mb_strtoupper($secretariocargo, 'UTF-8');
}else{
  $secretarioprefijo = "la";
  $secretariocargo = "Secretaria";
  $secretariocargom = mb_strtoupper($secretariocargo, 'UTF-8');
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

list($sbasicoe, $sbasicod) = explode(".", $datoscontrato->legproveedor_sbasico);
if($sbasicod > 0){
  $sbasiconum = number_format($datoscontrato->legproveedor_sbasico, 2, ',', '.');
  $sbasicoletra = NumerosALetras::convertir($sbasicoe);
  $sbasicoletra = $sbasicoletra." CON ".$sbasicod."/100";
}else{
  $sbasiconum = number_format($datoscontrato->legproveedor_sbasico, 0, ',', '.');
  $sbasicoletra = NumerosALetras::convertir($sbasicoe);
}
list($añoi, $mesi, $diai) = explode("-", $datoscontrato->legproveedor_fecinicio);
$mesletrai = $contratoi->MesEnLetra($mesi);
$contratofechai = $diai." DE $mesletrai DE ".$añoi;
list($añof, $mesf, $diaf) = explode("-", $datoscontrato->legproveedor_fecfin);
$mesletraf = $contratoi->MesEnLetra($mesf);
$contratofechaf = $diaf." DE $mesletraf DE ".$añof;

date_default_timezone_set("America/Buenos_Aires");
$fechahoy = date("Y/m/d");
list($añoimpresion, $mesimpresion, $diaimpresion) = explode("/", $fechahoy);
$meshoyletra = $contratoi->MesEnLetra($mesimpresion);
$fechaimpresion = $diaimpresion." DE $meshoyletra DE ".$añoimpresion;

$html = '
<div class="tituloc"><u class="titulo"><strong>CONTRATO DE OBRA</strong></u></div>
<br>
<p>
  Entre la Municipalidad de Gualeguay, representada en este acto por '.$ptemunicipalprefijo.' '.$ptemuniciaplcargo.' Municipal, '.$datosptemunicipal->secretaria_profesion.' '.$datosptemunicipal->legempleado_nombres.' '.$ptemunapellido.', en adelante <strong>el contratante</strong> asistido por '.$secretarioprefijo.' '.$secretariocargo.' '.$secac.' '.$datossecretario->secretaria_nombrec.', '.$datossecretario->secretaria_profesion.' '.$datossecretario->legempleado_nombres.' '.$secretarioapellido.', quienes constituyen domicilio especial en 3 de Febrero N° 80, de esta ciudad, por una parte y por la otra '.$empleadoprefijo.' '.$empleadoprofesion.' <strong>'.$apellido.' '.$nombres.' – D.N.I. N° '.$datoscontrato->legempleado_nrodocto.' – C.U.I.L. N° '.$datoscontrato->legempleado_nrocuil.'</strong>, con domicilio en '.$direccion.', de esta ciudad, en adelante el contratado quienes acuerdan celebrar el presente contrato, sujeto a las siguientes cláusulas:<br>
  <strong><span class="articulo">PRIMERA:</span></strong> El <strong>contratante</strong> requiere los servicios del contratado para desempeñarse en la <strong>'.$datoscontrato->secretaria_nombre.', desempeñado tareas como, '.$datoscontrato->legproveedor_tarea.'</strong>.--------------<br>
  <strong><span class="articulo">SEGUNDA:</span>La obligación que contrae</strong> El <strong>contratado</strong> tiene como prioridad la realización de visitas/recorridos por la obra y obrador de la empresa contratista, como así la elaboración de informes ambientales mensuales para ser adjuntados al certificado de obra.<br>
  Tareas a cumplir:<br>
  a) Revisar y/formular y aprobar la FAEP y los estudios ambientales acorde al nivel de riesgo socio-ambiental.<br>
  b) Remitir los requerimientos ambientales revisados y aprobados a la SSCOPF/DiGePPSE.<br>
  c) Realizar las observaciones ambientales al Contratista.<br>
  e) Presentar los IAS y el IAF.<br>
  f) Revisar y aprobar cualquier replanteo o modificación de obra para asegurar que fue evaluado su impacto ambiental y que se tomen medidas preventivas y de mitigación que sean necesarias para evitar causar impactos ambientales y sociales no considerados y en cumplimiento de la normativa aplicable y el MAS.<br>
  g) Asesorar, informar, sugerir, y evacuar consultas que realicen los contratistas sobre cualquier aspecto o acción de la obra referente a temas vinculados al medio ambiente.<br>
  h) Considerar las observaciones y suministrar toda la información requerida por la SSCOPF/DiGePPSE, referida a la gestión ambiental y social del proyecto.<br>
  <strong><span class="articulo">TERCERA:</span></strong> La vigencia del presente contrato será desde el día <strong>'.$contratofechai.'</strong> hasta el <strong>'.$contratofechaf.'</strong> inclusive, oportunidad en que caducará sin necesidad de intimación y/interpelación previa del tipo alguna.------------------------------------------<br>
  <strong><span class="articulo">CUARTA:</span></strong> Por los servicios correspondientes la <strong>contratante</strong> abonará a <strong>el contratado</strong> como contraprestación una suma de Pesos <strong>$ '.$sbasiconum.' ('.$sbasicoletra.')</strong>, mensuales, otorgado este último la correspondiente Factura o Recibo.-------<br>
  <strong><span class="articulo">QUINTA: </span></strong>El presente contrato podrá ser resuelto por el contratante en cualquier momento antes de la expiración del plazo primigenio pactado, sin necesidad de justificación de causa alguna y aún por razones de oportunidad, mérito y convivencia, sin que ello genere derecho a indemnización alguna para el contratado bastando la sola notificación a éste.----------------------<br>
  <strong><span class="articulo">SEXTA: </span></strong>Estando ambas partes de acuerdo, se firma tres (03) ejemplares de un mismo tenor y a un solo efecto, en la ciudad de Gualeguay, Provincia de Entre Ríos a '.$fechaimpresion.'.----------------------<br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <table width="100%"><br><br>
    <tr>
      <td width="30%" style="font-size:9.4pt"><strong>Firma:...............................</strong></td>
      <td width="37%" style="font-size:9.4pt"><strong><center>'.$datosptemunicipal->secretaria_profesion.' '.$datosptemunicipal->legempleado_nombres.' '.$ptemunapellido.'</center></strong></td>
      <td width="33%" style="font-size:9.4pt"><strong><center>'.$datossecretario->secretaria_profesion.' '.$secretarionombre.' '.$secretarioapellido.'</center></strong></td>
    </tr>
    <tr>
      <td></td>
      <td style="font-size:7.5pt"><center>PRESIDENTE<br>Municipalidad de Gualeguay</center></td>
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
$css = file_get_contents('includes/css/contrato-locacion-obra.css');
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
