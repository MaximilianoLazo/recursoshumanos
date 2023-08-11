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

  $fechai = $_POST["IndumentariaLEFecIni"];
  $fechaf = $_POST["IndumentariaLEFecFin"];
  $secretaria = $_POST["IndumentariaLESec"];
  $ltrabajo = $_POST["IndumentariaLELTrabajo"];

  if($secretaria == 0 AND $ltrabajo == 0){
    //---sin filtro de secretaria ni lugar de trabajo
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFecha($fechai, $fechaf);
  }elseif($secretaria > 0 AND $ltrabajo == 0){
    //---sin filtro de lugar de trabajo, con filtro de secretaria
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFechaXSecretaria($fechai, $fechaf, $secretaria);
  }elseif($secretaria > 0 AND $ltrabajo > 0){
    //---con filtro de secretaria y lugar de trabajo
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFechaXSecretariaXLTrabajo($fechai, $fechaf, $secretaria, $ltrabajo);
  }elseif($secretaria == 0 AND $ltrabajo > 0){
    //---sin filtro de secretaria, con filtro de lugar de trabajo
    $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFechaXLTrabajo($fechai, $fechaf, $ltrabajo);
  }else{
    //---defaul, error----
  }

  //$indumentariaentdatos = $this->model->IndumentariasEntregasListarXFecha($fechai, $fechaf);


  //------MPDF--------------
  require_once __DIR__ . '../../../../../vendor/autoload.php';
  $mpdf = new mPDF('s', 'A4');
  //$mpdf->AddPage('L','','','','',25,15,10,12,0,5);


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

          $html .='
           <main>
            <table border="1" width="100%" class="tablacontenido">
              <thead>
                <tr>
                  <th class="tablacontenido-tituloc">FECHA</th>
                  <th class="tablacontenido-tituloc">DNI</th>
                  <th class="tablacontenido-tituloc">APELLIDO Y NOMBRES</th>
                  <th class="tablacontenido-tituloc">ORDEN</th>
                  <th class="tablacontenido-tituloc">CANT</th>
                  <th class="tablacontenido-tituloc">INDUMENTARIA</th>
                  <th class="tablacontenido-tituloc">TALLE</th>
                  <th class="tablacontenido-tituloc">COLOR</th>
                  <th class="tablacontenido-tituloc">OBSERVACION</th>
                  <th class="tablacontenido-tituloc">LUGAR DE TRABAJO</th>
                  <th class="tablacontenido-tituloc">SECRETARIA</th>
                </tr>
              </thead>
              <tbody>';
              foreach($indumentariaentdatos as $row){
                //$nrodocto = $rowll->legempleado_nrodocto;
                $indumentariafec = new DateTime($row->indumentaria_entrega_fecha);
                $indumentaria_fecha_pantalla = $indumentariafec->format('d/m/Y');
       $html .='<tr>
                  <td class="tablacontenido-cuerpod">'.$indumentaria_fecha_pantalla.'</td>
                  <td class="tablacontenido-cuerpod">'.$row->legempleado_nrodocto.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->legempleado_apellido.', <br>'.$row->legempleado_nombres.'</td>
                  <td class="tablacontenido-cuerpod">'.$row->indumentaria_orden_id.'</td>
                  <td class="tablacontenido-cuerpod">'.$row->indumentaria_entrega_cantidad.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->indumentaria_nombre.'</td>
                  <td class="tablacontenido-cuerpoc">'.$row->indumentaria_talle_nombre.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->indumentaria_color_nombre.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->indumentaria_entrega_observacion.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->trabajo_nombre.'</td>
                  <td class="tablacontenido-cuerpoi">'.$row->secretaria_nombre.'</td>
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
  $mpdf->AddPage('L','','','','',25,15,10,12,0,5);
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
