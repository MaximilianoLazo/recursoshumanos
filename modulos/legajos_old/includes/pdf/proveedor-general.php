<?php
set_time_limit(1800);

require_once '../../../../database/Conexion.php';
require_once '../../model/empleado.php';
require_once '../../../../src/plugins/arielcr/src/NumerosALetras.php';

$contratoi = new Empleado();

$contratos = $_POST["NroDnis"];

//------MPDF--------------
include("../../../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('s', 'Legal');

foreach($contratos as $nrodocto){
//------Obtencion de datos ------------------
$datoscontrato = $contratoi->ObtenerProveedor($nrodocto);
//----- obtner localidad empleado --------
$empleado_ciudad_dato = $contratoi->LocalidadObtener($datoscontrato->localidad_id);
$empleado_ciudad = $empleado_ciudad_dato->localidad_nombre;
$datosptemunicipal = $contratoi->ObtenerPteMuniciapal();
$secretariaid = $datoscontrato->secretaria_id;
$datossecretario = $contratoi->ObtenerSecretario($secretariaid);
//---- Nuevo Secretaria a Cargo ---
if($datossecretario->secretaria_id == 35 OR $datossecretario->secretaria_id == 6 OR $datossecretario->secretaria_id == 38){
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

$ptemunapellido = strtoupper($datosptemunicipal->legempleado_apellido);
if($datoscontrato->sexo_id == 1){
  $empleadoprefijo = "el";
  $empleadoprofesion = "Sr.";
}else{
  $empleadoprefijo = "la";
  $empleadoprofesion = "Sra.";
}
$apellido = strtoupper($datoscontrato->legempleado_apellido);
$nombres = strtoupper($datoscontrato->legempleado_nombres);
//$lugtrabajo = strtoupper($datoscontrato->trabajo_nombre);
$imputacion = strtoupper($datoscontrato->imputacion_nombre);
if($datossecretario->sexo_id == 1){
  if($datossecretario->secretaria_id == 6){
    $secretarioprefijo = "el";
    $secretariocargo = "Presidente";
    $secretariocargom = strtoupper($secretariocargo);
  }else{
    $secretarioprefijo = "el";
    $secretariocargo = "Secretario";
    $secretariocargom = strtoupper($secretariocargo);
  }
}else{
  if($datossecretario->secretaria_id == 6){
    $secretarioprefijo = "la";
    $secretariocargo = "Presidenta";
    $secretariocargom = strtoupper($secretariocargo);
  }else{
    $secretarioprefijo = "la";
    $secretariocargo = "Secretaria";
    $secretariocargom = strtoupper($secretariocargo);
  }
}
$secrtariacm = strtoupper($datossecretario->secretaria_nombrec);

$secretarioapellido = strtoupper($datossecretario->legempleado_apellido);
$secretarionombres = explode(" ", $datossecretario->legempleado_nombres);
$secretarionombre = $secretarionombres[0];

$dirnombre = strtoupper($datoscontrato->legempleado_direccion);
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
//$numaletras = NumerosALetras::convertir($datoscontrato->legproveedor_sbasico);
//$monedanum = number_format($datoscontrato->legproveedor_sbasico, 2, ',', '.');

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
<div class="tituloc"><u class="titulo"><strong>CONTRATO DE LOCACION DE SERVICIOS</strong></u></div>
<br>
<p>
  Entre la Municipalidad de Gualeguay, representada en este acto por '.$ptemunicipalprefijo.' '.$ptemuniciaplcargo.'  Presidente Municipal, '.$datosptemunicipal->secretaria_profesion.' '.$datosptemunicipal->legempleado_nombres.' '.$ptemunapellido.', en adelante <strong>el contratante</strong> asistido por '.$secretarioprefijo.' '.$secretariocargo.' '.$secac.' '.$datossecretario->secretaria_nombrec.', '.$datossecretario->secretaria_profesion.' '.$datossecretario->legempleado_nombres.' '.$secretarioapellido.', quienes constituyen domicilio especial en 3 de Febrero N° 80, de esta ciudad, por una parte y por la otra '.$empleadoprefijo.' '.$empleadoprofesion.' <strong>'.$apellido.' '.$nombres.' – D.N.I. N° '.$datoscontrato->legempleado_nrodocto.' – C.U.I.L. N° '.$datoscontrato->legempleado_nrocuil.'</strong>, con domicilio en '.$direccion.', de la ciudad de '.$empleado_ciudad.', en adelante el contratado quienes acuerdan celebrar el presente contrato, sujeto a las siguientes cláusulas:<br>
  <strong><span class="articulo">PRIMERA:</span></strong> El <strong>contratante</strong> requiere los servicios del contratado para desempeñarse en la <strong>'.$datoscontrato->secretaria_nombre.', '.$datoscontrato->trabajo_nombre.', '.$datoscontrato->legproveedor_tarea.'</strong>.--------------<br>
  <strong><span class="articulo">SEGUNDA:</span>La obligación que contrae</strong> El <strong>contratado</strong> tiene como prioridadad el seguimiento y control de actuaciones referidas al área.-------------<br>
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
  <table width="100%">
    <tr>
      <td height="10px"></td>
      <td height="10px"><img src="../../../../imagenes/firmas/'.$datosptemunicipal->legempleado_firma.'" width="200px" /></td>
      <td height="10px"><img src="../../../../imagenes/firmas/'.$datossecretario->legempleado_firma.'" width="200px" /></td>
    </tr>
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
</p>';

$css = file_get_contents('../css/contrato-locacion.css');
$mpdf->writeHTML($css, 1);
//$mpdf->AddPage('P');
$mpdf->AddPage('P','','','','',30,20,15,5,0,0);
$mpdf->WriteHTML($html, 2);

}
//==============================================================
//==============================================================
//==============================================================

$mpdf->Output("Contrato.pdf", 'D');
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
  ?>
