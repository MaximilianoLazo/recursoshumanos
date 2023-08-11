<?php
    error_reporting(0);
    session_start();
    if(!isset($_SESSION['usuario_id'])){
      header('Location: ../login/index.php');
    }

$id = $_GET['Id'];

$recibosdatos= $this->model->ListarRecibo($id);
$recibosdatos_emp= $this->model->JubiladoObtenerLeg($id);
$cantidadrecibos=count($recibosdatos);
$per=$this->model->CJMDGPeriodoObtener();

?>

<div class="row">
  	<div class="col-md-12">
    	<div id="no-more-tables">
      		<div class="table-wrapper-scroll-y my-custom-scrollbar">
      			<div class="row">

						<table class="data-table table-bordered stripe hover nowrap">
						<tr>
							<th><?php echo "REPARTICION  CAJA DE JUBILACIONES Y PENSIONES DE LA MUNICIPALIDAD DE GUALEGUAY" . "<br>". "DOMICILIO 1er.ENTRERRIANO N° 90 - GUALEGUAY -  ENTRE RIOS " ; ?></th>
	             <th><?php echo "<br>"."C.U.I.L. N° 33-67105652-9"; ?></th>
						</tr>
						</table>
						<table class="data-table table-bordered stripe hover ">
						<tr>
							<th><?php echo "APELLIDO Y NOMBRE"; ?></th>
							<th><?php echo "LEGAJO";  ?></th>
							<th><?php echo "FECHA INGRESO"; ?></th>
              <th><?php echo "RECIBO N°"; ?></th>
						</tr>
						<tr>
							<th><?php echo $recibosdatos_emp->legajo_apellido . " " . $recibosdatos_emp->legajo_nombres; ?></th>
							<th><?php echo $recibosdatos_emp->legajo_id;  ?></th>
      				<th><?php  $fec=new datetime($recibosdatos_emp->legajo_fecing); echo $fec_pantalla=$fec->format('d/m/Y');?></th>
              <th><?php echo $recibosdatos_emp->legajo_id; ?></th>
						</tr>
          </table>
          	<table class="data-table table-bordered stripe hover ">
              <tr>
                <th><?php echo "BENEFICIO"; ?></th>
                <th><?php echo "TIPO Y N° DOCUMENTO";  ?></th>
                <th><?php echo "MES DE PAGO"; ?></th>

              </tr>
              <tr>
                <th><?php echo $recibosdatos_emp->legajo_tipo_nombre; ?></th>
                <th><?php echo $recibosdatos_emp->doctipo_abreviacion.":".$recibosdatos_emp->legajo_nrodocto;  ?></th>
                <th><?php $m=new datetime($per->periodo_hsext_jor_f); echo $m->format('F'); ?></th>
              </tr>
						</table>
						<table class="data-table table-bordered stripe hover nowrap">
						<thead>
						<tr>
							<th>COD</th>
							<th>DESCRIPCION DE CONCEPTOS</th>
					  	<th>REMUNERACIONES EXENTAS</th>
              <th>DESCUENTOS</th>
						</tr>
						</thead>
						<tbody>
              <?php
                if($cantidadrecibos!=0){?>
                  <?php $c=0;$desc=0;$rem=0;
                  foreach($recibosdatos as $row):                 ?>
                      <tr>
                        <td><?php echo $row->liqcod_jub_id ; ?></td>
                        <td><?php echo $row->liq_det_detconcep;?></td>
                        <td><?php if($row->impacto=='+'){echo $row->liq_det_importe;$c=$c+$row->liq_det_importe;$rem=$rem+$row->liq_det_importe; }   ?></td>
                        <td><?php if($row->impacto=='-'){echo '-'.$row->liq_det_importe;$c=$c-$row->liq_det_importe; $desc=$desc+$row->liq_det_importe;}?></td>
                      </tr>
                  <?php endforeach;?>
                 <tr>
                     <th></th>
                     <th align="right"><?php if($rem!=0){echo "SUBTOTALES"; }?></th>
                     <th><?php if($rem!=0){echo $rem;} ?></th>
                     <th><?php if($desc!=0){echo $desc;} ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th></th>
                   <th align="right"><?php if($desc!=0){echo "TOTAL"; }?></th>
                   <th><?php if($c!=0){echo $c;} ?></th>
             </tr>
             <?php } ?>
						</tbody>
						</table>

				</div>
     		</div>
   		</div>
  	</div>
</div>
