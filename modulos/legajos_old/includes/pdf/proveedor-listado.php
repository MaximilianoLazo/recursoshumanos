<?php

require_once '../../../../database/Conexion.php';
require_once '../../model/empleado.php';

$proveedorl = new Empleado();
$nrodoctos = $_POST["NroDnis"];
$contratosc = $_POST["ContratosC"];
$secretaria = $_POST["Secretaria"];
//$lugardetrabajo = $_POST["LugarDeTrabajo"];
//$ordenci = $_POST["OrdenC"];

$html = '
<table width="100%" style="vertical-align: bottom; font-family: sans-serif; font-size: 10pt;"><tr>
<td align="left" rowspan="2"><img src="../../../../src/images/logo-personal.png" width="200px" /></td>
<td style="text-align: right;" rowspan="2"><img src="../../../../src/images/personal-datos.png" width="200px" /></td>
</tr>
</table>';
  $datossecretaria = $proveedorl->ObtenerSecretaria($secretaria);
$html .='
<p>Total de Proveedores en '.$datossecretaria->secretaria_nombre.': '.$contratosc.'</p>
  <table border="1">
    <tr>
      <th>N&deg; DOC</th>
      <th>APELLIDO Y NOMBRES</th>
      <th>LUGAR DE TRABAJO</th>
      <th>FEC INGRESO</th>
      <th>FEC INICIO</th>
      <th>FEC FINAL</th>
      <th>TAREA</th>
      <th>S. BASICO</th>
    </tr>';
    foreach($nrodoctos as $nrodocto){
      $datosempleado = $proveedorl->ObtenerContratosProveedor($nrodocto);
      $fechaingreso = date("d/m/Y", strtotime($datosempleado->legempleado_fecingreso));
      $contratofeci = date("d/m/Y", strtotime($datosempleado->legproveedor_fecinicio));
      $contratofecf = date("d/m/Y", strtotime($datosempleado->legproveedor_fecfin));
      $sbasico = number_format($datosempleado->legproveedor_sbasico, 2, ',', '.');
$html .='
    <tr>
      <td class="nrodocumento">'.$datosempleado->legempleado_nrodocto.'</td>
      <td class="apellido">'.$datosempleado->legempleado_apellido.', <br>'.$datosempleado->legempleado_nombres.'</td>
      <td>'.$datosempleado->trabajo_nombre.'</td>
      <td>'.$fechaingreso.'</td>
      <td>'.$contratofeci.'</td>
      <td>'.$contratofecf.'</td>
      <td>'.$datosempleado->legproveedor_tarea.'</td>
      <td class="importe">$ '.$sbasico.'</td>
    </tr>';
    }
$html .='
  </table>';
//==============================================================
//==============================================================
//==============================================================
include("../../../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('c', 'Legal');
//$mpdf->WriteHTML('<pagebreak sheet-size="Letter" />');
//$mpdf=new mPDF();
//$mpdf->PDFA = true;
//$mpdf->PDFAauto = true;
$css = file_get_contents('../../contrato-listado.css');
//$mpdf->allow_charset_conversion=true;
//$mpdf->charset_in='UTF-8';
$mpdf->writeHTML($css, 1);
$mpdf->WriteHTML($html);
$mpdf->Output("Contrato.pdf", 'D');
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
?>
