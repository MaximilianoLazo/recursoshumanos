<?php
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !
$datetime = new DateTime();
$fecha_actual = $datetime->format('Y-m-d');
$fecha_actual_y = $datetime->format('Y');

$entrega_numero = $_GET["id"];

//------MPDF--------------
require_once __DIR__ . '../../../../../vendor/autoload.php';
$mpdf = new mPDF('s', 'A4');

$entregaedatos = $this->model->IndumentariaEntregaObtner($entrega_numero);
$fecha_orden_pantalla = date("d/m/Y", strtotime($entregaedatos[0]->indumentaria_entrega_fecha));

$empleadodatos = $this->model->EmpleadoObtener($entregaedatos[0]->legempleado_nrodocto);
$ltrabajodatos = $this->model->LugarTrabajoObtener($entregaedatos[0]->trabajo_id);
$secretariadatos = $this->model->SecretariaObtener($entregaedatos[0]->secretaria_id);

$html = '
<table width="100%" class="header">
  <tr>
    <td width="7%" align="left" rowspan="5"><img src="../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
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

$html .= '
<div class="titulo"><u class="subrayado">CONSTANCIA DE ENTREGA DE ELEMENTOS DE TRABAJO</u></div>
<br>
<table width="100%">
  <tr>
    <td class="tablaempdatos-i">
      ORDEN N°: <strong>'.$entregaedatos[0]->indumentaria_orden_id.'</strong>
    </td>
    <td class="tablaempdatos-d">FECHA DE ENTREGA: <strong>'.$fecha_orden_pantalla.'</strong></td>
  </tr>
  <tr>
    <td colspan="2" class="tablaempdatos-i">
      APELLIDO Y NOMBRES: <strong>'.$empleadodatos->legempleado_nrodocto.' - '.$empleadodatos->legempleado_apellido.', '.$empleadodatos->legempleado_nombres.'</strong>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="tablaempdatos-i">
      LUGAR DE TRBAJO: <strong>'.$ltrabajodatos->trabajo_nombre.' - '.$secretariadatos->secretaria_nombre.'</strong>
    </td>
  </tr>
</table>
<br>
<table width="100%" class="tablaindumentarias">
  <thead>
    <tr>
      <th width="8%" class="tablaindumentarias-tituloi">CANT.</th>
      <th width="30%" class="tablaindumentarias-tituloi">INDUMENTARIA</th>
      <th width="6%" class="tablaindumentarias-tituloc">TALLE</th>
      <th width="14%" class="tablaindumentarias-tituloi">COLOR</th>
      <th width="42%" class="tablaindumentarias-tituloi">OBSERVACION</th>
    </tr>
  </thead>';
  $contrador = 0;
  foreach($entregaedatos as $row){
    //----------------------------------------------------
    $indumentariadatos = $this->model->IndumentariaObtener($row->indumentaria_id);
    $talledatos = $this->model->IndumentariaTalleObtener($row->indumentaria_talle_id);
    $colordatos = $this->model->IndumentariaColorObtener($row->indumentaria_color_id);
    $contador = $contador + $row->indumentaria_entrega_cantidad;
    $html.='
    <tbody>
    <tr>
      <td class="tablaindumentarias-cuerpod">'.$row->indumentaria_entrega_cantidad.'</td>
      <td class="tablaindumentarias-cuerpoi">'.$indumentariadatos->indumentaria_nombre.'</td>
      <td class="tablaindumentarias-cuerpoc">'.$talledatos->indumentaria_talle_nombre.'</td>
      <td class="tablaindumentarias-cuerpoi">'.$colordatos->indumentaria_color_nombre.'</td>
      <td class="tablaindumentarias-cuerpoi">'.$row->indumentaria_entrega_observacion.'</td>
    </tr>';
  }
  $html.='
    <tr>
      <th class="tablaindumentarias-cuerpod">'.$contador.'</th>
      <th class="tablaindumentarias-tituloi" colspan="4">TOTAL PRODUCTOS</th>
    </tr>
  </tbody>
</table>';
$html.= '
<p class="terminos">
  Por medio de la presente dejo expresa constancia de haber recibido los elementos que se detallan para ser utilizados en mi lugar de trabajo y dejando expresado que conozco las medidas de seguridad para el desarrollo del mismo.
</p>
<br>






  <table class="firmas" width="100%">
    <tr>
      <td class="firmas-titulo">ENTREGADO POR:</td>
      <td class="firmas-titulo"></td>
      <td class="firmas-titulo">RECIBIDO POR:</td>
    </tr>
    <tr>
      <td class="firmas-linea" width="40%"></td>
      <td width="20%"></td>
      <td class="firmas-linea" width="40%"></td>
    </tr>
    <tr>
      <td>Firma y aclaración</td>
      <td></td>
      <td>Firma y aclaración</td>
    </tr>
  </table>
  <br>
  <br>
  <br>
';

$fooster = '<div class="fooster">Sistema de Recursos Humanos <span class="copy">©</span> 2018~'.$fecha_actual_y.' Adhemar Caminos | pág. {PAGENO}/{nbpg}</div>';

$css = file_get_contents('includes/css/indumentaria-entrega-comprobante.css');
$mpdf->writeHTML($css, 1);
//$mpdf->SetFooter($fooster);
$mpdf->SetHTMLFooter($fooster);
$mpdf->AddPage('P');
$mpdf->WriteHTML($html, 2);

//}


$mpdf->Output("Indumentaria_Entrega_".$datoshijo->legempleado_nrodocto."_".$fechaactual.".pdf", 'D');
exit;

  ?>
