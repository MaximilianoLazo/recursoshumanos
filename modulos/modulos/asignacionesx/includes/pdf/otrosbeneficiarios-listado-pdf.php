<?php
date_default_timezone_set("America/Buenos_Aires");
require_once '../../../../database/Conexion.php';
require_once '../../model/asignacion.php';
$asignacionesob = new Asignacion();

$tipolistado = $_POST["TipoListado"];
$tipoasignaciones = $_POST["TipoAsignaciones"];
$tipolegajos = $_POST["TipoLegajos"];
$ordenasignaciones = $_POST["OrdenAsingnaciones"];
$incluirnovedades = $_POST["IncluirNovedades"];

$datosperiodo = $asignacionesob->PeriodoActualObtener();

$periodofecinicio_datetime = new DateTime(date("$datosperiodo->periodo_hsext_jor_i"));
$periodofecinicio = $periodofecinicio_datetime->format('d/m/Y');
$periodofecfinal_datetime = new DateTime(date("$datosperiodo->periodo_hsext_jor_f"));
$periodofecfinal = $periodofecfinal_datetime->format('d/m/Y');

$html = '
        <table width="100%">
          <tr>
            <td width="4%" align="left" rowspan="5"><img src="../../../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
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
        <table  width="100%">
          <tr>
            <td>
              <div class="titulo">Asignaciones Familiares (Otros Beneficiarios)</div>
              <div class="subtitulo">Periodo: '.$datosperiodo->periodo_nombre.' '.$periodofecinicio.' - '.$periodofecfinal.'</div>
            </td>
            <td class="subtitulofi">

            </td>
          </tr>
        </table>
        <p></p>';

        $otrosbenficiarioslistado = $asignacionesob->AsignacionesOBListado();

      $html .='
        <main>
        <table border="1" width="100%" class="tablacontenido">
        <thead>
          <tr>
            <th colspan="2" class="tablacontenido-tituloc">EMPLEADO MUNICIPAL</th>
            <th colspan="3" class="tablacontenido-tituloc">BENEFICIARIO</th>
            <th colspan="8" class="tablacontenido-tituloc">ASIGNACIONES</th>
            <th class="tablacontenido-tituloc"></th>

          </tr>
          <tr>
            <th class="tablacontenido-tituloc">APELLIDO Y NOMBRES</th>
            <th width="5%" class="tablacontenido-tituloc">DNI</th>
            <th class="tablacontenido-tituloc">APELLIDO Y NOMBRES</th>
            <th width="5%" class="tablacontenido-tituloc">DNI</th>
            <th width="4%" class="tablacontenido-tituloc">OFICIO</th>
            <th width="4%" class="tablacontenido-tituloc">Pre<br>Natal</th>
            <th width="4%" class="tablacontenido-tituloc">Hijo Menor</th>
            <th width="4%" class="tablacontenido-tituloc">Esc. Prescolar</th>
            <th width="4%" class="tablacontenido-tituloc">Esc. Primaria</th>
            <th width="5%" class="tablacontenido-tituloc">Esc. Med. & Sup.</th>
            <th width="4%" class="tablacontenido-tituloc">Disc.</th>
            <th width="4%" class="tablacontenido-tituloc">Esc. Disc.</th>
            <th width="4%" class="tablacontenido-tituloc">FAM. NUM.</th>
            <th width="4%" class="tablacontenido-tituloc">TOTAL ASIG.</th>
          </tr>
          </thead>
          <tbody>';
          foreach($otrosbenficiarioslistado as $row){
            $empleadonrodocto = $row->empleado;
            $beneficiarionrodocto = $row->beneficiario;
            $empleado = $asignacionesob->EmpleadoObtener($empleadonrodocto);
            $beneficiario = $asignacionesob->BeneficiarioObtener($empleadonrodocto, $beneficiarionrodocto);
            $oficionro = $asignacionesob->ObtenerOficioNro($empleadonrodocto, $beneficiarionrodocto);

            //------- Pre Natal --------
            $prenatal = $asignacionesob->PreNatalFilasNum($empleadonrodocto, $beneficiarionrodocto);
            //------- Hijo Menor ------------
            $fechaactual = date("Y-m-d");
            $fechafinaluno = date("Y-m-d",strtotime($fechaactual."- 5 year"));//resto 5 años
            $fechafinal = date("Y-m-d",strtotime($fechafinaluno."- 5 month"));
            $hijomenor = $asignacionesob->HijoMenorFilasNum($empleadonrodocto, $beneficiarionrodocto, $fechaactual, $fechafinal);
            //------- Prescolar --------
            $escuelanivel = 1;
            $escuelaprescolar = $asignacionesob->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
            //------- Nivel Primaria ---------
            $escuelanivel = 2;
            $escuelaprimaria = $asignacionesob->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
            //------- Nivel Medio Y Superior ---------
            $escuelanivel = 3;
            $escuelamedsup = $asignacionesob->HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel);
            //------ Capacidades diferentes  ----------
            $hijodisc = $asignacionesob->HijoDiscFilasNum($empleadonrodocto, $beneficiarionrodocto);
            //------ Escolar con Capacidades diferentes  ----------
            $hijodiscesc = $asignacionesob->HijoDiscEscFilasNum($empleadonrodocto, $beneficiarionrodocto);
            //------Total de Asignaciones ----------
            $totalasignaciones = $hijomenor->hijom +
                                 $escuelaprescolar->escuelac +
                                 $escuelaprimaria->escuelac +
                                 $escuelamedsup->escuelac +
                                 $hijodisc->hijodisc +
                                 $hijodiscesc->hijodiscesc;
            //----- Calculo de Familia numerosa ----
            $familianum = 0;
            if($totalasignaciones < 3){
              //----- no tiene familia numerosa
              $familianum = 0;
            }else{
              $familianum = $totalasignaciones - 2;
            }

      $html .='
          <tr>
            <td class="tablacontenido-cuerpoi">'.$empleado->legempleado_apellido.', '.$empleado->legempleado_nombres.'</td>
            <td class="tablacontenido-cuerpod">'.$row->empleado.'</td>
            <td class="tablacontenido-cuerpoi">'.$beneficiario->benapellido.', '.$beneficiario->bennombres.'</td>
            <td class="tablacontenido-cuerpod">'.$row->beneficiario.'</td>
            <td class="tablacontenido-cuerpod">'.$oficionro->leghijo_bennoficio.'</td>
            <td class="tablacontenido-cuerpod">'.$prenatal->prenatalc.'</td>
            <td class="tablacontenido-cuerpod">'.$hijomenor->hijom.'</td>
            <td class="tablacontenido-cuerpod">'.$escuelaprescolar->escuelac.'</td>
            <td class="tablacontenido-cuerpod">'.$escuelaprimaria->escuelac.'</td>
            <td class="tablacontenido-cuerpod">'.$escuelamedsup->escuelac.'</td>
            <td class="tablacontenido-cuerpod">'.$hijodisc->hijodisc.'</td>
            <td class="tablacontenido-cuerpod">'.$hijodiscesc->hijodiscesc.'</td>
            <td class="tablacontenido-cuerpod">'.$familianum.'</td>
            <td class="tablacontenido-cuerpod">'.$totalasignaciones.'</td>
          </tr>';
          }
      $html .='
          <tr>
            <td colspan="11" class="tablacontenido-cuerpod"><strong>TOTAL</strong></td>
            <td class="tablacontenido-cuerpod">'.$incluirnovedades.'</td>
            <td class="tablacontenido-cuerpod"></td>
            <td class="tablacontenido-cuerpod"></td>
          <tr>
          </tbody>
        </table>
        </main><main>
        <div style="position: absolute; left: 0mm; bottom: 5mm; rotate: -90;">
          ---
        </div>
        </main>
      ';
$header ='<div class="fooster">
  -
</div>';
$fooster = '<div class="fooster">Sistema de Recursos Humanos © 2019 Adhemar Caminos - Pagina {PAGENO} de {nbpg}</div>';

include("../../../../src/plugins/mpdf/mpdf.php");
$mpdf = new mPDF('s', 'Legal');
$css = file_get_contents('../css/otrosbeneficiarios-listado-pdf.css');
$mpdf->writeHTML($css, 1);
//$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($fooster);
$mpdf->AddPage('L','','','','',25,15,20,15,0,5);
$mpdf->WriteHTML($html, 2);


//==============================================================
//==============================================================
//==============================================================

$mpdf->Output("Fichadas.pdf", 'D');
exit;
?>
