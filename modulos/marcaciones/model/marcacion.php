<?php
class Marcacion{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandaListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
				 													 FROM marcaciones_tanda
																	WHERE (mtanda_estado = 1 OR mtanda_estado = 2)
															 ORDER BY mtanda_fecha_proceso");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandaArchivoListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
				 													 FROM marcaciones_tanda
																	WHERE mtanda_estado = 3
															 ORDER BY mtanda_fecha_proceso");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandaGuardarExe($data){
		try{

			$sql = 'INSERT INTO marcaciones_tanda (mtanda_nombre,
																						 mtanda_fecha_desde,
																		 				 mtanda_fecha_hasta,
																						 mtanda_fecha_proceso,
																						 mtanda_archivo,
																						 mtanda_estado)
																		  VALUES(:tnombre,
																					   :tfecdesde,
																					   :tfechasta,
																					   :tfecproceso,
																						 "",
																				 	   1)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':tnombre', $data->FTEnombre, PDO::PARAM_STR);
			$dec->bindValue(':tfecdesde', $data->FTEfecdesde, PDO::PARAM_STR);
			$dec->bindValue(':tfechasta', $data->FTEfechasta, PDO::PARAM_STR);
			$dec->bindValue(':tfecproceso', $data->FTEfecproceso, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandaActualizar($data){
		try{

			$sql = 'UPDATE marcaciones_tanda SET mtanda_nombre = ?,
																					 mtanda_fecha_desde = ?,
																					 mtanda_fecha_hasta = ?,
																					 mtanda_fecha_proceso = ?,
																					 mtanda_estado = 1
																	 	 WHERE mtanda_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->FTEnombre, PDO::PARAM_STR);
			$dec->bindValue(2, $data->FTEfecdesde, PDO::PARAM_STR);
			$dec->bindValue(3, $data->FTEfechasta, PDO::PARAM_STR);
			$dec->bindValue(4, $data->FTEfecproceso, PDO::PARAM_STR);
			$dec->bindValue(5, $data->FTEid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandasDetallesObtener($id){
		try{
		$sql = 'SELECT a.mtanda_detalle_id,
									 a.legempleado_nrodocto,
									 b.legempleado_apellido,
									 b.legempleado_nombres,
									 c.trabajo_nombre,
									 d.secretaria_nombre,
									 e.reloj_nombre
							FROM marcaciones_tanda_detalles a
	 LEFT OUTER JOIN legajos_empleado b
								ON a.legempleado_nrodocto = b.legempleado_nrodocto
	 LEFT OUTER JOIN lugares_trabajo c
								ON a.trabajo_id = c.trabajo_id
	 LEFT OUTER JOIN secretarias d
								ON a.secretaria_id = d.secretaria_id
	 LEFT OUTER JOIN relojes e
								ON a.reloj_id = e.reloj_id
						 WHERE a.mtanda_id = ?
						 	 AND a.mtanda_detalle_estado = 1';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $id, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoObtener($nrodocto){
		try{
			$sql = 'SELECT *
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
	public function ContratadoObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_contrato
							 WHERE legempleado_nrodocto = ?
							   AND legcontrato_activo = 1
						ORDER BY legcontrato_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function JornaleroObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_jornalero
							 WHERE legempleado_nrodocto = ?
							   AND legjornalero_activo = 1
						ORDER BY legjornalero_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PPermanenteObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_ppermanente
							 WHERE legempleado_nrodocto = ?
							   AND legppermanente_activo = 1
						ORDER BY legppermanente_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ProveedorObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_proveedor
							 WHERE legempleado_nrodocto = ?
							   AND legproveedor_activo = 1
						ORDER BY legproveedor_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoXRelojObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_reloj
							 WHERE legempleado_nrodocto = ?
							   AND legreloj_activo = 1
						ORDER BY legreloj_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandaImportarExe($data){
		try{

			$sql = 'INSERT INTO marcaciones_tanda_detalles (mtanda_id,
																										  legempleado_nrodocto,
																		 							 	  trabajo_id,
																										  secretaria_id,
																										  reloj_id,
																									 	  mtanda_detalle_estado)
																							 VALUES(:mtandaid,
																										  :empndoc,
																										  :trabajoid,
																										  :secid,
																										  :relojid,
																									 	  1)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':mtandaid', $data->Mtandaid, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $data->Empndoc, PDO::PARAM_STR);
			$dec->bindValue(':trabajoid', $data->Trabajoid, PDO::PARAM_STR);
			$dec->bindValue(':secid', $data->Secretariaid, PDO::PARAM_STR);
			$dec->bindValue(':relojid', $data->Relojid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function FichadasTandaDetallesBajaExe($data){
		try{

			$sql = 'UPDATE marcaciones_tanda_detalles SET mtanda_detalle_estado = 0
																	 						WHERE mtanda_detalle_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->MTDetallesid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandaArchviarExe($data){
		try{

			$sql = 'UPDATE marcaciones_tanda SET mtanda_estado = 3
																	 	 WHERE mtanda_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->MTid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandasXFechaListar($fecha_actual){
		try{
			$sql = 'SELECT *
								FROM marcaciones_tanda
							 WHERE mtanda_fecha_proceso = ?
							   AND mtanda_estado = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $fecha_actual, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandasDetallesIdFilasNum($fictandaid){
		try{

			$sql = 'SELECT COUNT(a.mtanda_detalle_id) AS tandadetallec
								FROM marcaciones_tanda_detalles a
					INNER JOIN legajos_empleado b
			 					  ON a.legempleado_nrodocto = b.legempleado_nrodocto
							 WHERE a.mtanda_id = ?
								 AND a.mtanda_detalle_estado = 1
						ORDER BY a.legempleado_nrodocto';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $fictandaid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandasDetallesDNIFilasNum($tandaid, $nrodocto){
		try{

			$sql = 'SELECT COUNT(a.mtanda_detalle_id) AS tandadetallec
								FROM marcaciones_tanda_detalles a
					INNER JOIN legajos_empleado b
			 					  ON a.legempleado_nrodocto = b.legempleado_nrodocto
							 WHERE a.mtanda_id = ?
							   AND a.legempleado_nrodocto = ?
								 AND a.mtanda_detalle_estado = 1
						ORDER BY a.legempleado_nrodocto';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $tandaid, PDO::PARAM_STR);
			$dec->bindValue(2, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandasDetallesXIdListar($fictandaid){
		try{
			$sql = 'SELECT a.mtanda_detalle_id,
										 a.legempleado_nrodocto,
										 b.legempleado_apellido,
										 b.legempleado_nombres
								FROM marcaciones_tanda_detalles a
					INNER JOIN legajos_empleado b
			 					  ON a.legempleado_nrodocto = b.legempleado_nrodocto
							 WHERE a.mtanda_id = ?
							   AND a.mtanda_detalle_estado = 1
						ORDER BY b.legempleado_apellido ASC,
										 b.legempleado_nombres ASC';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $fictandaid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SecretariaXIdObtener($secretariaid){
		try{

			$sql = 'SELECT *
								FROM secretarias
							 WHERE secretaria_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LTrabajoXIdObtener($trabajoid){
		try{

			$sql = 'SELECT *
								FROM lugares_trabajo
							 WHERE trabajo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RelojObtener($relojid){
		try{

			$sql = 'SELECT *
								FROM relojes
							 WHERE reloj_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $relojid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LegajoNombreXIdObtner($legtipoid){
		try{

			$sql = 'SELECT *
			 					FROM legajos_tipo
							 WHERE legtipo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $legtipoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpFicCronograma($nrodocto){
		try{

			$sql = 'SELECT *
								FROM legajos_reloj
							 WHERE legempleado_nrodocto = ?
							   AND legreloj_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FeriadosDiaObtener($fecha_sql){
		try{
			$sql = $this->cn->prepare("SELECT feriado_observacion
				 													 FROM feriados
																	WHERE feriado_fecha = '$fecha_sql'
																	  AND feriado_activo = 1
															 ORDER BY feriado_fecha");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciasDiaObtener($fechasql, $nrodocto){
		try{

			$sql = $this->cn->prepare("SELECT b.licencia_nombre
																	 FROM licencias_proceso a,
																	 			licencias b
																	WHERE a.licencia_id = b.licencia_id
																	  AND a.legempleado_nrodocto = '$nrodocto'
																	  AND a.lproceso_fecha = '$fechasql'
																		AND a.lproceso_activo = 1");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasHistoricoDiaObtener($nrodocto, $fecha){

		try{

			$sql = $this->cn->prepare("SELECT *,
																				TIME(marcacion_datetime) AS emp_fichada
																	 FROM marcaciones WHERE legempleado_nrodocto = '$nrodocto'
																	  AND DATE(marcacion_datetime) = '$fecha'
															 ORDER BY marcacion_datetime");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasTandaProcesoTerminar($res, $fictandaid){
		try{

			$sql = 'UPDATE marcaciones_tanda SET mtanda_archivo = ?,
																					 mtanda_estado = 2
																	 	 WHERE mtanda_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $res, PDO::PARAM_STR);
			$dec->bindValue(2, $fictandaid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoHelpObtener($search){
		try{

			$sql = "SELECT *
								FROM legajos_empleado
							WHERE legempleado_activo = 1
							  AND (CONCAT_WS(' ', legempleado_apellido, legempleado_nombres)
							 LIKE '%$search%'
							   OR CONCAT_WS(' ', legempleado_nombres, legempleado_apellido)
							 LIKE '%$search%')
							LIMIT 0,10";
			$stm = $this->cn->prepare($sql);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
 //--------------codigos antiguos -------------------
	public function MarcacionAutomatica($data){
		try{

			$sql = 'INSERT INTO marcaciones
			(marcacion_accessid,marcacion_datetime,mdireccion_codigo,mfuente_codigo,reloj_id)
			VALUES(?, ?, ?, ?, ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Accessid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Datetime, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Direccion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Fuente, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Relojid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarRelojes($data){
		try{
		$sql = 'SELECT * FROM relojes WHERE reloj_habilitar = ?';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $data->Habilitar, PDO::PARAM_STR);
		$stm->execute();
		return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerRelojId($relojid){
		try{
		$sql = 'SELECT * FROM relojes WHERE reloj_id = ? LIMIT 1';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $relojid, PDO::PARAM_STR);
		$stm->execute();
		return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodoActual(){
		try{
			$sql = $this->cn->prepare("SELECT periodo_id,periodo_hsext_jor_i,periodo_hsext_jor_f,periodo_cerrado FROM periodos WHERE periodo_cerrado = 0");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodoUCerrado(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerRelojNodo($nodo){
		try{
		$sql = 'SELECT * FROM relojes WHERE reloj_nodo = ? LIMIT 1';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $nodo, PDO::PARAM_STR);
		$stm->execute();
		return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEstadoReloj($estado){
		try{
		$sql = 'SELECT * FROM mestados WHERE mestado_id = ? LIMIT 1';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $estado, PDO::PARAM_STR);
		$stm->execute();
		return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerEmpleadoDatos($search){
		try{

			/*$sql = "SELECT * FROM legajos_empleado WHERE legempleado_activo = 1 AND (legempleado_apellido LIKE '%$search%' OR legempleado_nombres LIKE '%$search%') LIMIT 0,10";
			$stm = $this->cn->prepare($sql);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);*/

			$sql = "SELECT * FROM legajos_empleado WHERE legempleado_activo = 1 AND (CONCAT_WS(' ', legempleado_apellido, legempleado_nombres) LIKE '%$search%' OR CONCAT_WS(' ', legempleado_nombres, legempleado_apellido) LIKE '%$search%') LIMIT 0,10";
			$stm = $this->cn->prepare($sql);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerAccessId($nrodocto){
		try{

			$sql = 'SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = ? ORDER BY legreloj_id DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFecInicio(){
		try{
			$periodo_actual = Marcacion::PeriodoActual();
			$periodo_ucerrado = Marcacion::PeriodoUCerrado();
			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");
			$hora_actual = date("H:i:s");
			$periodoactuali = $periodo_actual->periodo_hsext_jor_i;
			$fechaactualmesnum = strftime("%m", strtotime($fecha_actual));
			$periodoactualmesnum = strftime("%m", strtotime($periodoactuali));
			if($fechaactualmesnum > $periodoactualmesnum){
				$fechainicial = $periodo_actual->periodo_hsext_jor_i;
			}else{
				$fechainicial = $periodo_ucerrado->periodo_hsext_jor_i;
			}
			return $fechainicial;
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerMarcacionesDes($fecha_inicio,$fecha_final,$accessid){
		try{

			$sql = $this->cn->prepare("SELECT * FROM marcaciones WHERE marcacion_accessid = '$accessid' AND mestado_id != 2 AND mestado_id != 3 AND DATE(marcacion_datetime) BETWEEN '$fecha_inicio' AND '$fecha_final'");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function MarcacionesReprocesarExe($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f){
		try{
				//------ obtener dias que ficha el empleado -----
				$sql = 'SELECT * FROM legajos_reloj WHERE marcacion_accessid = ? AND legreloj_activo = 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
				$stm->execute();
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				$legrelc = $stm->rowCount();
				$semanal = 1;
				if($semanal == 1){
					//----- Fecha y Hora actual -------
					date_default_timezone_set("America/Buenos_Aires");
					$fechaactual = date("Y-m-d");

					$periodoi = strtotime("$fecha_i");
					$periodof = strtotime("$fecha_f");

					//-------Recorrer fechas de periodo hasta fecha actual--------
					for($i=$periodoi; $i<=$periodof; $i+=86400){
						foreach($rows as $rowlr){

							//echo $fecha_actual."<br>";
							/*echo $marcacionaccessid."<br>";
							echo $marcaciondatetime."<br>";
							echo date("Y-m-d", $periodoi)."<br>";
							echo date("Y-m-d", $periodof)."<br>";
						  echo date("Y-m-d", $i)."<br>";
							echo "-------------"."<br>";*/

							//----- buscar marcacion de entrada
							$sql = 'SELECT * FROM marcaciones_proceso WHERE legreloj_id = ? AND marcacion_accessid = ? AND CAST(mprocesom_entrada AS DATE) = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $rowlr->legreloj_id, PDO::PARAM_STR);
							$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
							$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
							$stm->execute();
							$mprocer = $stm->fetch(PDO::FETCH_OBJ);
							$mproce = $stm->rowCount();
							//------Preguntar si ya se poroceso la entrada ------
							if($mproce == 1){
								//--------Ya esta procesada la entrada, preguntar salida
								$sql = 'SELECT * FROM marcaciones_proceso WHERE legreloj_id = ? AND marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ?';
								$stm = $this->cn->prepare($sql);
								$stm->bindValue(1, $rowlr->legreloj_id, PDO::PARAM_STR);
								$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
								$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
								$stm->execute();
								$mprocs = $stm->rowCount();
								if($mprocs == 1){
									//--- Marcacion de salida encontrada, descartar actual
									$proceso = 4;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();
								}else{
									//--- Marcacion de salida no encontrada, empezar a buscar
									$dia = strftime("%w", strtotime(date("Y-m-d", $i)));
									if($dia == 0){
										//--- Domingo ---
										/*foreach($rows as $rowlr){*/
											if($rowlr->legreloj_domingo == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion de salida--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion de salida -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion de salida no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia domingo, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 1){
										//---Lunes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_lunes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia Lunes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 2){
										//---Martes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_martes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia martes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 3){
										//---Miercoles----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_miercoles == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia miercoles, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 4){
										//---Jueves----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_jueves == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia jueves, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 5){
										//---Viernes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_viernes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia viernes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 6){
										//---Sabado----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_sabado == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia Sabado, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}else{
										//--- Default Error, descartar ---
										$proceso = 7;
										$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
										$stm = $this->cn->prepare($sql);
										$stm->bindValue(1, $proceso, PDO::PARAM_STR);
										$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
										$stm->execute();
									}
								}
							}else{
								//-------Entrada no procesada, preguntar si hay marcaciones para procesar----------
								$dia = strftime("%w", strtotime(date("Y-m-d", $i)));
								if($dia == 0){
									//---Domingo----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_domingo == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia domingo, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 1){
									//---Lunes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_lunes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}

												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia lunes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 2){
									//---Martes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_martes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia martes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 3){
									//---Miercoles----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_miercoles == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia miercoles, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 4){
									//---Jueves----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_jueves == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia jueves, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 5){
									//---Viernes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_viernes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia viernes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 6){
									//---Sabado----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_sabado == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia sabado, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}else{
									//---Default Error
									$proceso = 7;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();
								}
							}
						}/*elseif($legrelc == 2){

							//----- El empleado tiene dos turnos
							$proceso = 10;
							$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $proceso, PDO::PARAM_STR);
							$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
							$stm->execute();

						}else{
							//------ Tiene mas de dos turnos o ninguno
						}*/

					}
				}else{
				//Empleado no semanal
				}
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleadoContrato($nrodocto, $legajotipo){
		try{

			if($legajotipo == 1){
				//---Contratado---
				$sql = 'SELECT * FROM legajos_contrato WHERE legempleado_nrodocto = ? AND legcontrato_activo = 1 LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);

			}elseif($legajotipo == 2){
				//---Jornalero ---
				$sql = 'SELECT * FROM legajos_jornalero WHERE legempleado_nrodocto = ? AND legjornalero_activo = 1 LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);

			}elseif($legajotipo == 3){
				//---Planta Permanente --
				$sql = 'SELECT * FROM legajos_ppermanente WHERE legempleado_nrodocto = ? AND legppermanente_activo = 1 LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);

			}elseif($legajotipo == 4){
				//---Proveedor ---
			}elseif($legajotipo == 5){
				//---Funcionarios ---
			}elseif($legajotipo == 6){
				//---Concejo deliberante --
			}else{
				//---Defaul error ---
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerMarcacionesDia($fechasql, $nrodocto){
		try{
			$sql = $this->cn->prepare("SELECT a.mprocesop_entrada,a.mprocesop_salida,c.reloj_nombre FROM marcaciones_proceso a, relojes c WHERE a.reloj_id = c.reloj_id AND (DATE(a.mprocesom_entrada) = '$fechasql' OR DATE(a.mprocesom_salida) = '$fechasql') AND a.legempleado_nrodocto = '$nrodocto'");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListadoMarcacionesMI($seguimientoid){
		try{
			$sql = $this->cn->prepare("SELECT * FROM marcaciones WHERE relojseg_id = '$seguimientoid'");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObterEmpleadoFichadas($nrodocto){
		try{

			$sql = 'SELECT * FROM legajos_reloj WHERE legempleado_nrodocto = ? AND legreloj_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerFichadaDia($fechasql, $nrodocto){
		try{
			$sql = $this->cn->prepare("SELECT * FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1");
			$sql->execute();
			$fichadasconf = $sql->fetchAll(PDO::FETCH_OBJ);

			$dianumero = strftime("%w", strtotime("$fechasql"));
			foreach($fichadasconf as $row){
				if($dianumero == 0){
					//---dia domingo ---
					$contador = $contador + $row->legreloj_domingo;
				}elseif($dianumero == 1){
					$contador = $contador + $row->legreloj_lunes;
				}elseif($dianumero == 2){
					$contador = $contador + $row->legreloj_martes;
				}elseif($dianumero == 3){
					$contador = $contador + $row->legreloj_miercoles;
				}elseif($dianumero == 4){
					$contador = $contador + $row->legreloj_jueves;
				}elseif($dianumero == 5){
					$contador = $contador + $row->legreloj_viernes;
				}elseif($dianumero == 6){
					$contador = $contador + $row->legreloj_sabado;
				}else{
					//error
				}
			}
			return $contador;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFeriado($fechasql){
		try{
			//----- Listado de feriados con filtro de año actual -----
			date_default_timezone_set("America/Buenos_Aires");
			$año = date("Y");
			$sql = $this->cn->prepare("SELECT feriado_observacion FROM feriados WHERE YEAR(feriado_fecha) = '$año' AND feriado_fecha = '$fechasql' AND feriado_activo=1 ORDER BY feriado_fecha");
			$sql->execute();

		return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFeriadosDia($fechasql){
		try{

			$sql = $this->cn->prepare("SELECT feriado_observacion FROM feriados WHERE feriado_fecha = '$fechasql' AND feriado_activo = 1 ORDER BY feriado_fecha");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicencia($fechasql, $nrodocto){
		try{
			//----- Listado de feriados con filtro de año actual -----
			//date_default_timezone_set("America/Buenos_Aires");
			//$año = date("Y");
			$sql = $this->cn->prepare("SELECT * FROM licencias_proceso a, licencias b WHERE lproceso_fecha = '$fechasql' AND legempleado_nrodocto = '$nrodocto' AND a.licencia_id=b.licencia_id");
			$sql->execute();

		return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasPeriodo($nrodocto, $fechainicial, $fechafinal){
		try{


			$sql = $this->cn->prepare("SELECT * FROM licencias_proceso a, licencias b WHERE a.legempleado_nrodocto = '$nrodocto' AND a.licencia_id = b.licencia_id AND a.lproceso_activo = 1 AND a.lproceso_fecha BETWEEN '$fechainicial' AND '$fechafinal' ORDER BY a.lproceso_fecha");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerExcepcion($fechasql, $nrodocto){
		try{
			//----- Listado de feriados con filtro de año actual -----
			//date_default_timezone_set("America/Buenos_Aires");
			//$año = date("Y");
			$sql = $this->cn->prepare("SELECT * FROM excepciones WHERE legempleado_nrodocto = '$nrodocto' AND excepcion_fecha = '$fechasql'");
			$sql->execute();

		return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFichada($fechasql, $nrodocto){
		try{
		$sql = 'SELECT * FROM marcaciones WHERE marcacion_accessid = ? AND CAST(marcacion_datetime AS DATE) = ?';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
		$stm->bindValue(2, $fechasql, PDO::PARAM_STR);
		$stm->execute();
		return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFichadasSinProcesar($nrodocto, $fechainicial, $fechafinal){

		try{

			$sql = $this->cn->prepare("SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1 LIMIT 1");
			$sql->execute();
			$datosaccessid = $sql->fetch(PDO::FETCH_OBJ);
			$accessid = $datosaccessid->marcacion_accessid;

			$sql = $this->cn->prepare("SELECT * FROM marcaciones WHERE marcacion_accessid = '$accessid' AND mestado_id != 2 AND mestado_id != 3 AND DATE(marcacion_datetime) BETWEEN '$fechainicial' AND '$fechafinal' GROUP BY DATE(marcacion_datetime)");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFichadasHistorico($nrodocto, $fechainicial, $fechafinal){

		try{

			$sql = $this->cn->prepare("SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1 LIMIT 1");
			$sql->execute();
			$datosaccessid = $sql->fetch(PDO::FETCH_OBJ);
			$accessid = $datosaccessid->marcacion_accessid;

			$sql = $this->cn->prepare("SELECT * FROM marcaciones WHERE marcacion_accessid = '$accessid' AND DATE(marcacion_datetime) BETWEEN '$fechainicial' AND '$fechafinal' GROUP BY DATE(marcacion_datetime)");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFichadasHistoricoDos($nrodocto, $fechainicial, $fechafinal){

		try{

			/*$sql = $this->cn->prepare("SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1 LIMIT 1");
			$sql->execute();
			$datosaccessid = $sql->fetch(PDO::FETCH_OBJ);
			$accessid = $datosaccessid->marcacion_accessid;*/

			$sql = $this->cn->prepare("SELECT * FROM marcaciones WHERE legempleado_nrodocto = '$nrodocto' AND DATE(marcacion_datetime) BETWEEN '$fechainicial' AND '$fechafinal' GROUP BY DATE(marcacion_datetime)");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFichadasSinProcesarDia($nrodocto, $fechamuestra3){

		try{

			$sql = $this->cn->prepare("SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1 LIMIT 1");
			$sql->execute();
			$datosaccessid = $sql->fetch(PDO::FETCH_OBJ);
			$accessid = $datosaccessid->marcacion_accessid;

			$sql = $this->cn->prepare("SELECT *, TIME(marcacion_datetime) AS ejem33 FROM marcaciones WHERE marcacion_accessid = '$accessid' AND mestado_id != 2 AND mestado_id != 3 AND DATE(marcacion_datetime) = '$fechamuestra3'");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFichadasHistoricoDia($nrodocto, $fechamuestra3){

		try{

			$sql = $this->cn->prepare("SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1 LIMIT 1");
			$sql->execute();
			$datosaccessid = $sql->fetch(PDO::FETCH_OBJ);
			$accessid = $datosaccessid->marcacion_accessid;

			$sql = $this->cn->prepare("SELECT *, TIME(marcacion_datetime) AS ejem33 FROM marcaciones WHERE marcacion_accessid = '$accessid' AND DATE(marcacion_datetime) = '$fechamuestra3' ORDER BY marcacion_datetime");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFichadasHistoricoDiaDos($nrodocto, $fechamuestra3){

		try{

			/*$sql = $this->cn->prepare("SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1 LIMIT 1");
			$sql->execute();
			$datosaccessid = $sql->fetch(PDO::FETCH_OBJ);
			$accessid = $datosaccessid->marcacion_accessid;*/

			$sql = $this->cn->prepare("SELECT *, TIME(marcacion_datetime) AS ejem33 FROM marcaciones WHERE legempleado_nrodocto = '$nrodocto' AND DATE(marcacion_datetime) = '$fechamuestra3' ORDER BY marcacion_datetime");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHistorico($nrodocto, $historicodi, $historicodf){
		try{

			/*$sql = $this->cn->prepare("SELECT marcacion_accessid FROM legajos_reloj WHERE legempleado_nrodocto = '$nrodocto' AND legreloj_activo = 1 LIMIT 1");
			$sql->execute();
			$datosaccessid = $sql->fetch(PDO::FETCH_OBJ);
			$accessid = $datosaccessid->marcacion_accessid;*/

			$sql = $this->cn->prepare("SELECT DATE(a.marcacion_datetime) AS fecha,
																				TIME(a.marcacion_datetime) AS hora,
																				b.reloj_nombre,
																				c.mdireccion_descripcion,
																				d.mfuente_descripcion,
																				e.mestado_nombre
																	 FROM marcaciones a,
																	 			relojes b,
																				marcaciones_direccion c,
																				marcaciones_fuente d,
																				mestados e
																	WHERE a.reloj_id = b.reloj_id
																		AND a.mdireccion_codigo = c.mdireccion_codigo
																		AND a.mfuente_codigo = d.mfuente_codigo
																		AND a.mestado_id = e.mestado_id
																		AND a.legempleado_nrodocto = '$nrodocto'
																		AND	DATE(a.marcacion_datetime)
																BETWEEN '$historicodi'
																		AND '$historicodf'
															 ORDER BY a.marcacion_datetime");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RelojesSeg($ip, $nodo, $codigoe, $accion, $usuario){
		try{
			$sql = 'INSERT INTO relojes_seguimiento (reloj_ip,reloj_nodo,merror_codigo,relojseg_accion,relojseg_datetime,relojseg_usuario)
			VALUES(?, ?, ?, ?, NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ip, PDO::PARAM_STR);
			$stm->bindValue(2, $nodo, PDO::PARAM_STR);
			$stm->bindValue(3, $codigoe, PDO::PARAM_STR);
			$stm->bindValue(4, $accion, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

			return $this->cn->lastInsertId();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodosUsDos(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos ORDER BY periodo_id DESC LIMIT 4");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function MarcAutomatica($data){
		try{
		$sql = 'INSERT INTO marcaciones
		(marcacion_accessid,legempleado_nrodocto,marcacion_datetime,mdireccion_codigo,mfuente_codigo,reloj_id,relojseg_id,mestado_id)
		VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $data->Accessid, PDO::PARAM_STR);
		$stm->bindValue(2, $data->Nrodocto, PDO::PARAM_STR);
		$stm->bindValue(3, $data->Datetime, PDO::PARAM_STR);
		$stm->bindValue(4, $data->Direccion, PDO::PARAM_STR);
		$stm->bindValue(5, $data->Fuente, PDO::PARAM_STR);
		$stm->bindValue(6, $data->Relojid, PDO::PARAM_STR);
		$stm->bindValue(7, $data->Ultimoid, PDO::PARAM_STR);
		$stm->bindValue(8, $data->Estado, PDO::PARAM_STR);
		$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLegajoReloj($accessid){
		try{

			$sql = 'SELECT * FROM legajos_reloj WHERE marcacion_accessid = ? ORDER BY legreloj_id DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $accessid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerMarcaciones($ultimoid){
		try{
		$sql = 'SELECT * FROM marcaciones WHERE relojseg_id = ?';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
		$stm->execute();
		return $stm->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ProcesarMarcaciones($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f){
		try{
				//------ obtener dias que ficha el empleado -----
				$sql = 'SELECT * FROM legajos_reloj WHERE marcacion_accessid = ? AND legreloj_activo = 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
				$stm->execute();
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				$legrelc = $stm->rowCount();//No se usa---
				$semanal = 1;
				if($semanal == 1){
					//----- Fecha y Hora actual -------
					date_default_timezone_set("America/Buenos_Aires");
					$fechaactual = date("Y-m-d");

					$periodoi = strtotime("$fecha_i");
					$periodof = strtotime("$fecha_f");

					//-------Recorrer fechas de periodo hasta fecha actual--------
					for($i=$periodoi; $i<=$periodof; $i+=86400){
						foreach($rows as $clave => $rowlr){

							/*echo $marcacionaccessid."<br>";
							echo $marcaciondatetime."<br>";
							echo date("Y-m-d", $periodoi)."<br>";
							echo date("Y-m-d", $periodof)."<br>";
						  echo date("Y-m-d", $i)."<br>";
							echo "-------------"."<br>";*/

							//----- buscar marcacion de entrada
							$sql = 'SELECT * FROM marcaciones_proceso WHERE legreloj_id = ? AND marcacion_accessid = ? AND CAST(mprocesom_entrada AS DATE) = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $rowlr->legreloj_id, PDO::PARAM_STR);
							$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
							$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
							$stm->execute();
							$mprocer = $stm->fetch(PDO::FETCH_OBJ);
							$mproce = $stm->rowCount();
							//------Preguntar si ya se poroceso la entrada ------
							if($mproce == 1){
								//--------Ya esta procesada la entrada, preguntar salida
								$sql = 'SELECT * FROM marcaciones_proceso WHERE legreloj_id = ? AND marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ?';
								$stm = $this->cn->prepare($sql);
								$stm->bindValue(1, $rowlr->legreloj_id, PDO::PARAM_STR);
								$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
								$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
								$stm->execute();
								$mprocs = $stm->rowCount();
								if($mprocs == 1){
									//--- Marcacion de salida encontrada, descartar actual

									$proceso = 4;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();


								}else{
									//--- Marcacion de salida no encontrada, empezar a buscar
									$dia = strftime("%w", strtotime(date("Y-m-d", $i)));
									if($dia == 0){
										//--- Domingo ---
										/*foreach($rows as $rowlr){*/
											if($rowlr->legreloj_domingo == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion de salida--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion de salida -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion de salida no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia domingo, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 1){
										//---Lunes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_lunes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia Lunes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 2){
										//---Martes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_martes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia martes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 3){
										//---Miercoles----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_miercoles == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia miercoles, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 4){
										//---Jueves----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_jueves == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia jueves, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 5){
										//---Viernes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_viernes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia viernes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 6){
										//---Sabado----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_sabado == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohs;
												$horarioti = strtotime('-2 hours', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+2 hours', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohe;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia Sabado, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}else{
										//--- Default Error, descartar ---
										$proceso = 7;
										$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
										$stm = $this->cn->prepare($sql);
										$stm->bindValue(1, $proceso, PDO::PARAM_STR);
										$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
										$stm->execute();
									}
								}
							}else{
								//-------Entrada no procesada, preguntar si hay marcaciones para procesar----------
								$dia = strftime("%w", strtotime(date("Y-m-d", $i)));
								if($dia == 0){
									//---Domingo----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_domingo == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia domingo, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 1){
									//---Lunes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_lunes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}

												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia lunes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 2){
									//---Martes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_martes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia martes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 3){
									//---Miercoles----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_miercoles == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia miercoles, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 4){
									//---Jueves----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_jueves == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia jueves, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 5){
									//---Viernes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_viernes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia viernes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 6){
									//---Sabado----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_sabado == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohe;
											$horarioti = strtotime('-2 hours', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+2 hours', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohs;
													$horarioti = strtotime('-2 hours', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+2 hours', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Marcacion::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia sabado, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}else{
									//---Default Error
									$proceso = 7;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();
								}
							}
						}/*elseif($legrelc == 2){

							//----- El empleado tiene dos turnos
							$proceso = 10;
							$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $proceso, PDO::PARAM_STR);
							$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
							$stm->execute();

						}else{
							//------ Tiene mas de dos turnos o ninguno
						}*/

					}
				}else{
				//Empleado no semanal
				}
				return 2;
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//----- recostruccion de lineas ----
	public function Secretarias(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM secretarias WHERE secretaria_habilitar = 1 ORDER BY secretaria_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ContrProv(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM legajos_tipo WHERE (legtipo_id = 1 OR legtipo_id = 4)");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLegajoTipoId($legajotipo){
		try{

			$sql = 'SELECT * FROM legajos_tipo WHERE legtipo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $legajotipo, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLugaresDeTrabajo($secretariaid){
		try{

			$sql = 'SELECT * FROM lugares_trabajo WHERE secretaria_id = ? ORDER BY trabajo_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLugarDeTrabajoXId($trabajoid){
		try{

			$sql = 'SELECT * FROM lugares_trabajo WHERE trabajo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleadoXLTrabajo($lugardetrabajo){
		try{

			if($lugardetrabajo == "T"){
				/*
				$sql = $this->cn->prepare("SELECT * FROM lugares_trabajo a, legajos_contrato b, legajos_empleado c WHERE a.trabajo_id = b.trabajo_id AND b.legempleado_nrodocto = c.legempleado_nrodocto AND b.legcontrato_activo = 1");
				$sql->execute();
				return $sql->fetchAll(PDO::FETCH_OBJ);
				*/
			}else{
				//----------- Obtener contratados ---------
				$sql = 'SELECT * FROM legajos_reloj a, legajos_empleado b, legajos_contrato c, lugares_trabajo d WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = c.legempleado_nrodocto AND c.trabajo_id = d.trabajo_id AND a.legreloj_activo = 1 AND b.legempleado_activo = 1 AND c.legcontrato_activo = 1 AND d.trabajo_id = ? GROUP BY a.legempleado_nrodocto';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $lugardetrabajo, PDO::PARAM_STR);
				$stm->execute();
				$contratados =  $stm->fetchAll(PDO::FETCH_OBJ);
				//-------- Obtener Planta Permanente ----------
				$sql = 'SELECT * FROM legajos_reloj a, legajos_empleado b, legajos_ppermanente c, lugares_trabajo d WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = c.legempleado_nrodocto AND c.trabajo_id = d.trabajo_id AND a.legreloj_activo = 1 AND b.legempleado_activo = 1 AND c.legppermanente_activo = 1 AND d.trabajo_id = ? GROUP BY a.legempleado_nrodocto';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $lugardetrabajo, PDO::PARAM_STR);
				$stm->execute();
				$ppermanentes =  $stm->fetchAll(PDO::FETCH_OBJ);
				//-------- Obtener Jornaleros -----------------
				$sql = 'SELECT * FROM legajos_reloj a, legajos_empleado b, legajos_jornalero c, lugares_trabajo d WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = c.legempleado_nrodocto AND c.trabajo_id = d.trabajo_id AND a.legreloj_activo = 1 AND b.legempleado_activo = 1 AND c.legjornalero_activo = 1 AND d.trabajo_id = ? GROUP BY a.legempleado_nrodocto';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $lugardetrabajo, PDO::PARAM_STR);
				$stm->execute();
				$jornaleros =  $stm->fetchAll(PDO::FETCH_OBJ);

				//--- unir todos los arrays---
				$empleados = array_merge($contratados, $ppermanentes, $jornaleros);
				//--- eliminar contenido duplicado ---
				$empleados = array_map('json_encode', $empleados);
				$empleados = array_unique($empleados);
				$empleados = array_map('json_decode', $empleados);
				//--- Retornar contenido ---
				return $empleados;

			}
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FichadasDescartadas(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM marcaciones WHERE mestado_id != 2 AND mestado_id != 3");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
