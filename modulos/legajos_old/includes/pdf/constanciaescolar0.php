<?php
set_time_limit(1800);

require_once '../../../../database/Conexion.php';
require_once '../../model/empleado.php';


$contanciaescolar = new Empleado();

$hijonrodocto = $_POST["NroDnis"];
$añoactual = date("Y");
$mesactual = date("n");
if($mesacutal <= 7){
  $etapa = "INICIAL";
}else{
  $etapa = "FINAL";
}
//------MPDF--------------
include("../../../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('s', 'A4');


foreach($hijonrodocto as $nrodocto){


$datoshijo = $contanciaescolar->ObtenerHijo($nrodocto);
$hijofecnacformato = date("d/m/Y", strtotime($datoshijo->leghijo_fecnacto));

$html = '
<table width="100%" style="vertical-align: bottom; font-family: sans-serif; font-size: 10pt;"><tr>
<td align="left" rowspan="2"><img src="../../../../src/images/logo-personal.png" width="200px" /></td>
<td style="text-align: right;" rowspan="2"><img src="../../../../src/images/personal-datos.png" width="200px" /></td>
</tr>
</table>
<br>';

$html .= '
<div class="titulo"><u class="subrayado">CONSTANCIA DE ALUMNO REGULAR - '.$etapa.' '.$añoactual.'</u></div>
<p>
  <div class="alndesc">Apellido y Nombre: <strong>'.$datoshijo->leghijo_apellido.', '.$datoshijo->leghijo_nombres.'</strong></div>
  <div class="alndesc">D.N.I.: <strong>'.$datoshijo->leghijo_nrodocto.'</strong></div>
  <div class="alndesc">Fecha de Nacimiento: <strong>'.$hijofecnacformato.'</strong></div>
</p>
<p class="cabecera">
  Conste que el Alumno/a cuyos datos figuran en la presente, concurrio al nivel <strong>'.$datoshijo->escnivel_nombre.'</strong> y a la fecha mantine su condicion de Alumno Regular en el establecimiento <strong>'.$datoshijo->escuela_nombre.' Nro. '.$datoshijo->escuela_numero.'</strong> A pedido del Titular del Beneficio: <strong>'.$datoshijo->legempleado_apellido.', '.$datoshijo->legempleado_nombres.' - D.N.I. '.$datoshijo->legempleado_nrodocto.' - '.$datoshijo->legtipo_nombre.'.</strong><br>
  se extiende la presente al solo efecto de ser presentado ante la Municipalidad de Gualeguay.
</p>
  <br>
  <br>
  <br>
  <br>
  <br>
  <table class="firmas" width="100%">
    <tr>
      <td>-------------------------------------</td>
      <td>-------------------------------------</td>
      <td>-------------------------------------</td>
    </tr>
    <tr>
      <td>Lugar y fecha</td>
      <td>Firma y aclaración</td>
      <td>Sello del establecimiento</td>
    </tr>
  </table>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <table width="100%">
    <tr>
      <td class="aclaracion">Para uso exclusivo de la Municipalidad de Gualeguay, cortar por linea de Puntos</td>
    </tr>
    <tr>
      <td class="lineadepuntos"></td>
    </tr>
  </table>

  <div class="titulo"><u class="subrayado">MESA DE ENTRADAS: Comprobante de Presentación de Tramite</u></div><br>
  <table class="cupon">
    <tr>
      <td>
        Apellido y Nombres: <strong>'.$datoshijo->leghijo_apellido.', '.$datoshijo->leghijo_nombres.'</strong>
      </td>
      <td class="cuadrado" rowspan="4" valign="bottom">Sello de Mesa de Entradas</td>
    </tr>
    <tr>
      <td>
        D.N.I.: <strong>'.$datoshijo->leghijo_nrodocto.'</strong>
      </td>
    </tr>
    <tr>
      <td>Fecha de Nacimiento: <strong>'.$hijofecnacformato.'</strong></td>
    </tr>
    <tr>
      <td>Empleado: <strong>'.$datoshijo->legempleado_apellido.', '.$datoshijo->legempleado_nombres.' - D.N.I. '.$datoshijo->legempleado_nrodocto.' - '.$datoshijo->legtipo_nombre.'</strong></td>
    </tr>
  </table>
</p>';

$fooster = '<div class="fooster">Sistema de Recursos Humanos © 2019 Adhemar Caminos - Pagina {PAGENO} de {nbpg}</div>';

$css = file_get_contents('../css/constanciaescolar.css');
$mpdf->writeHTML($css, 1);
//$mpdf->SetFooter($fooster);
$mpdf->SetHTMLFooter($fooster);
$mpdf->AddPage('P');
$mpdf->WriteHTML($html, 2);

}


$mpdf->Output("Contrato.pdf", 'D');
exit;

  ?>
