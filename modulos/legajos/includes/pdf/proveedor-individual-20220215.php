<?php

require_once '../../database/Conexion.php';
require_once 'model/empleado.php';
require_once '../../src/plugins/arielcr/src/NumerosALetras.php';

//require_once 'rutinas.php';
$contratoi = new Empleado();
$nrodocto = $_GET['id'];
//------Obtencion de datos ------------------
$datoscontrato = $contratoi->ObtenerProveedor($nrodocto);
//----- obtner localidad empleado --------
$empleado_ciudad_dato = $this->model->LocalidadObtener($datoscontrato->localidad_id);
$empleado_ciudad = $empleado_ciudad_dato->localidad_nombre;
$datosptemunicipal = $contratoi->ObtenerPteMuniciapal();
$secretariaid = $datoscontrato->secretaria_id;
$datossecretario = $contratoi->ObtenerSecretario($secretariaid);
//---- Nuevo Secretaria a Cargo ---
if($datossecretario->secretaria_id == 65 OR $datossecretario->secretaria_id == 6 OR $datossecretario->secretaria_id == 68){
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
<div class="tituloc"><u class="titulo"><strong>CONTRATO DE LOCACION DE OBRA</strong></u></div>
<br>
<p>
  Entre la Municipalidad de Gualeguay, representada en este acto por '.$ptemunicipalprefijo.' '.$ptemuniciaplcargo.' Presidente Municipal, '.$datosptemunicipal->secretaria_profesion.' '.$datosptemunicipal->legempleado_nombres.' '.$ptemunapellido.', en adelante <strong>el contratante</strong> asistido por '.$secretarioprefijo.' '.$secretariocargo.' '.$secac.' '.$datossecretario->secretaria_nombrec.', '.$datossecretario->secretaria_profesion.' '.$datossecretario->legempleado_nombres.' '.$secretarioapellido.', quienes constituyen domicilio especial en 3 de Febrero N° 80, de esta ciudad, por una parte y por la otra '.$empleadoprefijo.' '.$empleadoprofesion.' <strong>'.$apellido.' '.$nombres.' - D.N.I. N° '.$datoscontrato->legempleado_nrodocto.' - C.U.I.L. N° '.$datoscontrato->legempleado_nrocuil.'</strong>, con domicilio en '.$direccion.', de la ciudad de '.$empleado_ciudad.', en adelante el contratado quienes acuerdan celebrar el presente contrato, sujeto a las siguientes cláusulas:<br>
 

  <strong><span class="articulo">PRIMERA: </span></strong> El contratante requiere los servicios del contratado para desempeñarse, como <strong>'.$datoscontrato->legproveedor_tarea.'</strong>, realizando la obra encomendada en los establecimientos médicos asistenciales que integren el Municipio, conforme condiciones modalidades e indicaciones que reciba de la Secretaria que así lo requiera, Director o Jefes.<br>
  El contratante encomienda al contratista en su carácter de Profesional MEDICO, la obra que se detalla a continuación - ATENCION PEDIATRICA - consignándose el valor detallado a continuación:<br>
  &nbsp; &nbsp; &nbsp; &#8226;	<strong>MODULO ESPECIALIDAD CLINICA</strong>, atención de 10 Pacientes a valor de $ 3.000,00 (carga horaria mínima 3 horas) por ejecución del mismo.<br>
  &nbsp; &nbsp; &nbsp; &#8226;	<strong>MODULO ESPECIALIDADES NO CLINICAS</strong>, atención 06 Pacientes a valor de $ 3.000,00 (carga horaria mínima a 3 horas) por ejecución del mismo.<br>

  <strong><span class="articulo">SEGUNDA: </span>La obligación que contrae</strong> El <strong>contratado</strong> tiene como prioridadad el seguimiento y control de actuaciones referidas al área.-------------<br>

  <strong><span class="articulo">TERCERA: </span></strong> La vigencia del presente contrato será desde el día <strong>'.$contratofechai.'</strong> hasta el <strong>'.$contratofechaf.'</strong> inclusive, oportunidad en que caducará sin necesidad de intimación y/interpelación previa del tipo alguna.----------<br>


  <strong><span class="articulo">CUARTA:</span></strong> La contraprestación a percibir por el contratista será determinada por la cantidad de actos médicos que realice en el periodo a liquidarse, según valores estipulados en la cláusula primera. Serán liquidados de forma mensual, por periodo vencido, y por la porción de obra ejecutada, dentro de los primeros 10 (diez) días del periodo siguiente al de la certificación de la obra y presentación de la factura y/o recibo, junto a la planilla de atención. El contratista para poder cobrar la obra deberá, a) Elevar informe del periodo de trabajo realizado indicando cantidad de pacientes, identificación con nombre apellido y firma de los mismos, como así tambien, días y horarios de atención, b) el informe deberá estar avalado por el Director, Jefe o encargado del establecimiento de salud, c) Presentar la respectiva Factura..-------<br>
  

  <strong><span class="articulo">QUINTA: </span></strong>El presente contrato podrá ser resuelto por el contratante en cualquier momento antes de la expiración del plazo primigenio pactado, sin necesidad de justificación de causa alguna y aún por razones de oportunidad, mérito y convivencia, sin que ello genere derecho a indemnización alguna para el contratado bastando la sola notificación a éste.----------------------<br>

  <strong><span class="articulo">SEXTA: </span></strong>Estando ambas partes de acuerdo, se firma tres (03) ejemplares de un mismo tenor y a un solo efecto, en la ciudad de Gualeguay, Provincia de Entre Ríos a '.$fechaimpresion.'.----------------------<br> 

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
//include("../../src/plugins/mpdf/mpdf.php");
require_once __DIR__ . '../../../../../vendor/autoload.php';
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
