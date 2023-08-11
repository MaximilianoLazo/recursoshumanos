<?php
class Marcacion
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
	public function ObtenerFeriado($fechasql){
		try{
			//----- Listado de feriados con filtro de año actual -----
			date_default_timezone_set("America/Buenos_Aires");
			$año = date("Y");
			$sql = $this->cn->prepare("SELECT * FROM feriados WHERE YEAR(feriado_fecha) = '$año' AND feriado_fecha = '$fechasql' AND feriado_activo=1 ORDER BY feriado_fecha");
			$sql->execute();

		return $sql->fetch(PDO::FETCH_OBJ);

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
}
