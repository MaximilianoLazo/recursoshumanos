<?php
class Tarea{

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
	public function ListarTareas(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM tareas WHERE tarea_activo = 1 ORDER BY tarea_nombre");
			$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarTarea($data){
		try
		{

			$sql = 'INSERT INTO tareas (tarea_nombre,tarea_activo)
			VALUES(?, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->TareaNombre, PDO::PARAM_STR);
			$stm->execute();
			/*
			$sql = 'INSERT INTO tareas (tarea_nombre,tarea_activo)
			VALUES(?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->TareaNombre, PDO::PARAM_STR);
			$stm->bindValue(2, 1, PDO::PARAM_STR);
			$stm->execute();
			*/
			/*
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ------Insert auditoria Lugar de trabajo--------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_lugares_trabajo (AUD_trabajo_id,AUD_trabajo_nombre,AUD_secretaria_id,AUD_trabajo_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Trabajonombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Trabajosec, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Trabajoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();
			*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarTarea($data){
		try{
			$sql = 'UPDATE tareas SET tarea_nombre = ? WHERE tarea_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->TareaNombre, PDO::PARAM_STR);
			$stm->bindValue(2, $data->TareaId, PDO::PARAM_STR);
			$stm->execute();
			//-----Insert de auditoria modificacion de Lugares de trabajo -----
			/*
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_lugares_trabajo (AUD_trabajo_id,AUD_trabajo_nombre,AUD_secretaria_id,AUD_trabajo_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "UPDATE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Trabajoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Trabajonombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Trabajosec, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Trabajoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();
			*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DeshabilitarTar($data){
		try{

			$sql = 'UPDATE tareas SET tarea_activo = ? WHERE tarea_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->TareaActivo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->TareaId, PDO::PARAM_STR);
			$stm->execute();
			/*
			//------------- auditoria -----------------
			$sql = 'SELECT * FROM lugares_trabajo WHERE trabajo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Trabajoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//--------Insert de auditoria Deshabilitar Lugar de trabajo-----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_lugares_trabajo (AUD_trabajo_id,AUD_trabajo_nombre,AUD_secretaria_id,AUD_trabajo_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "DISABLE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->trabajo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->trabajo_nombre, PDO::PARAM_STR);
			$stm->bindValue(3, $row->secretaria_id, PDO::PARAM_STR);
			$stm->bindValue(4, $row->trabajo_activo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();
			*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

}
