<?php
class Usuario
{
	public function __CONSTRUCT()
	{
		try {
			$this->cn = Conexion::getConnection();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function __DESTRUCT()
	{
		$this->cn;
	}
	public function UsuariosListar()
	{
		try {

			$sql = 'SELECT *
								FROM usuarios';
			$dec = $this->cn->prepare($sql);
			//$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function UsuariosTiposListar()
	{
		try {

			$sql = 'SELECT *
								FROM usuarios_tipo
								ORDER BY usuario_tipo_nombre ASC';
			$dec = $this->cn->prepare($sql);
			//$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function UsuarioTipoObtener($usuariotipoid)
	{
		try {

			$sql = 'SELECT *
								FROM usuarios_tipo
								WHERE usuario_tipo_id = ?
								LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $usuariotipoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	function hashPassword($password)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}

	function UsuarioGuardarExe($data)
	//function UsuarioGuardarExe($usuario, $pass_hash, $nombre, $apellido, $dni, $email, $activo, $token, $tipo_usuario)
	{

		$sql = 'INSERT INTO usuarios (usuario_usuario,
																		usuario_dni,
																		usuario_apellido,
																		usuario_nombres,
																		usuario_email,
																		usuario_password,
																		usuario_token,
																		usuario_lastsession,
																		usuario_tokenpassword,
																		usuario_passwordrequest,
																		usuario_tipo_id,
																		usuario_estado)
														 VALUES(:usr,
																	  :dni,
																		:apellido,
																		:nombres,
																		:email,
																		:clave,
																		:token,
																		"0000-00-00 00:00:00",
																		"",
																		0,
																		:usrtipo,
																		:activo)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':usr', $data->Usuario, PDO::PARAM_STR);
		$dec->bindValue(':dni', $data->UsuarioDNI, PDO::PARAM_STR);
		$dec->bindValue(':apellido', $data->UsuarioApellido, PDO::PARAM_STR);
		$dec->bindValue(':nombres', $data->UsuarioNombres, PDO::PARAM_STR);
		$dec->bindValue(':email', $data->UsuarioEmail, PDO::PARAM_STR);
		$dec->bindValue(':clave', $data->UsuarioPass, PDO::PARAM_STR);
		$dec->bindValue(':token', $data->UsuarioToken, PDO::PARAM_STR);
		$dec->bindValue(':usrtipo', $data->UsuarioTipo, PDO::PARAM_STR);
		$dec->bindValue(':activo', $data->UsuarioEstado, PDO::PARAM_STR);

		if ($dec->execute()) {
			return $this->cn->lastInsertId();
		} else {
			return 0;
		}
	}
	public function UsuarioActualizar($data)
	{
		try {

			$sql = 'UPDATE usuarios SET	usuario_usuario = ?,
																	usuario_tipo_id = ?
														WHERE usuario_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Usuario, PDO::PARAM_STR);
			$dec->bindValue(2, $data->UsuarioTipo, PDO::PARAM_STR);
			$dec->bindValue(3, $data->UsuarioId, PDO::PARAM_STR);
			$dec->execute();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function UsuarioBajaExe($data)
	{
		try {

			$sql = 'UPDATE usuarios SET	usuario_estado = ?
														WHERE usuario_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->UsuarioEstado, PDO::PARAM_STR);
			$dec->bindValue(2, $data->UsuarioId, PDO::PARAM_STR);
			$dec->execute();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function UsuarioHabilitarExe($data)
	{
		try {

			$sql = 'UPDATE usuarios SET	usuario_estado = ?
														WHERE usuario_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->UsuarioEstado, PDO::PARAM_STR);
			$dec->bindValue(2, $data->UsuarioId, PDO::PARAM_STR);
			$dec->execute();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function UsuarioObtener_ID($usuarioid)
	{
		try {

			$sql = 'SELECT *
								FROM usuarios
								WHERE usuario_id = ?
								LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $usuarioid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function UsuarioCambiarClaveExe($usuario_id, $clave)
	{
		try {

			$sql = 'UPDATE usuarios SET	usuario_password = ?
														WHERE usuario_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $clave, PDO::PARAM_STR);
			$dec->bindValue(2, $usuario_id, PDO::PARAM_STR);
			$dec->execute();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}
