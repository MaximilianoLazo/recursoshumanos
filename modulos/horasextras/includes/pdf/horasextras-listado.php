<?php
date_default_timezone_set("America/Buenos_Aires");
require_once '../../../../database/Conexion.php';
require_once '../../model/horasextras.php';
$horasextrasresumen = new HorasExtras();

$lugardetrabajo = $_POST["LugarDeTrabajo"];
$legajotipo = $_POST["LegajoTipo"];
$ordenhoras = $_POST["OrdenHoras"];

$datosperiodo = $horasextrasresumen->PeriodoActualObtener();

$periodofecinicio_datetime = new DateTime(date("$datosperiodo->periodo_hsext_jor_i"));
$periodofecinicio = $periodofecinicio_datetime->format('d/m/Y');
$periodofecfinal_datetime = new DateTime(date("$datosperiodo->periodo_hsext_jor_f"));
$periodofecfinal = $periodofecfinal_datetime->format('d/m/Y');

$html = '
        <table width="100%">
          <tr>
            <td width="7%" align="left" rowspan="5"><img src="../../../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
            <td height="10px"></td>
            <td></td>
          </tr>
          <tr>
            <td class="headerdesci">Departamento Personal</td>
            <td class="headerdescd">personal@gualeguay.gob.ar</td>
          </tr>
          <tr>
            <td class="headerdesci">Secretaría de Hacienda y Producción</td>
            <td class="headerdescd">03444 423468 • 3 de febrero 80</td>
          </tr>
          <tr>
            <td class="headerdescinegrita">Municipalidad de Gualeguay</td>
            <td class="headerdescd">2840 • Gualeguay • Entre Ríos • Argentina</td>
          </tr>
          <tr>
            <td height="10px"></td>
            <td></td>
          </tr>
        </table>
        <br>';

        $datosher = $horasextrasresumen->ListarHorasExtrasPDF($lugardetrabajo, $legajotipo, $ordenhoras);

      $html .='

        <table  width="100%">
          <tr>
            <td>
              <div class="titulo">Planilla de Horas Extras y Jornales</div>
              <div class="subtitulo">Periodo: '.$datosperiodo->periodo_nombre.' '.$periodofecinicio.' - '.$periodofecfinal.'</div>
            </td>
            <td class="subtitulofi">

            </td>
          </tr>
        </table>
        <br>
        <main>
        <table border="1" width="100%" class="tablacontenido">
        <thead>
          <tr>
            <th width="8%" class="tablacontenido-tituloc">DNI</th>
            <th class="tablacontenido-tituloc">APELLIDO Y NOMBRES</th>
            <th class="tablacontenido-tituloc">LUGAR DE TRABAJO</th>
            <th width="8%" class="tablacontenido-tituloc">HORAS SIMPLES</th>
            <th width="8%" class="tablacontenido-tituloc">HORAS DOBLES</th>
            <th width="8%" class="tablacontenido-tituloc">JORNALES</th>
          </tr>
          </thead>
          <tbody>';
          foreach($datosher as $row){
            $nrodocto = $row->legempleado_nrodocto;
            $datosempleado = $horasextrasresumen->DatosEmpleado($nrodocto);
            $horasexsimples = number_format($row->horasex_simples, 2, ',', '.');
            $horasexdobles = number_format($row->horasex_dobles, 2, ',', '.');
            $horasjornales = number_format($row->horas_jornales, 2, ',', '.');
            //---- Horas totales ----
            $totalhorasexsimples = $totalhorasexsimples + $row->horasex_simples;
            $totalhorasexdobles = $totalhorasexdobles + $row->horasex_dobles;
            $totalhorasjornales = $totalhorasjornales + $row->horas_jornales;


      $html .='
          <tr>
            <td class="tablacontenido-cuerpod">'.$row->legempleado_nrodocto.'</td>
            <td class="tablacontenido-cuerpoi">'.$datosempleado->legempleado_apellido.', '.$datosempleado->legempleado_nombres.'</td>
            <td class="tablacontenido-cuerpoi">'.$row->trabajo_nombre.'</td>
            <td class="tablacontenido-cuerpod">'.$horasexsimples.'</td>
            <td class="tablacontenido-cuerpod">'.$horasexdobles.'</td>
            <td class="tablacontenido-cuerpod">'.$horasjornales.'</td>
          </tr>';
          }
          //----- Convierte los puntos en comas ---------
          $totalhorasexsimples = number_format($totalhorasexsimples, 2, ',', '.');
          $totalhorasexdobles = number_format($totalhorasexdobles, 2, ',', '.');
          $totalhorasjornales = number_format($totalhorasjornales, 2, ',', '.');

      $html .='
          <tr>
            <td colspan="3" class="tablacontenido-cuerpod"><strong>TOTAL</strong></td>
            <td class="tablacontenido-cuerpod"><strong>'.$totalhorasexsimples.'</strong></td>
            <td class="tablacontenido-cuerpod"><strong>'.$totalhorasexdobles.'</strong></td>
            <td class="tablacontenido-cuerpod"><strong>'.$totalhorasjornales.'</strong></td>
          <tr>
          </tbody>
        </table>
        </main>
      ';
$fooster = '<div class="fooster">Sistema de Recursos Humanos © 2019 Adhemar Caminos - Pagina {PAGENO} de {nbpg}</div>';

include("../../../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('s', 'A4');
$css = file_get_contents('../css/horasextras-listado.css');
$mpdf->writeHTML($css, 1);
$mpdf->SetHTMLFooter($fooster);
//$mpdf->AddPage('P');
$mpdf->AddPage('P','','','','',30,15,10,15,0,5);
$mpdf->WriteHTML($html, 2);


//==============================================================
//==============================================================
//==============================================================

$mpdf->Output("Fichadas.pdf", 'D');
exit;
?>
