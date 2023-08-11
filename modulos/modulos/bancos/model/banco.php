<?php
class Banco{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
			$this->cnw = Conexion::getConnectionw();
		}
		catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		$db;
		$this->cn;
	}
	public function PeriodoActualObtener(){
		try{
			$sql = $this->cn->prepare("SELECT periodo_id,
																				periodo_nombre,
																				periodo_presentismo_f
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function BancoBersaCredImportarExe($data){
		try{

			$sql = 'INSERT INTO bancos_creditos (banco_id,
																				 	 legempleado_numerol,
																				 	 legempleado_nrodocto,
																				 	 legempleado_cuil,
																				 	 periodo_id,
																				 	 bco_credito_importe,
																				 	 bco_credito_cuotas,
																				 	 bco_credito_archivo_nombre,
																				 	 bco_credito_linea_completa,
																					 bco_credito_estado)
																	  VALUES(1,
																				 	 :legempl,
																				 	 :ndoc,
																				 	 :ncuil,
																				 	 :periodo,
																				 	 :bcoimporte,
																				 	 :bcocuotas,
																				 	 :bcoarchnom,
																				 	 :bcolincom,
																				 	 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':legempl', $data->Bcolegnumerol, PDO::PARAM_STR);
			$dec->bindValue(':ndoc', $data->Bconrodocto, PDO::PARAM_STR);
			$dec->bindValue(':ncuil', $data->Bconrocuil, PDO::PARAM_STR);
			$dec->bindValue(':periodo', $data->Bcoperiodo, PDO::PARAM_STR);
			$dec->bindValue(':bcoimporte', $data->Bcoimporte, PDO::PARAM_STR);
			$dec->bindValue(':bcocuotas', $data->Bcocuotas, PDO::PARAM_STR);
			$dec->bindValue(':bcoarchnom', $data->Bcoarchivonom, PDO::PARAM_STR);
			$dec->bindValue(':bcolincom', $data->Bcolineacompleta, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function BersaCreditosListar($periodoid){
		try{
			$sql = 'SELECT *
								FROM bancos_creditos
							 WHERE periodo_id = ?
								 AND bco_credito_estado > 0';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function WaldbottBersaCreditosReset(){
		try{
			$sql = 'UPDATE HORAS
								 SET HORAS82 = ?';
			$dec = $this->cnw->prepare($sql);
			$dec->bindValue(1, 0, PDO::PARAM_INT);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function BersaCreditosPaseALiqExe($data){
		try{
			$sql = 'UPDATE HORAS
								 SET HORAS82 = ?
							 WHERE EMPLEADO = ?';
			$dec = $this->cnw->prepare($sql);
			$dec->bindValue(1, $data->BcoImporte, PDO::PARAM_INT);
			$dec->bindValue(2, $data->Bcolegajo, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//------------CODIGO VIEJO
	public function ObtenerLiquidacion($nrodocto,$periodoid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
								 AND periodo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleado($nrodocto){
		try{
			$sql = 'SELECT legempleado_numerol,
										 legempleado_apellido,
										 legempleado_nombres
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerBeneficiario($nrodocto){
		try{
			$sql = 'SELECT leghijo_benapellido,
										 leghijo_bennombres
								FROM legajos_hijo
							 WHERE leghijo_benndoc = ?
					  ORDER BY leghijo_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLiquidacionCodxTipo($liqcodid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcodtipo_id = ?
							   AND liqcod_estado = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcodid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLiquidacionCodxId($liqcodid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcod_id = ?
							   AND liqcod_estado = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcodid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionDescuentosExe($data){
		try{

			$sql = 'INSERT INTO liquidaciones (liqtipo_id,
																				 legempleado_nrodocto,
																				 liquidacion_nrodocto,
																				 liquidacion_titular,
																				 liqcod_id,
																				 liqcod_descripcion,
																				 liquidacion_cantidad,
																				 liqcodtipo_id,
																				 liquidacion_importe,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 :titular,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :liqcodtip,
																				 :imptotal,
																				 :periodoid,
																				 :observacion,
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Liqdescndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->Liqdescndoc, PDO::PARAM_STR);
			$dec->bindValue(':titular', $data->Liqdesctitular, PDO::PARAM_STR);
			$dec->bindValue(':liqcod', $data->Liqdesccodigo, PDO::PARAM_STR);
			$dec->bindValue(':liqdescripcion', $data->Liqdesccoddescripcion, PDO::PARAM_STR);
			$dec->bindValue(':canttotal', 1, PDO::PARAM_STR);
			$dec->bindValue(':liqcodtip', $data->Liqdesccodtipo, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $data->Liqdescimporte, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->Liqdescperiodo, PDO::PARAM_STR);
			$dec->bindValue(':observacion', $data->Liqdescobs, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoXLegajoObtener($legajo_numero){
		try{
			$sql = 'SELECT *
								FROM legajos_empleado
							 WHERE legempleado_numerol = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $legajo_numero, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionesImportarExe($data){
		try{

			$sql = 'INSERT INTO liquidaciones (liqtipo_id,
																				 legempleado_nrodocto,
																				 liquidacion_nrodocto,
																				 legempleado_numerol,
																				 liquidacion_titular,
																				 liqcod_id,
																				 liqcod_descripcion,
																				 liquidacion_cantidad,
																				 liqcodtipo_id,
																				 liquidacion_importe,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(1,
																				 :empnrodocto,
																				 :bennrodocto,
																				 :legnuml,
																				 1,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :codtipo,
																				 :imptotal,
																				 :periodo,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->Nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':legnuml', $data->LegajoNumero, PDO::PARAM_STR);
			$dec->bindValue(':liqcod', $data->Liqcod, PDO::PARAM_STR);
			$dec->bindValue(':liqdescripcion', $data->Liqcoddesc, PDO::PARAM_STR);
			$dec->bindValue(':canttotal', $data->Liqcantidad, PDO::PARAM_STR);
			$dec->bindValue(':codtipo', $data->Liqcodtipo, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $data->Liqimporte, PDO::PARAM_STR);
			$dec->bindValue(':periodo', $data->PeriodoA, PDO::PARAM_STR);


			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SeguroAutarquicoDatos(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM liquidaciones
																	WHERE (liqcod_id = 351
																		 OR liqcod_id = 352
																		 OR liqcod_id = 378
																		 OR liqcod_id = 382)
															 ORDER BY legempleado_nrodocto");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IOSPERDatos(){
		try{
			/*$sql = $this->cn->prepare("SELECT *
																	 FROM liquidaciones
																	WHERE (liqcod_id = 351
																		 OR liqcod_id = 352
																		 OR liqcod_id = 378
																		 OR liqcod_id = 382)
															 ORDER BY legempleado_nrodocto");*/
		 	$sql = $this->cn->prepare("SELECT DISTINCT legempleado_nrodocto
																	 					FROM liquidaciones
																					 WHERE liqcod_id = 333");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionEmpleadoDniObtener($periodoid){
		try{
			$sql = 'SELECT DISTINCT legempleado_nrodocto,
															legempleado_numerol
												 FROM liquidaciones
							 				  WHERE periodo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SRemunerativoObtener($numdocto){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS remunimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcodtipo_id = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SNoRemunerativoObtener($numdocto){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS noremunimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcodtipo_id = 3
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescuentosObtener($numdocto){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS descuentosimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcodtipo_id = 4
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SACObtener($numdocto){
		try{
			$sql = 'SELECT liquidacion_importe
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcod_id = 188
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
			/*$datos = $dec->fetch(PDO::FETCH_OBJ);
			if($datos > 0){
				return $datos;
			}else{
				return 0;
			}*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function JubilacionObtener($numdocto){
		try{
			$sql = 'SELECT liquidacion_importe as jubilacionimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcod_id = 330
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoObtener($numdocto){
		try{
			$sql = 'SELECT *
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoResumenObtener($numdocto){
		try{
			$sql = 'SELECT legempleado_numerol,
										 legempleado_apellido,
										 legempleado_nombres
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionCodigoObtner($liqcod){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcod_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcod, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionCodigoYDNIObtner($nrodocto, $liqcod){
		try{
			$sql = 'SELECT liquidacion_importe
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcod_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $liqcod, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LegajoTipoObtener($legtipoid){
		try{
			$sql = 'SELECT legtipo_nombre
								FROM legajos_tipo
							 WHERE legtipo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $legtipoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
