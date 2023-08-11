<?php
class Marcacionautomatica
{

	public function __CONSTRUCT()
	{
		try
		{
			$db = Conexion::getInstance();
			$this->cn = $db->getConnection();
		}
		catch(Exception $e)
		{
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

	public function MarcAutomatica($data){
		try{
		$sql = 'INSERT INTO marcaciones
		(marcacion_accessid,marcacion_datetime,mdireccion_codigo,mfuente_codigo,reloj_id,relojseg_id,mestado_id)
		VALUES(?, ?, ?, ?, ?, ?, ?)';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $data->Accessid, PDO::PARAM_STR);
		$stm->bindValue(2, $data->Datetime, PDO::PARAM_STR);
		$stm->bindValue(3, $data->Direccion, PDO::PARAM_STR);
		$stm->bindValue(4, $data->Fuente, PDO::PARAM_STR);
		$stm->bindValue(5, $data->Relojid, PDO::PARAM_STR);
		$stm->bindValue(6, $data->Ultimoid, PDO::PARAM_STR);
		$stm->bindValue(7, $data->Estado, PDO::PARAM_STR);
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
		$sql = 'SELECT * FROM relojes WHERE reloj_ip = ? AND reloj_nodo = ?';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $ip, PDO::PARAM_STR);
		$stm->bindValue(2, $nodo, PDO::PARAM_STR);
		$stm->execute();
		return $stm->fetchAll(PDO::FETCH_OBJ);

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
	/*
	public function ObtenerReloj($ultimoid){
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
	*/
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

	public function ProcesarMarcaciones($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid){
		try{
				//------ obtener dias que ficha el empleado -----
				$sql = 'SELECT * FROM legajos_reloj WHERE marcacion_accessid = ? AND legreloj_activo = 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
				$stm->execute();
				//$rowlr = $stm->fetch(PDO::FETCH_OBJ);
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				$legrelc = $stm->rowCount();
				$semanal = 1;
				if($semanal == 1){
					//---------------- obtener fechas de periodo actual -------
					$sql = $this->cn->prepare("SELECT periodo_id,periodo_hsext_jor_i,periodo_hsext_jor_f,periodo_cerrado FROM periodos WHERE periodo_cerrado=0");
					$sql->execute();
					$row = $sql->fetch(PDO::FETCH_OBJ);
					// --------------- Fecha inicial y final del periodo -------
					$periodoi=strtotime("$row->periodo_hsext_jor_i");
					$periodof=strtotime("$row->periodo_hsext_jor_f");
					//-------Recorrer fechas de periodo hasta fecha actual--------
					for($i=$periodoi; $i<=$periodof; $i+=86400){
						if($legrelc == 1){
							//----- el empleado tiene un solo turno, buscar marcacion de entrada
							$fechae = date("Y-m-d", $i);
							echo $fechae." - ".$marcacionaccessid;
							$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_entrada AS DATE) = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
							$stm->bindValue(2, $fechae, PDO::PARAM_STR);
							$stm->execute();
							$mproce = $stm->rowCount();
							//------Preguntar si ya se poroceso la entrada ------
							if($mproce == 1){
								//--------Ya esta procesada la entrada, preguntar salida
								$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
								$stm = $this->cn->prepare($sql);
								$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
								$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
								$stm->execute();
								$mprocs = $stm->rowCount();
								if($mprocs == 1){
									//--- Marcacion de salida encontrada, descartar actual
									$proceso = 3;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();
								}else{
									//--- Marcacion de salida no encontrada, empezar a buscar
									$dia = strftime("%w", strtotime("$i"));
									if($dia == 0){
										//--- Domingo ---
										foreach($rows as $rowlr){
											if($rowlr->legreloj_domingo == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date($i." ".$rowlr->legreloj_domingohs);
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = $i." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mproceso_salida = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $salida, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 2;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, descartar actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}
											}else{
												//--- No ficha dia domingo, descartar marcacion actual
												$proceso = 3;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}
										}
									}elseif($dia == 1){
										//---Lunes----
										foreach($rows as $rowlr){
											if($rowlr->legreloj_lunes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date($i." ".$rowlr->legreloj_luneshs);
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = $i." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mproceso_salida = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $salida, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 2;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, descartar actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}
											}else{
												//--- No ficha dia lunes, descartar marcacion actual
												$proceso = 3;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}
										}
									}elseif($dia == 2){
										//---Martes----
										foreach($rows as $rowlr){
											if($rowlr->legreloj_martes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date($i." ".$rowlr->legreloj_marteshs);
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = $i." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mproceso_salida = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $salida, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 2;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, descartar actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}
											}else{
												//--- No ficha dia martes, descartar marcacion actual
												$proceso = 3;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}
										}
									}elseif($dia == 3){
										//---Miercoles----
										foreach($rows as $rowlr){
											if($rowlr->legreloj_miercoles == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date($i." ".$rowlr->legreloj_miercoleshs);
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = $i." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mproceso_salida = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $salida, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 2;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, descartar actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}
											}else{
												//--- No ficha dia miercoles, descartar marcacion actual
												$proceso = 3;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}
										}
									}elseif($dia == 4){
										//---Jueves----
										foreach($rows as $rowlr){
											if($rowlr->legreloj_jueves == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date($i." ".$rowlr->legreloj_jueveshs);
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = $i." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mproceso_salida = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $salida, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 2;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, descartar actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}
											}else{
												//--- No ficha dia jueves, descartar marcacion actual
												$proceso = 3;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}
										}
									}elseif($dia == 5){
										//---Viernes----
										foreach($rows as $rowlr){
											if($rowlr->legreloj_viernes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date($i." ".$rowlr->legreloj_vierneshs);
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = $i." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mproceso_salida = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $salida, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 2;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, descartar actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}
											}else{
												//--- No ficha dia viernes, descartar marcacion actual
												$proceso = 3;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}
										}
									}elseif($dia == 6){
										//---Sabado----
										foreach($rows as $rowlr){
											if($rowlr->legreloj_sabado == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date($i." ".$rowlr->legreloj_sabadohs);
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = $i." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mproceso_salida = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $salida, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 2;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, descartar actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}
											}else{
												//--- No ficha dia sabado, descartar marcacion actual
												$proceso = 3;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}
										}
									}else{
										//--- Default Error, descartar ---
										$proceso = 3;
										$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
										$stm = $this->cn->prepare($sql);
										$stm->bindValue(1, $proceso, PDO::PARAM_STR);
										$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
										$stm->execute();
									}
								}
							}else{
								//-------Entrada no procesada, preguntar si hay marcaciones para procesar----------
								$dia = strftime("%w", strtotime("$i"));
								if($dia == 0){
									//---Domingo----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_domingo == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_domingohe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_dominohs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia domingo ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}elseif($dia == 1){
									//---Lunes----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_lunes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_luneshe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_luneshs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia lunes ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}elseif($dia == 2){
									//---Martes----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_martes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_marteshe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_marteshs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccesid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia martes ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}elseif($dia == 3){
									//---Miercoles----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_miercoles == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_miercoleshe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_miercoleshs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia miercoles ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}elseif($dia == 4){
									//---Jueves----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_jueves == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_jueveshe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_jueveshs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia jueves ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}elseif($dia == 5){
									//---Viernes----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_viernes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_vierneshe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_vierneshs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia viernes ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}elseif($dia == 6){
									//---Sabado----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_sabado == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_sabadohe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_sabadohs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia sabado ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}else{
									//---Default Error, preguntar por la salida
									$proceso = 3;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();
								}
							}
						}elseif($legrelc == 2){
							//----- El empleado tiene dos turnos
							$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_entrada AS DATE) = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
							$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
							$stm->execute();
							$mproce = $stm->rowCount();
							if($mproce == 1){
								//----- uno fichada entrada
							}elseif($mproce == 2){
								//----- dos fichadas entrada
							}else{
								//----- ninguna o mas de dos
								$dia = strftime("%w", strtotime("$i"));
								if($dia == 0){
									//---Domingo----
									foreach($rows as $rowlr){
										if($rowlr->legreloj_domingo == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date($i." ".$rowlr->legreloj_domingohe);
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = $i." ".$time;
												$salida = "0000-00-00 00:00:00";
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, $condicion, PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(4, $entrada, PDO::PARAM_STR);
												$stm->bindValue(5, $salida, PDO::PARAM_STR);
												$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
												$stm->bindValue(7, $ficha, PDO::PARAM_STR);
												$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(9, $activo, PDO::PARAM_STR);
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
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mproceso_salida AS DATE) = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date($i." ".$rowlr->legreloj_dominohs);
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($horarioti <= $marcaciondatetime || $marcaciondatetime >= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = $i." ".$time;
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(marcacion_accessid,mcondicion_id,reloj_id,mproceso_entrada,mproceso_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(2, $condicion, PDO::PARAM_STR);
														$stm->bindValue(3, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(4, $entrada, PDO::PARAM_STR);
														$stm->bindValue(5, $salida, PDO::PARAM_STR);
														$stm->bindValue(6, $row->periodo_id, PDO::PARAM_STR);
														$stm->bindValue(7, $ficha, PDO::PARAM_STR);
														$stm->bindValue(8, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(9, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 2;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//---- No se encontro Marcacion de Salida, descartar actual -----
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}
												}
											}
										}else{
											//-----No ficha dia domingo ----
											$proceso = 3;
											$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $proceso, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
											$stm->execute();
										}
									}
								}elseif($dia == 1){

								}else{

								}
							}
						}else{
							//------ Tiene mas de dos turnos o ninguno
						}

					}
				}else{
				//Empleado no semanal
				}
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

}
?>
