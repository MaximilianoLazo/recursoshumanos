<?php
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !
//$datetime = new DateTime();
//$fecha_actual = $datetime->format('d/m/Y H:i:s');

//$fecha_actual_y = $datetime->format('Y');
//$fecha_impresion = $datetime->format('YmdHis');
//$destinonombre = $this->model->DestinoObtener($_SESSION['destino_id']);

//$secretarianombre = $this->model->SecretariaObtener($destinonombre->secretaria_id);
//$fecha_expediente_pantalla = date("d/m/Y", strtotime($turno_imprimir_datos->turno_fecha));
//$expedienteid = $_GET["id"];
//------MPDF--------------
require_once __DIR__  . '../../../../../vendor/autoload.php';
$mpdf = new mPDF('s', 'A4');

$html = '
<table>
  <tr>
    <td style="width: 50%;">
    <table>
    <tr>
      <td>
        <table style="width:100%;border: 1px solid;border-collapse:collapse;border-padding:25px">
          <tr>
            <th>REPARTICION: CAJA DE JUBILACIONES Y PENSIONES DE LA MUNICIPALIDAD DE GUALEGUAY</th>
            <th></th>
          </tr>
          <tr>
            <th>DOMICILIO: 1° ENTRERRIANO N° 90 - GUALEGUAY - ENTRE RIOS       C.U.I.L. N° 33-67105652-9</th>
            <th></th>
          </tr>
        </table>
        <br>
        <table style="width:100%;border: 1px solid;border-collapse:collapse;">
          <tr>
            <td style="border: 1px solid"  align="center"><strong>APELIDO Y NOMBRE</strong></td>
            <td style="border: 1px solid"  align="center"><strong>LEGAJO</strong></td>
            <td style="border: 1px solid"  align="center"><strong>FECHA INGRESO</strong></td>
            <td style="border: 1px solid"  align="center"><strong>RECIBO N°</strong></td>
          </tr>
          <tr>
              <td style="border: 1px solid"  align="center"><strong>'.$recibosdatos_emp->legajo_apellido . ',' . $recibosdatos_emp->legajo_nombres.'</strong></td>
              <td style="border: 1px solid"  align="center"><strong>'.$recibosdatos_emp->legajo_id.'</strong></td>
              <td style="border: 1px solid"><strong>'.$recibosdatos_emp->legajo_fecing.'</strong></td>
              <td style="border: 1px solid"><strong>'.$recibosdatos_emp->legajo_id.'</strong></td>
          </tr>
        </table>

       <table style="width:100%;padding:25px;border: 1px solid;border-collapse:collapse;margin-bottom: 10px">
         <tr>
           <td style="border: 1px solid;" align="center"><strong>BENEFICIO</strong></td>
           <td style="border: 1px solid;" align="center"><strong>TIPO Y N° DOCUMENTO</strong></td>

           <td style="border: 1px solid;" align="center"><strong>MES DE PAGO</strong></td>

         </tr>
         <tr>
             <th style="border: 1px solid;" align="center">'.$recibosdatos_emp->legajo_tipo_nombre.'</th>
             <th style="border: 1px solid;" align="center">'.$recibosdatos_emp->doctipo_abreviacion.":".$recibosdatos_emp->legajo_nrodocto.'</th>

             <th style="border: 1px solid;" align="center">'.$fec.'</th>

         </tr>
       </table>
       <br>

       <table style="width:100%;padding:5px;border: 1px solid;border-collapse:collapse" >
          <thead>
            <tr style="padding:5px;border: 1px solid" >
              <th style="padding:5px;border: 1px solid">COD</th>
              <th style="padding:5px;border: 1px solid">DESCRIPCION DE CONCEPTOS</th>
              <th style="padding:5px;border: 1px solid">REMUNERACIONES EXENTAS</th>
              <th style="padding:5px;border: 1px solid">DESCUENTOS</th>
            </tr>
          </thead>
          <tbody>';

                $c=0;$desc=0;$rem=0;$monto=0;
                foreach($recibosdatos as $row){
                $html.='<tr><td style="border: 1px solid">'.$row->liqcod_jub_id.'</td>
                <td style="border: 1px solid">'.$row->liq_det_detconcep.'</td>';
                if($row->impacto=="+"){
                     $monto=$row->liq_det_importe;
                     $c=$c+$row->liq_det_importe;
                     $rem=$rem+$row->liq_det_importe;
                     $html.='<td style="border: 1px solid" align="right">'.$monto.'</td>
                             <td style="border: 1px solid"></td></tr>';
                 } else {
                     $monto=$row->liq_det_importe;
                     $c=$c-$row->liq_det_importe;
                     $desc=$desc+$row->liq_det_importe;
                     $html.='<td style="border: 1px solid"></td>
                            <td style="border: 1px solid" align="right;background-color: #eee; border: 1px solid #ccc;" >'.$monto.'</td></tr>';
                 }}
                 $html.='

          </tbody>
       </table>

      </td>
    </tr>
    </table>


    </td>
    <td style="width: 50%;">

    <table>
    <tr>
      <td>
        <table style="width:100%;border: 1px solid;border-collapse:collapse;border-padding:25px">
          <tr>
            <th>REPARTICION: CAJA DE JUBILACIONES Y PENSIONES DE LA MUNICIPALIDAD DE GUALEGUAY</th>
            <th></th>
          </tr>
          <tr>
            <th>DOMICILIO: 1° ENTRERRIANO N° 90 - GUALEGUAY - ENTRE RIOS       C.U.I.L. N° 33-67105652-9</th>
            <th></th>
          </tr>
        </table>
        <br>
        <table style="width:100%;border: 1px solid;border-collapse:collapse;">
          <tr>
            <td style="border: 1px solid"  align="center"><strong>APELIDO Y NOMBRE</strong></td>
            <td style="border: 1px solid"  align="center"><strong>LEGAJO</strong></td>
            <td style="border: 1px solid"  align="center"><strong>FECHA INGRESO</strong></td>
            <td style="border: 1px solid"  align="center"><strong>RECIBO N°</strong></td>
          </tr>
          <tr>
              <td style="border: 1px solid"  align="center"><strong>'.$recibosdatos_emp->legajo_apellido . ',' . $recibosdatos_emp->legajo_nombres.'</strong></td>
              <td style="border: 1px solid"  align="center"><strong>'.$recibosdatos_emp->legajo_id.'</strong></td>
              <td style="border: 1px solid"><strong>'.$recibosdatos_emp->legajo_fecing.'</strong></td>
              <td style="border: 1px solid"><strong>'.$recibosdatos_emp->legajo_id.'</strong></td>
          </tr>
        </table>

       <table style="width:100%;padding:25px;border: 1px solid;border-collapse:collapse;margin-bottom: 10px">
         <tr>
           <td style="border: 1px solid;" align="center"><strong>BENEFICIO</strong></td>
           <td style="border: 1px solid;" align="center"><strong>TIPO Y N° DOCUMENTO</strong></td>

           <td style="border: 1px solid;" align="center"><strong>MES DE PAGO</strong></td>

         </tr>
         <tr>
             <th style="border: 1px solid;" align="center">'.$recibosdatos_emp->legajo_tipo_nombre.'</th>
             <th style="border: 1px solid;" align="center">'.$recibosdatos_emp->doctipo_abreviacion.":".$recibosdatos_emp->legajo_nrodocto.'</th>

             <th style="border: 1px solid;" align="center">'.$fec.'</th>

         </tr>
       </table>
       <br>
       <table style="width:100%;padding:5px;border: 1px solid;border-collapse:collapse" >
          <thead>
            <tr style="padding:5px;border: 1px solid" >
              <th style="padding:5px;border: 1px solid">COD</th>
              <th style="padding:5px;border: 1px solid">DESCRIPCION DE CONCEPTOS</th>
              <th style="padding:5px;border: 1px solid">REMUNERACIONES EXENTAS</th>
              <th style="padding:5px;border: 1px solid">DESCUENTOS</th>
            </tr>
          </thead>
          <tbody>';

                $c=0;$desc=0;$rem=0;$monto=0;
                foreach($recibosdatos as $row){
                $html.='<tr><td style="border: 1px solid">'.$row->liqcod_jub_id.'</td>
                <td style="border: 1px solid">'.$row->liq_det_detconcep.'</td>';
                if($row->impacto=="+"){
                     $monto=$row->liq_det_importe;
                     $c=$c+$row->liq_det_importe;
                     $rem=$rem+$row->liq_det_importe;
                     $html.='<td style="border: 1px solid" align="right">'.$monto.'</td>
                             <td style="border: 1px solid"></td></tr>';
                 } else {
                     $monto=$row->liq_det_importe;
                     $c=$c-$row->liq_det_importe;
                     $desc=$desc+$row->liq_det_importe;
                     $html.='<td style="border: 1px solid"></td>
                            <td style="border: 1px solid" align="right;background-color: #eee; border: 1px solid #ccc;" >'.$monto.'</td></tr>';
                 }}
                 $html.='


          </tbody>
       </table>

      </td>
    </tr>
    </table>
    </td>
  </tr>
</table>
';

$html1='<footer style="height:100px;">
<table>
  <tr>
    <td style="width: 50%;">
      <tr style="border: 1px solid">
          <th >GUALEGUAY</th>
          <th></th>
          <th align="right" style="border: 1px solid">TOTAL NETO</th>
          <th style="border: 1px solid" align="right">'.$c.'</th>
      </tr>
      <tr>
         <th>SON PESOS</th>
         <th></th>
         <th></th>
         <th>______________________</th>
      </tr>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>FIRMA</th>
      </tr>
    </td>
    <td >
      <tr style="border: 1px solid">
          <th >GUALEGUAY</th>
          <th></th>
          <th align="right" style="border: 1px solid">TOTAL NETO</th>
          <th style="border: 1px solid" align="right">'.$c.'</th>
      </tr>
      <tr>
         <th>SON PESOS</th>
         <th></th>
         <th></th>
         <th>______________________</th>
      </tr>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>FIRMA</th>
      </tr>
    </td>

  <tr>
</table>
  </footer>
';

$css = file_get_contents('includes/css/expediente-pasar-comprobante.css');

//$mpdf->showImageErrors = true;

$mpdf->writeHTML($css, 1);
$mpdf->SetFooter($html1);


$mpdf->AddPage('L','','','','',10,10,15,5,0,0);
$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

$mpdf->WriteHTML($html, 2);

$mpdf->Output("prueba.pdf", 'D');
exit;

  ?>
