<?php
class Feriado{

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
	public function ListarFeriados(){
		try{
			//----- Listado de feriados con filtro de año actual -----
			date_default_timezone_set("America/Buenos_Aires");
			$año = date("Y");

			$sql = $this->cn->prepare("SELECT *
																	 FROM feriados
																	WHERE YEAR(feriado_fecha) >= '$año'
																	  AND feriado_activo = 1
															 ORDER BY feriado_fecha");
			$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarF($data){
		try
		{
			//------------ Insert Feriado -------------------
			$sql = 'INSERT INTO feriados (feriado_fecha,feriado_observacion,feriado_activo)
			VALUES(?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadofecha, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Feriadoactivo, PDO::PARAM_STR);
			$stm->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ------Insert auditoria feriado--------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_feriados (AUD_feriado_id,AUD_feriado_fecha,AUD_feriado_observacion,AUD_feriado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadofecha, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Feriadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Feriadoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarF($data){
		try{
			// --------------- Modificacion de Feriados--------------------
			$sql = 'UPDATE feriados SET feriado_fecha = ?, feriado_observacion = ? WHERE feriado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadofecha, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Feriadoid, PDO::PARAM_STR);
			$stm->execute();
			//-----Insert de auditoria modificacion de feriados -----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_feriados (AUD_feriado_id,AUD_feriado_fecha,AUD_feriado_observacion,AUD_feriado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "UPDATE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadofecha, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Feriadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Feriadoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DeshabilitarFer($data){
		try{
			//---------- Deshabilitar feriado -------
			$sql = 'UPDATE feriados SET feriado_activo = ? WHERE feriado_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadoactivo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadoid, PDO::PARAM_STR);
			$stm->execute();
			//------------- auditoria -----------------
			$sql = 'SELECT * FROM feriados WHERE feriado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//--------Insert de auditoria Deshabilitar Feriado-----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_feriados (AUD_feriado_id,AUD_feriado_fecha,AUD_feriado_observacion,AUD_feriado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "DISABLE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->feriado_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->feriado_fecha, PDO::PARAM_STR);
			$stm->bindValue(3, $row->feriado_observacion, PDO::PARAM_STR);
			$stm->bindValue(4, $row->feriado_activo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
