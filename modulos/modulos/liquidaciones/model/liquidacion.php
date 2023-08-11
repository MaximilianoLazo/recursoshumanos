<?php
class Liquidacion{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}
		catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		$db;
		$this->cn;
	}
	//--------Incio Codigos nuevos y revisados-------------
	public function GetDatos($sentencia){
		try{
			$sql = $this->cn->prepare("$sentencia");
			$sql->execute();
			//return $sql->fetch(PDO::FETCH_OBJ);
			$importe = $sql->fetch(PDO::FETCH_OBJ);;
			return $importe->importe;
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoLegajoTipoObtener($legtipoid){
		try{
			$sql = 'SELECT *
								FROM legajos_empleado
							 WHERE legtipo_id = ?
							 	 AND legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $legtipoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesRemunerativosObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS hremimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
								 AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 1
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesRemunerativos_AE_UPDATE($empndoc,$benndoc,$importe){
		try{

			$sql = 'UPDATE liquidaciones SET liquidacion_importe = ?
																 WHERE liqcod_id = 845
																 	 AND legempleado_nrodocto = ?
																 	 AND liquidacion_nrodocto = ?
																	 AND liqtipo_id = 6';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $importe, PDO::PARAM_STR);
			$stm->bindValue(2, $empndoc, PDO::PARAM_STR);
			$stm->bindValue(3, $benndoc, PDO::PARAM_STR);

			$stm->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesFamiliaresObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS asigfamimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 2
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesFamiliaresObtener_AE_UPDATE($empndoc,$benndoc,$importe){
		try{

			$sql = 'UPDATE liquidaciones SET liquidacion_importe = ?
																 WHERE liqcod_id = 486
																 	 AND legempleado_nrodocto = ?
																 	 AND liquidacion_nrodocto = ?
																	 AND liqtipo_id = 6';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $importe, PDO::PARAM_STR);
			$stm->bindValue(2, $empndoc, PDO::PARAM_STR);
			$stm->bindValue(3, $benndoc, PDO::PARAM_STR);

			$stm->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesNoRemunerativosObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS hnoremimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 3
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesNoRemunerativosObtener_AE_UPDATE($empndoc,$benndoc,$importe){
		try{

			$sql = 'UPDATE liquidaciones SET liquidacion_importe = ?
																 WHERE liqcod_id = 487
																 	 AND legempleado_nrodocto = ?
																 	 AND liquidacion_nrodocto = ?
																	 AND liqtipo_id = 6';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $importe, PDO::PARAM_STR);
			$stm->bindValue(2, $empndoc, PDO::PARAM_STR);
			$stm->bindValue(3, $benndoc, PDO::PARAM_STR);

			$stm->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescuentosObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS descimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 4
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescuentosObtener_AE_UPDATE($empndoc,$benndoc,$importe){
		try{

			$sql = 'UPDATE liquidaciones SET liquidacion_importe = ?
																 WHERE liqcod_id = 488
																 	 AND legempleado_nrodocto = ?
																 	 AND liquidacion_nrodocto = ?
																	 AND liqtipo_id = 6';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $importe, PDO::PARAM_STR);
			$stm->bindValue(2, $empndoc, PDO::PARAM_STR);
			$stm->bindValue(3, $benndoc, PDO::PARAM_STR);

			$stm->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoObtener_AE($empndoc,$benndoc,$periodoid){
		try{
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_uno
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 1
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_uno = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_dos
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 2
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_dos = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_tres
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 3
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_tres = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_cuatro
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 AND liqtipo_id = 6
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 4
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_cuatro = $dec->fetch(PDO::FETCH_OBJ);
			////////////////////////////////////////////////////
			$importe_neto = $datos_uno->importe_uno +
											$datos_dos->importe_dos +
											$datos_tres->importe_tres -
											$datos_cuatro->importe_cuatro;

			return $importe_neto;



		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoObtener_AE_UPDATE($empndoc,$benndoc,$importe){
		try{

			$sql = 'UPDATE liquidaciones SET liquidacion_importe = ?
																 WHERE liqcod_id = 484
																 	 AND legempleado_nrodocto = ?
																 	 AND liquidacion_nrodocto = ?
																	 AND liqtipo_id = 6';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $importe, PDO::PARAM_STR);
			$stm->bindValue(2, $empndoc, PDO::PARAM_STR);
			$stm->bindValue(3, $benndoc, PDO::PARAM_STR);

			$stm->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionesCodigosAutomaticos(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM liquidaciones_codigo
																	WHERE liqcod_automatico = 1
																		AND liqcod_estado = 1");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionTipoObtener($liqtipoid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_tipos
							 WHERE liqtipo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqtipoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PalabrasReservadasObtener($campo){
		try{
			$sql = $this->cn->prepare("SELECT $campo
																	 FROM liquidaciones_palabras_reservadas
																	WHERE liqpr_estado = 1");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//--------FinCodigos nuevos y revisados-------------
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
	public function ObtenerLiquidacion($nrodocto,$periodoid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
								 AND liqtipo_id = 6';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			//$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleado($nrodocto){
		try{
			$sql = 'SELECT legempleado_apellido,
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
	public function EmpleadoObtener_APYNOM($nrodocto){
		try{
			$sql = 'SELECT legempleado_apellido,
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
							 WHERE liqcod_estado = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, 1, PDO::PARAM_STR);
			//$dec->bindValue(1, $liqcodid, PDO::PARAM_STR);
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
	public function LiquidacionBenUlObtener($liqndoc){
		try{
			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
							   AND liqtipo_id = 6
						ORDER BY liquidacion_id
								DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqndoc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionCodObtener($liqcodtipoid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcodtipo_id = ?
							   AND liqcod_estado = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcodtipoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionDescuentosExe($data){
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 :titular,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :liqcodtip,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 :observacion,
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Empnrodocto, PDO::PARAM_STR);
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
	public function LiquidacionHaberesExe($data){
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(:liqtipoid,
																				 :empnrodocto,
																				 :bennrodocto,
																				 :nlegajo,
																				 :titular,
																				 :liqcod,
																				 :liqdesc,
																				 :canttotal,
																				 :liqcodtip,
																				 :imptotal,
																				 :ccosto,
																				 :periodoid,
																				 :observacion,
																			 	 :estado)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':liqtipoid', $data->LiqTipo, PDO::PARAM_STR);
			$dec->bindValue(':empnrodocto', $data->Empndoccc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->Liqndoc, PDO::PARAM_STR);
			$dec->bindValue(':nlegajo', $data->Empnleg, PDO::PARAM_STR);
			$dec->bindValue(':titular', $data->LiqTitular, PDO::PARAM_STR);
			$dec->bindValue(':liqcod', $data->Habercodliq, PDO::PARAM_STR);
			$dec->bindValue(':liqdesc', $data->Liqdesccoddescripcion, PDO::PARAM_STR);
			$dec->bindValue(':canttotal', $data->Liqcantidad, PDO::PARAM_STR);
			$dec->bindValue(':liqcodtip', $data->Liqdesccodtipo, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $data->Haberimporte, PDO::PARAM_STR);
			$dec->bindValue(':ccosto', $data->Liqccosto, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->Liqperiodoid, PDO::PARAM_STR);
			$dec->bindValue(':observacion', $data->Liqobs, PDO::PARAM_STR);
			$dec->bindValue(':estado', $data->Liqest, PDO::PARAM_STR);
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
																				 ccosto_codigo,
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
																				 0,
																				 :periodo,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->Benndocto, PDO::PARAM_STR);
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
	public function LiquidacionesCodImportarExe($data){
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 :legnuml,
																				 2,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :codtipo,
																				 :imptotal,
																				 0,
																				 :periodo,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->Benndocto, PDO::PARAM_STR);
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
	public function AyudaEscolarImportarExe($data){
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(:liqtipoid,
																				 :empnrodocto,
																				 :bennrodocto,
																				 :legnuml,
																				 1,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :codtipo,
																				 :imptotal,
																				 0,
																				 :periodo,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':liqtipoid', $data->Liqtipoid, PDO::PARAM_STR);
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
	public function SeguroAutarquicoDatos($periodoid){
		try{

			$sql = 'SELECT *
							  FROM liquidaciones
							 WHERE (liqcod_id = 351
								 OR liqcod_id = 352
								 OR liqcod_id = 378
								 OR liqcod_id = 382)
								AND periodo_id = ?
					 ORDER BY legempleado_nrodocto';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IOSPERDatos($periodoid){
		try{

			$sql = 'SELECT DISTINCT legempleado_nrodocto
								FROM liquidaciones
							 WHERE liqcod_id = 333
							 	 AND periodo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
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
	public function SRemunerativoObtener($numdocto, $periodoid){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS remunimp
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
							 	 AND liqcodtipo_id = 1
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SRemunerativoObtener_AY($numdocto, $periodoid){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS remunimp
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
							 	 AND liqcodtipo_id = 1
								 AND periodo_id = ?
								 AND liquidacion_id > 61036
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SNoRemunerativoObtener($periodoid){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS noremunimp
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
							 	 AND liqcodtipo_id = 3
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesFamiliaresObtener($numdocto){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS asigfamimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcodtipo_id = 2
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescuentosObtener($numdocto, $periodoid){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS descuentosimp
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
							 	 AND liqcodtipo_id = 4
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SACObtener($numdocto, $periodoid){
		try{
			$sql = 'SELECT liquidacion_importe
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
							 	 AND liqcod_id = 188
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
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
	public function JubilacionObtener($numdocto, $periodoid){
		try{
			$sql = 'SELECT liquidacion_importe as jubilacionimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcod_id = 330
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
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
	public function LiquidacionCodigoYDNIObtener($nrodocto, $liqcod, $periodoid){
		try{
			$sql = 'SELECT liquidacion_importe
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
							 	 AND liqcod_id = ?
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $liqcod, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
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
	public function SueldoBasicoObtener($periodoid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE periodo_id = ?
							 	 AND (liqcod_id = 1
								  OR liqcod_id = 2)
						ORDER BY legempleado_nrodocto';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
