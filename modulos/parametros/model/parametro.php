<?php
class Parametro{

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

	public function ListarNovedades(){
		try{
	
			$sql = 'SELECT mid(liqcod_descripcion,1,22) nombre,liqcod_id
			FROM liquidaciones_codigo
			WHERE liqcod_descripcion <> ""
			';
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
	
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarParametros(){
		try{
			//----- Listado de feriados con filtro de año actual -----
			$sql = $this->cn->prepare("SELECT *
									 FROM categoria_parametros
									 WHERE activo=1
									");
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
			$sql = 'INSERT INTO categoria_parametros(categoria_nombre,categoria_monto,categoria_porc,categoria_desde,categoria_hasta,liqcod_id,activo)
			VALUES(?, ?, ?, ?, ?, ? , 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->parametronombre, PDO::PARAM_STR);
			$stm->bindValue(2, $data->parametromonto, PDO::PARAM_STR);
			$stm->bindValue(3, $data->parametroporcentaje, PDO::PARAM_STR);
			$stm->bindValue(4, $data->parametrodesde, PDO::PARAM_STR);
			$stm->bindValue(5, $data->parametrohasta, PDO::PARAM_STR);
			$stm->bindValue(6, $data->parametrocodtipo, PDO::PARAM_STR);
			
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
			$sql = 'UPDATE categoria_parametros SET activo = ? WHERE categoria_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->parametroactivo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->parametroid1, PDO::PARAM_STR);
			$stm->execute();
			
			

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
