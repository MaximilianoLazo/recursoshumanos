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

  $nrodocto = $_POST['NroDocto'];
  $indumentariatipo = $_POST['IndumentariaTipo'];
  $indumentariafeci = $_POST['IndumentariaFecI'];
  $indumentariafecf = $_POST['IndumentariaFecF'];

  //------MPDF--------------
  require_once __DIR__ . '../../../../../vendor/autoload.php';
  $mpdf = new mPDF('s', 'A4');

  if($indumentariatipo > 0){
    //---Filtrar tipo de indumentaria
    $indentregadasdatos = $this->model->IndumentariasEntregasListarFil($indumentariatipo, $nrodocto, $indumentariafeci, $indumentariafecf);
  }else{
    //---Sin filtro
    $indentregadasdatos = $this->model->IndumentariasEntregasListar($nrodocto, $indumentariafeci, $indumentariafecf);
  }

  $html = '<table width="100%">
            <tr>
              <td width="8%" align="left" rowspan="5"><img src="../../src/images/logo-personal1.png" width="45px" height="60px"/></td>
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
          /*<table class="tablaempdatos">
           <tr>
             <th width="" class="tablaempdatos-tituloi">EMPLEADO :</th>
             <th width="15%" class="tablaempdatos-tituloi">DNI :</th>
             <th width="" class="tablaempdatos-tituloi">SITUACION DE REVISTA :</th>
             <th width="" class="tablaempdatos-tituloi">FECHA DE INGRESO :</th>
           </tr>
           <tr>
             <td class="tablaempdatos-cuerpoi"><strong>Caminos,</strong> Adhemar Roque Amiel</td>
             <td class="tablaempdatos-cuerpoi">36583053</td>
             <td class="tablaempdatos-cuerpoi">Planta Permanente CATEGORIA: 22</td>
             <td class="tablaempdatos-cuerpoi">17/06/2020</td>
           </tr>
          </table>
          <br>*/
          $html .='

           <main>
            <table border="1" width="100%" class="tablacontenido">
              <thead>
                <tr>
                  <th width="6%" class="tablacontenido-tituloc">FECHA</th>
                  <th width="4%" class="tablacontenido-tituloc">ORDEN</th>
                  <th width="4%" class="tablacontenido-tituloc">CANT</th>
                  <th width="25%" class="tablacontenido-tituloc">INDUMENTARIA</th>
                  <th width="6%" class="tablacontenido-tituloc">TALLE</th>
                  <th width="15%" class="tablacontenido-tituloc">COLOR</th>
                  <th width="40%" class="tablacontenido-tituloc">OBSERVACION</th>
                </tr>
              </thead>
              <tbody>';
              foreach($indentregadasdatos as $row){
                //$nrodocto = $rowll->legempleado_nrodocto;
                $indumentariafec = new DateTime($row->indumentaria_entrega_fecha);
                $indumentaria_fecha_pantalla = $indumentariafec->format('d/m/Y');
       $html .='<tr>
                  <td class="tablacontenido-cuerpod">'.$indumentaria_fecha_pantalla.'</td>
                  <td class="tablacontenido-cuerpod">'.$row->indumentaria_orden_id.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->indumentaria_entrega_cantidad.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->indumentaria_nombre.'</td>
                  <td class="tablacontenido-cuerpoc">'.$row->indumentaria_talle_nombre.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->indumentaria_color_nombre.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->indumentaria_entrega_observacion.'</td>
                </tr>';
              }
    $html .='</tbody>
          </table>
        </main>
        <div style="font-size: 8px; position: absolute; left: 2mm; bottom: 13mm; rotate: -90;">
          RC:2000000 - USR136583053 - FI20200612
        </div>';

  $fooster = '<div class="fooster">Sistema de Recursos Humanos <span class="copy">©</span> 2018~'.$fecha_actual_y.' Adhemar Caminos | pág. {PAGENO}/{nbpg}</div>';

  $css = file_get_contents('includes/css/indumentaria-entrega-listado-empleado.css');
  $mpdf->writeHTML($css, 1);
  $mpdf->SetHTMLFooter($fooster);
  $mpdf->AddPage('P','','','','',25,15,10,12,0,5);
  $mpdf->WriteHTML($html, 2);

  //==============================================================
  //==============================================================
  //==============================================================

  $mpdf->Output("Indumentaria_Entrega_".$datoshijo->legempleado_nrodocto."_".$fechaactual.".pdf", 'D');
  exit;
  //exit;
  //==============================================================
  //==============================================================
  //==============================================================
  //==============================================================
  //==============================================================

?>
