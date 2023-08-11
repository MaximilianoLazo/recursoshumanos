<?php

$secretaria = $_POST["Secretaria"];
$ltrabajo = $_POST["LTrabajo"];
$srevista = $_POST["SRevista"];

//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !

$datetime = new DateTime();
$fecha_actual_ymdhis = $datetime->format('YmdHis');
$fecha_actual_y = $datetime->format('Y');
$fecha_hora_actual = $datetime->format('d/m/Y H:i:s');

$html = '
        <table width="100%">
          <tr>
            <td width="8%" align="left" rowspan="5"><img src="../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
            <td height="10px"></td>
            <td></td>
          </tr>
          <tr>
            <td class="headerdesci">Departamento de Recursos Humanos</td>
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
        ';
        if($srevista == "T"){
          if($ltrabajo == "" OR $ltrabajo == "T"){
            $empledosdatos = $this->model->EmpleadosXSecretiriaObtenerDos($secretaria, $srevista);
          }else{
            $empledosdatos = $this->model->EmpleadosXLTrabajoObtenerDos($ltrabajo, $srevista);
          }
        }else{
          if($ltrabajo == "" OR $ltrabajo == "T"){
            $empledosdatos = $this->model->EmpleadosXSecretiriaObtener($secretaria, $srevista);
          }else{
            $empledosdatos = $this->model->EmpleadosXLTrabajoObtener($ltrabajo, $srevista);
          }
        }

        $empledosdatosc = count($empledosdatos);
        $datossecretaria = $this->model->ObtenerSecretaria($secretaria);

  $col = 'emptrabajonombre';
  $col2  = 'empapellido';
  $col3  = 'empnombres';

  $sort = array();
  $sort2 = array();
  $sort3 = array();

  foreach ($empledosdatos as $i => $obj) {
    $sort[$i] = $obj->{$col};
    $sort2[$i] = $obj->{$col2};
    $sort3[$i] = $obj->{$col3};
  }

  array_multisort($sort2, SORT_ASC, $sort3, SORT_ASC, $sort, SORT_ASC, $empledosdatos);

  foreach($empledosdatos as $clave=>$valor){
  if(empty($valor)) unset($empledosdatos[$clave]);
  }
  $empledosdatos = array_merge($empledosdatos);

$html .='
<p>'.$datossecretaria->secretaria_nombre.': '.$empledosdatosc.'</p>
  <main>
  <table border="1" width="100%" class="tablacontenido">
  <thead>
    <tr>
      <th class="tablacontenido-tituloc">DNI</th>
      <th class="tablacontenido-tituloc">APELLIDO Y NOMBRES</th>
      <th class="tablacontenido-tituloc">S. REVISTA</th>
      <th class="tablacontenido-tituloc">SECRETARIA</th>
      <th class="tablacontenido-tituloc">LUGAR DE TRABAJO</th>
      <th class="tablacontenido-tituloc">TAREA</th>
    </tr>
    </thead>
    <tbody>';
    foreach($empledosdatos as $key => $row){
      $trabajodatos = $this->model->ObtenerLugarDeTrabajo($row->emptrabrajo);
      $secretariadatos = $this->model->ObtenerSecretaria($row->empsecretaria);
$html .='
    <tr>
      <td class="tablacontenido-cuerpod2">'.$row->empdni.'</td>
      <td class="tablacontenido-cuerpoi">'.$row->empapellido.', <br>'.$row->empnombres.'</td>
      <td class="tablacontenido-cuerpoi">'.$row->emptlegajo.'</td>
      <td class="tablacontenido-cuerpoi">'.$secretariadatos->secretaria_nombre.'</td>
      <td class="tablacontenido-cuerpoi">'.$trabajodatos->trabajo_nombre.'</td>
      <td class="tablacontenido-cuerpoi">'.$row->emptarea.'</td>
    </tr>';
    }
$html .='
</tbody>
  </table>
  </main>';
  $fooster = '<div class="fooster">Sistema de Recursos Humanos <span class="copy">©</span> 2018~'.$fecha_actual_y.' Adhemar Caminos | pág. {PAGENO}/{nbpg}</div>';
//==============================================================
//==============================================================
//==============================================================

//------MPDF--------------
require_once __DIR__ . '../../../../../vendor/autoload.php';
$mpdf = new mPDF('s', 'A4');
//$mpdf->WriteHTML('<pagebreak sheet-size="Letter" />');
//$mpdf=new mPDF();
//$mpdf->PDFA = true;
//$mpdf->PDFAauto = true;
$css = file_get_contents('includes/css/contrato-listado.css');
//$mpdf->allow_charset_conversion=true;
//$mpdf->charset_in='UTF-8';
$mpdf->writeHTML($css, 1);
$mpdf->SetHTMLFooter($fooster);
$mpdf->AddPage('P','','','','',25,15,10,12,0,5);
$mpdf->WriteHTML($html, 2);
$mpdf->Output("empleados.pdf", 'D');
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
?>
