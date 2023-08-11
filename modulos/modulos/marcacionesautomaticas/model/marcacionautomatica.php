<?php
class Marcacionautomatica{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodoActual(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado = 0 LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//GuardarPeriodoNuevo($periodoanteriorid,$periodo_nombre,$periodohsi_nuevo,$periodohsf_nuevo,$periodoprei_nuevo,$periodopref_nuevo){
	public function GuardarPeriodoNuevo($data){
		try{
			//---Cerrar periodo anterior ----
			$sql = 'UPDATE periodos SET periodo_cerrado = 1 WHERE periodo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->PerioidOld, PDO::PARAM_STR);
			$stm->execute();
			//---Insertar periodo nuevo ----
			$sql = 'INSERT INTO periodos
			(periodo_nombre,periodo_hsext_jor_i,periodo_hsext_jor_f,periodo_presentismo_i,periodo_presentismo_f,periodo_cerrado,periodo_activo)
			VALUES(?, ?, ?, ?, ?, 0, 1)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Periodonombre, PDO::PARAM_STR);
			$stm->bindValue(2, $data->PeriodohsiNew, PDO::PARAM_STR);
			$stm->bindValue(3, $data->PeriodohsfNew, PDO::PARAM_STR);
			$stm->bindValue(4, $data->PeriodopreiNew, PDO::PARAM_STR);
			$stm->bindValue(5, $data->PeriodoprefNew, PDO::PARAM_STR);
			$stm->execute();

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
			$sql = $this->cn->prepare("SELECT * FROM periodos ORDER BY periodo_id DESC LIMIT 2");
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
	public function ObtenerReloj($ip, $nodo){
		try{
			$sql = 'SELECT * FROM relojes WHERE reloj_ip = ? AND reloj_nodo = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ip, PDO::PARAM_STR);
			$stm->bindValue(2, $nodo, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
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
	public function ListarLegRelojes(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM legajos_reloj");
			$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

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
				$legrelc = $stm->rowCount();
				$semanal = 1;
				if($semanal == 1){
					//----- Fecha y Hora actual -------
					date_default_timezone_set("America/Buenos_Aires");
					$fechaactual = date("Y-m-d");
					//$hora = date("H:i:s");
					/*
					$sql = $this->cn->prepare("SELECT DATE(marcacion_datetime) AS umarcacion FROM marcaciones WHERE marcacion_accessid = '$marcacionaccessid' AND mestado_id != 1 AND DATE(marcacion_datetime) BETWEEN '$periodoinicio' AND '$periodofin' ORDER BY marcacion_id DESC LIMIT 1");
					$sql->execute();
					$mproceso = $sql->fetch(PDO::FETCH_OBJ);
					$mprocesoc = $sql->rowCount();
					if($mprocesoc > 0){
						$periodoin = $mproceso->umarcacion;
						if($periodoin > $periodoinicio){
							$periodoi = $periodoin;
						}else{
							$periodoi = $periodoinicio;
						}
					}else{
						$periodoin = $periodoinicio;
					}
					if($periodofin > $fechaactual){
						$periodofi = $fechaactual;
					}else{
						$periodofi = $periodofin;
					}
					*/
					$periodoi = strtotime("$fecha_i");
					$periodof = strtotime("$fecha_f");
					//-------Recorrer fechas de periodo hasta fecha actual--------
					for($i=$periodoi; $i<=$periodof; $i+=86400){
						foreach($rows as $rowlr){

							echo $marcacionaccessid."<br>";
							echo $marcaciondatetime."<br>";
							echo date("Y-m-d", $periodoi)."<br>";
							echo date("Y-m-d", $periodof)."<br>";
						  echo date("Y-m-d", $i)."<br>";
							echo "-------------"."<br>";

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
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
														$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
														$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
														$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
														$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
														$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
														$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
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
												$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
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
														$periodo_dos_ultimos = Marcacionautomatica::PeriodosUsDos();
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
	function agregar_zip($dir, $zip, $horanumerica){
	  //verificamos si $dir es un directorio
	  if(is_dir($dir)){
	    //abrimos el directorio y lo asignamos a $da
	    if($da = opendir($dir)){
	      //leemos del directorio hasta que termine
	      while(($archivo = readdir($da)) !== false){
	        /*Si es un directorio imprimimos la ruta
	         * y llamamos recursivamente esta función
	         * para que verifique dentro del nuevo directorio
	         * por mas directorios o archivos
	         */
	        if(is_dir($dir . $archivo) && $archivo != "." && $archivo != ".."){
	          echo "<strong>Creando directorio: $dir$archivo</strong><br/>";
	          agregar_zip($dir . $archivo . "/", $zip);
	          /*si encuentra un archivo imprimimos la ruta donde se encuentra
	           * y agregamos el archivo al zip junto con su ruta
	           */
	        }elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != ".."){
	          echo "Agregando archivo: $dir$archivo <br/>";
	          //$zip->addFile($dir . $archivo, $horanumerica."/".$horanumerica."_".$archivo);
						$zip->addFile($dir . $archivo, $horanumerica."/".$archivo);
	        }
	      }
	      //cerramos el directorio abierto en el momento
	      closedir($da);
	    }
	  }
	}
}
?>
