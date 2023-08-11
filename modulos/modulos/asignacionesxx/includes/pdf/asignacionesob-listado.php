<?php

/*require_once '../../../../database/Conexion.php';
require_once '../../model/asignacion.php';

$asignacionob = new Asignacion();*/
//$nrodoctos = $_POST["NroDnis"];
//$contratosc = $_POST["ContratosC"];
//$secretaria = $_POST["Secretaria"];
//$lugardetrabajo = $_POST["LugarDeTrabajo"];
//$ordenci = $_POST["OrdenC"];
require_once __DIR__ . '../../../../../vendor/autoload.php';
$mpdf = new mPDF('s', 'A4');

$html = '
<table class="cabeza" width="100%" style="vertical-align: bottom; font-size: 10pt;">
  <tr>
    <td align="left" rowspan="3"><img src="../../src/images/logo-personal.png" width="200px" /></td>
    <td style="text-align: right;" rowspan="3"><img src="../../src/images/personal-datos.png" width="200px" /></td>
  </tr>
</table>';

  $periodoactual = $this->model->PeriodoActualObtener();
  $periodoid = $periodoactual->periodo_id;
  $datosob = $this->model->ExportarOBLiquidaciones($periodoid);
  $obcantidad = $this->model->OBCantidadObtener($periodoid);
  $sueldonob = $this->model->SueldoNetoOBObtenerTotal($periodoid);
  $importetotal = number_format($sueldonob->importesnob, 2, ',', '.');
$html .='
  <main>
  <table border="1">
  <thead>
    <tr>
      <th>EMPLEADO</th>
      <th>N&deg; DOC</th>
      <th>BENEFICIARIO</th>
      <th>N&deg; DOC</th>
      <th>OFICIO/<br>JUZGADO</th>
      <th>IMPORTE</th>
      <th>FIRMA</th>
    </tr>
    </thead>
    <tbody>';
    foreach($datosob as $row){
      //$datosempleado = $contratol->ObtenerContrato($nrodocto);
      //$fechaingreso = date("d/m/Y", strtotime($datosempleado->legempleado_fecingreso));
      //$contratofeci = date("d/m/Y", strtotime($datosempleado->legcontrato_fecinicio));
      //$contratofecf = date("d/m/Y", strtotime($datosempleado->legcontrato_fecfin));

      $empleadonrodocto = $row->legempleado_nrodocto;
      $beneficiarionrodocto = $row->liquidacion_nrodocto;
      //empleado
      $empleado = $this->model->EmpleadoObtener($empleadonrodocto);
      //beneficiario
      $beneficiario = $this->model->EmpleadoObtener($beneficiarionrodocto);
      $oficiodatos = $this->model->OficioObtener($empleadonrodocto, $beneficiarionrodocto, $periodoid);
      $beneficiarioimp = $this->model->SueldoNetoOBObtener($empleadonrodocto, $beneficiarionrodocto, $periodoid);
      $obimportetotal = number_format($beneficiarioimp->importeob, 2, ',', '.');


$html .='
    <tr>
      <td class="apellido">'.$empleado->legempleado_apellido.', <br>'.$empleado->legempleado_nombres.'</td>
      <td class="nrodocumento">'.$empleadonrodocto.'</td>
      <td class="apellido">'.$beneficiario->legempleado_apellido.', <br>'.$beneficiario->legempleado_nombres.'</td>
      <td class="nrodocumento">'.$beneficiarionrodocto.'</td>
      <td>'.$oficiodatos->asignacion_phc_bennoficio.'</td>
      <td class="importe">$ '.$obimportetotal.'</td>
      <td class="firma"></td>
    </tr>';
    }
$html .='
    <tr>
      <td colspan="4">Cantidad de Beneficiarios: '.$obcantidad.'<strong></strong></td>
      <td colspan="2" class="importe">Total : $ '.$importetotal.' </td>
      <td></td>
    <tr>
    </tbody>
  </table>
  </main>
';

$fooster = '<div class="fooster"><span class="copy">©</span> 2019 Adhemar Caminos - Pagina {PAGENO} de {nbpg}</div>';
/*include("../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('c', 'A4');*/
$css = file_get_contents('includes/css/contrato-listado.css');
/*$mpdf->SetFooter($fooster);
$mpdf->AddPage();
$mpdf->writeHTML($css, 1);
$mpdf->WriteHTML($html, 2);
$mpdf->Output("Contrato.pdf", 'D');

$css = file_get_contents('includes/css/sucursales-listado-pdf.css');*/
$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
$mpdf->writeHTML($css, 1);
$mpdf->SetHTMLFooter($fooster);
$mpdf->AddPage('P','','','','',25,15,10,12,0,5);
$mpdf->WriteHTML($html, 2);
$mpdf->Output("Otros_Beneficiarios.pdf", 'D');

exit;

?>
