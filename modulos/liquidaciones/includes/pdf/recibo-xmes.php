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
         <tr>
          <td style="border: 1px solid;" align="center"><strong></strong></td>
           <td style="border: 1px solid;" align="center"><strong>N° CUENTA</strong></td>
           <td style="border: 1px solid;" align="center"><strong>FECHA DE PAGO</strong></td>
         </tr>
         <tr>
           <td></td>
           <td style="border: 1px solid;" align="center"><strong>'.$recibosdatos_emp->sucursal."-".$recibosdatos_emp->numero_cuenta.'</strong></td>
           <td style="border: 1px solid;" align="center"><strong>'.$recibosdatos_emp->sucursal.'</strong></td>
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
                $pos=0;$neg=0;
                foreach($recibosdatos as $row){
                $html.='<tr><td style="border: 1px solid" height="15px" align="right">'.$row->liqcod_jub_id.'</td>
                <td style="border: 1px solid">'.$row->liq_det_detconcep.'</td>';
                if($row->impacto=="+"){
                     $html.='<td style="border: 1px solid" align="right">'.$row->liq_det_importe.'</td>
                             <td style="border: 1px solid"></td></tr>';
                    if($row->liqcod_jub_id==600){$pos=$row->liq_det_importe;}
                  } else {

                     $html.='<td style="border: 1px solid"></td>
                            <td style="border: 1px solid" align="right">'.$row->liq_det_importe.'</td></tr>';
                     if($row->liqcod_jub_id==601){$neg=$row->liq_det_importe;}
                  }}
                 $html.='<tr>
                 <td style="border: 1px solid" height="500px"></td>
                 <td style="border: 1px solid"></td>
                 <td style="border: 1px solid"></td>
                 <td style="border: 1px solid"></td>
                 </tr>
                 <tr style="border: 1px solid">
                     <th>Recibí conforme el importe neto de esta liquidación por el período indicado, dejando constancia de haber recibido copia fiel de este recibo</th>
                     <th>TOTALES</th>
                     <th align="right" style="border: 1px solid">'.$pos.'</th>
                     <th style="border: 1px solid" align="right">'.$neg.'</th>
                 </tr>
                 <tr style="border: 1px solid">
                     <th >GUALEGUAY</th>
                     <th ></th>
                     <th align="right" style="border: 1px solid">TOTAL NETO</th>
                     <th style="border: 1px solid" align="right">'.$pos-$neg.'</th>
                 </tr>

                 <tr>
                    <th>SON PESOS</th>
                    <th></th>
                    <th></th>
                    <th></th>
                 </tr>
                 <tr>
                   <th></th>
                   <th></th>
                   <th></th>
                   <th></th>
                 </tr>

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
         <tr>
          <td style="border: 1px solid;" align="center"><strong></strong></td>
           <td style="border: 1px solid;" align="center"><strong>N° CUENTA</strong></td>
           <td style="border: 1px solid;" align="center"><strong>FECHA DE PAGO</strong></td>
         </tr>
         <tr>
           <td></td>
           <td style="border: 1px solid;" align="center"><strong>'.$recibosdatos_emp->sucursal."-".$recibosdatos_emp->numero_cuenta.'</strong></td>
           <td style="border: 1px solid;" align="center"><strong>'.$recibosdatos_emp->sucursal.'</strong></td>
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
                $html.='<tr><td style="border: 0px solid" align="right">'.$row->liqcod_jub_id.'</td>
                <td style="border: 0px solid">'.$row->liq_det_detconcep.'</td>';
                if($row->impacto=="+"){
                     if($row->liq_det_detconcep==600){$pos=$row->liq_det_importe;}
                     if($row->liq_det_detconcep==601){$neg=$row->liq_det_importe;}
                     $monto=$row->liq_det_importe;
                     $c=$c+$row->liq_det_importe;
                     $rem=$rem+$row->liq_det_importe;
                     $html.='<td style="border: 0px solid" align="right">'.$monto.'</td>
                             <td style="border: 0px solid"></td></tr>';
                 } else {
                     $monto=$row->liq_det_importe;
                     $c=$c-$row->liq_det_importe;
                     $desc=$desc+$row->liq_det_importe;
                     $html.='<td style="border: 0px solid"></td>
                             <td style="border: 0px solid" align="right">'.$monto.'</td></tr>';
                 }}
                 $html.='
                 <tr style="border: 1px solid">
                 <td style="border: 0px solid" height="500px"></td>
                 <td style="border: 0px solid"></td>
                 <td style="border: 0px solid"></td>
                 <td style="border: 0px solid"></td>
                 </tr>
                 <tr style="border: 1px solid">
                     <th></th>
                     <th>TOTALES</th>
                     <th align="right" style="border: 1px solid">'.$pos.'</th>
                     <th style="border: 1px solid" align="right">'.$neg.'</th>
                 </tr>
                 <tr style="border: 1px solid">
                     <th>Recibí conforme el importe neto de esta liquidación por el período indicado, dejando constancia de haber recibido copia fiel de este recibo</th>
                     <th>TOTALES</th>
                     <th align="right" style="border: 1px solid">'.$pos.'</th>
                     <th style="border: 1px solid" align="right">'.$neg.'</th>
                 </tr>
                 <tr style="border: 1px solid">
                     <th >GUALEGUAY</th>
                     <th ></th>
                     <th align="right" style="border: 1px solid">TOTAL NETO</th>
                     <th style="border: 1px solid" align="right">'.$pos-$neg.'</th>
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

          </tbody>
       </table>

      </td>
    </tr>
    </table>
    </td>
  </tr>
</table>
';


$css = file_get_contents('includes/css/liquidaciones.css');

//$mpdf->showImageErrors = true;

$mpdf->writeHTML($css, 1);
//$mpdf->SetFooter($html1);

$mpdf->AddPage('L','','','',5,5,5,5,1,0,0);
$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

$mpdf->WriteHTML($html, 2);

$mpdf->Output("recibo_".$recibosdatos_emp->legajo_apellido ."_".$recibosdatos_emp->legajo_nombres.".pdf", 'D');
exit;

?>
