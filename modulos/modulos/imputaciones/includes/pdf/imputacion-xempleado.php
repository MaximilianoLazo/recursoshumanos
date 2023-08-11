<?php

require_once '../../../../database/Conexion.php';
require_once '../../model/imputacion.php';
$imputacion = new Imputacion();

$imputacionid = $_POST["ImputacionId"];
$imputacioncodigo = $_POST["ImputacionCodigo"];
$imputacionnombre = $_POST["ImputacionNombre"];

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

        $empleadosximputacion = $imputacion->ObtenerEmpleadosXImputaciones($imputacionid);

      $html .='

        <table  width="100%">
          <tr>
            <td>
              <div class="titulo">Imputacion: '.$imputacioncodigo.' '.$imputacionnombre.'</div>
              <br>
              <div></div>
            </td>
            <td class="subtitulofi">
            </td>
          </tr>
        </table>
        <main>
        <table border="1" width="100%" class="tablacontenido">
        <thead>
          <tr>
            <th width="8%" class="tablacontenido-tituloc">NRO LEG</th>
            <th width="8%" class="tablacontenido-tituloc">DNI</th>
            <th class="tablacontenido-tituloc">APELLIDO Y NOMBRES</th>
            <th width="8%" class="tablacontenido-tituloc">CATEGORIA</th>
          </tr>
          </thead>
          <tbody>';
          foreach($empleadosximputacion as $row){
            /*$nrodocto = $row->legempleado_nrodocto;
            $datosempleado = $horasextrasresumen->DatosEmpleado($nrodocto);
            $horasexsimples = number_format($row->horasex_simples, 2, ',', '.');
            $horasexdobles = number_format($row->horasex_dobles, 2, ',', '.');
            $horasjornales = number_format($row->horas_jornales, 2, ',', '.');
            //---- Horas totales ----
            $totalhorasexsimples = $totalhorasexsimples + $row->horasex_simples;
            $totalhorasexdobles = $totalhorasexdobles + $row->horasex_dobles;
            $totalhorasjornales = $totalhorasjornales + $row->horas_jornales;*/


      $html .='
          <tr>
            <td class="tablacontenido-cuerpod">'.$row->legempleado_numero.'</td>
            <td class="tablacontenido-cuerpod">'.$row->legempleado_nrodocto.'</td>
            <td class="tablacontenido-cuerpoi">'.$row->legempleado_apellido.', '.$row->legempleado_nombres.'</td>
            <td class="tablacontenido-cuerpoi">'.$row->legtipo_nombre.'</td>
          </tr>';
          }
          //----- Convierte los puntos en comas ---------
          /*$totalhorasexsimples = number_format($totalhorasexsimples, 2, ',', '.');
          $totalhorasexdobles = number_format($totalhorasexdobles, 2, ',', '.');
          $totalhorasjornales = number_format($totalhorasjornales, 2, ',', '.');*/

      $html .='
          <tr>
            <td class="tablacontenido-cuerpod"><strong></strong></td>
            <td class="tablacontenido-cuerpod">'.$totalhorasexsimples.'</td>
            <td class="tablacontenido-cuerpod">'.$totalhorasexdobles.'</td>
            <td class="tablacontenido-cuerpod">'.$totalhorasjornales.'</td>
          <tr>
          </tbody>
        </table>
        </main>
      ';
$fooster = '<div class="fooster">Sistema de Recursos Humanos © 2019 Adhemar Caminos - Pagina {PAGENO} de {nbpg}</div>';

include("../../../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('s', 'A4');
$css = file_get_contents('../css/imputacionxempleado-listado.css');
$mpdf->writeHTML($css, 1);
$mpdf->SetHTMLFooter($fooster);
//$mpdf->AddPage('P');
$mpdf->AddPage('P','','','','',30,15,10,15,0,5);
$mpdf->WriteHTML($html, 2);


//==============================================================
//==============================================================
//==============================================================

$mpdf->Output("Imputaciones.pdf", 'D');
exit;
?>
