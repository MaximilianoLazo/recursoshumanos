<?php
class HorasExtras{
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
	public function PeriodoActualObtener(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	////////////////CODIGOS VIEJOS/////////////////////
	public function ListarHorasExtras(){
		try{
			//---- Busco ultimo periodo cerrado ----
			$periodoutimo = HorasExtras::PeriodoUCerrado();
			$periodoid = $periodoutimo->periodo_id;
			//----- Select de horas extras en el ultimo periodo cerrado ---
			$sql = 'SELECT * FROM horas a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.horas_estado > 0 AND a.periodo_id = ? ORDER BY a.trabajo_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarHorasExtrasPDF($lugardetrabajo, $legajotipo, $ordenhoras){
		try{
			//---- Busco ultimo periodo cerrado ----
			$periodoutimo = HorasExtras::PeriodoUCerrado();
			$periodoid = $periodoutimo->periodo_id;
			//----- Buscar orden de datos -------
			if($ordenhoras == 1){
				//-- Lugar de trabajo, nombre, dni ---
				$ordenhorasextras = "c.trabajo_nombre,b.legempleado_apellido,b.legempleado_nombres,b.legempleado_nrodocto";
			}elseif($ordenhoras == 2){
				//--- Nombres, dni, Lugar de Trabajo ---
				$ordenhorasextras = "b.legempleado_apellido,b.legempleado_nombres,b.legempleado_nrodocto,c.trabajo_nombre";
			}elseif($ordenhoras == 3){
				//--- DNI, Nombres, Lugar de Trabajo ---
				$ordenhorasextras = "b.legempleado_nrodocto,b.legempleado_apellido,b.legempleado_nombres,c.trabajo_nombre";
			}else{
				//---- Default Error
			}
			//---- Filtro de Lugar de Trabajo ------
			if($lugardetrabajo == "T"){
				//--- Todos los lugares de trabajo ---
				if($legajotipo == "T"){
					//---Todos los tipos de legajo ---
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 1){
					//---Contratado
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND b.legtipo_id = 1 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 2){
					//---Jornalero---
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND b.legtipo_id = 2 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 3){
					//---Planta Permanente--
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND b.legtipo_id = 3 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 4){
					//---Proveedor ---
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND b.legtipo_id = 4 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 5){
					//----Funcionarios
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND b.legtipo_id = 5 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 6){
					//---Concejo deliBerante
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND b.legtipo_id = 6 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					//$stm->execute();

				}else{
					//---- Defaul error ---
				}
			}else{
				//--- Un lugar de Trabajo
				if($legajotipo == "T"){
					//---Todos los tipos de legajo ---
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND a.trabajo_id = ? ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 1){
					//---Contratado
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND a.trabajo_id = ? AND b.legtipo_id = 1 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 2){
					//---Jornalero---
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND a.trabajo_id = ? AND b.legtipo_id = 2 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 3){
					//---Planta Permanente--
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND a.trabajo_id = ? AND b.legtipo_id = 3 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 4){
					//---Proveedor ---
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND a.trabajo_id = ? AND b.legtipo_id = 4 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 5){
					//----Funcionarios
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND a.trabajo_id = ? AND b.legtipo_id = 5 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
					//$stm->execute();

				}elseif($legajotipo == 6){
					//---Concejo deliBerante
					$sql = 'SELECT * FROM horas a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.periodo_id = ? AND a.trabajo_id = ? AND b.legtipo_id = 6 ORDER BY '.$ordenhorasextras.'';
					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
					$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
					//$stm->execute();

				}else{
					//---- Defaul error ---
				}
			}
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarHorasExtrasResumen(){
		try{
			//---- Busco ultimo periodo cerrado ----
			$periodoutimo = HorasExtras::PeriodoUCerrado();
			$periodoid = $periodoutimo->periodo_id;
			//----- Select de horas extras en el ultimo periodo cerrado ---
			$sql = 'SELECT *, COUNT(legempleado_nrodocto) AS totalempleados, SUM(horasex_simples) AS totalhorasex_simples, SUM(horasex_dobles) AS totalhorasex_dobles, SUM(horas_jornales) AS totalhoras_jornales FROM horas WHERE horas_estado > 0 AND periodo_id = ? GROUP BY trabajo_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

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
	public function PeriodoUDiez(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 10");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function GuardarHorasExtrasExe($data){
		try{
			//---- Busco ultimo periodo cerrado ----
			$periodoutimo = HorasExtras::PeriodoUCerrado();
			$periodoid = $periodoutimo->periodo_id;
			//---- Buscar horas de empleados ingresadas anteriormente en este periodo --
			$sql = 'SELECT * FROM horas WHERE legempleado_nrodocto = ? AND periodo_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Hsexdni, PDO::PARAM_STR);
			$stm->bindValue(2, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			//$empleadohsextras = $stm->fetch(PDO::FETCH_OBJ);
			$empleadohsextrasc = $stm->rowCount();
			//---- Pregunto si ya tiene horas ingresadas en este periodos
			if($empleadohsextrasc > 0){
				//--- tiene horas, remplazar
				$sql = 'UPDATE horas SET periodo_id = ?, trabajo_id = ?, trabajo_nombre = ?, horasex_simples = ?, horasex_dobles = ?, horas_jornales = ?, horas_observaciones = ? WHERE legempleado_nrodocto = ? AND periodo_id = ?';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
				$stm->bindValue(2, $data->Hsexltrabajoid, PDO::PARAM_STR);
				$stm->bindValue(3, $data->Hsexltrabajonombre, PDO::PARAM_STR);
				$stm->bindValue(4, $data->Hsexsimples, PDO::PARAM_STR);
				$stm->bindValue(5, $data->Hsexdobles, PDO::PARAM_STR);
				$stm->bindValue(6, $data->Hsjornales, PDO::PARAM_STR);
				$stm->bindValue(7, $data->Hsexobservaciones, PDO::PARAM_STR);
				$stm->bindValue(8, $data->Hsexdni, PDO::PARAM_STR);
				$stm->bindValue(9, $periodoid, PDO::PARAM_STR);
				$stm->execute();
			}else{
				//--- No tiene horas, Insertar
				$sql = 'INSERT INTO horas (legempleado_nrodocto,periodo_id,trabajo_id,trabajo_nombre,horasex_simples,horasex_dobles,horas_jornales,horas_observaciones,horas_estado)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, 1)';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $data->Hsexdni, PDO::PARAM_STR);
				$stm->bindValue(2, $periodoid, PDO::PARAM_STR);
				$stm->bindValue(3, $data->Hsexltrabajoid, PDO::PARAM_STR);
				$stm->bindValue(4, $data->Hsexltrabajonombre, PDO::PARAM_STR);
				$stm->bindValue(5, $data->Hsexsimples, PDO::PARAM_STR);
				$stm->bindValue(6, $data->Hsexdobles, PDO::PARAM_STR);
				$stm->bindValue(7, $data->Hsjornales, PDO::PARAM_STR);
				$stm->bindValue(8, $data->Hsexobservaciones, PDO::PARAM_STR);
				$stm->execute();
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AutocompletarEmpleado($nrodocto){
		try{
			//---- Buscar tipo de legajo del empleado ----
			$sql = 'SELECT legtipo_id FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$datolegtipo = $stm->fetch(PDO::FETCH_OBJ);
			$legtipoid = $datolegtipo->legtipo_id;

			if($legtipoid == 1){
				//---- Contratado
				$sql = 'SELECT a.legempleado_apellido,a.legempleado_nombres,c.trabajo_id,c.trabajo_nombre FROM legajos_empleado a, legajos_contrato b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND b.trabajo_id = c.trabajo_id AND a.legempleado_nrodocto = ? AND b.legcontrato_activo = 1 ORDER BY b.legcontrato_id DESC';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);

			}elseif($legtipoid == 2){
				//---- Jornalero
				$sql = 'SELECT a.legempleado_apellido,a.legempleado_nombres,c.trabajo_id,c.trabajo_nombre FROM legajos_empleado a, legajos_jornalero b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND b.trabajo_id = c.trabajo_id AND a.legempleado_nrodocto = ? AND b.legjornalero_activo = 1 ORDER BY b.legjornalero_id DESC';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);
			}elseif($legtipoid == 3){
				//--- Planta Permanente
				$sql = 'SELECT a.legempleado_apellido,a.legempleado_nombres,c.trabajo_id,c.trabajo_nombre FROM legajos_empleado a, legajos_ppermanente b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND b.trabajo_id = c.trabajo_id AND a.legempleado_nrodocto = ? AND b.legppermanente_activo = 1 ORDER BY b.legppermanente_id DESC';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);

			}elseif($legtipoid == 4){
				//--- Proveedor
				$sql = 'SELECT a.legempleado_apellido,a.legempleado_nombres,c.trabajo_id,c.trabajo_nombre FROM legajos_empleado a, legajos_proveedor b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND b.trabajo_id = c.trabajo_id AND a.legempleado_nrodocto = ? AND b.legcontrato_activo = 1 ORDER BY b.legcontrato_id DESC';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);

			}elseif($legtipoid == 5){
				//--- Funcionarios
			}elseif($legtipoid == 6){
				//---- Concejo deliberante
			}else{
				//--- error de legajo
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AutocompletarHorasExtras($nrodocto){
		try{
			//---- Busco ultimo periodo cerrado ----
			$periodoutimo = HorasExtras::PeriodoUCerrado();
			$periodoid = $periodoutimo->periodo_id;
			//--- Buscar horas extras del empleado ----
			$sql = 'SELECT * FROM horas WHERE legempleado_nrodocto = ? AND periodo_id = ? AND horas_estado = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleadoDatos($search){
		try{

			$sql = "SELECT * FROM legajos_empleado WHERE legempleado_activo = 1 AND (legempleado_apellido LIKE '%$search%' OR legempleado_nombres LIKE '%$search%') LIMIT 0,10";
			$stm = $this->cn->prepare($sql);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosEmpleado($nrodocto){
		try{

			$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarLugaresDeTrabajo(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM lugares_trabajo WHERE trabajo_activo = 1 ORDER BY trabajo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarTiposDeLegajos(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM legajos_tipo ORDER BY legtipo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
