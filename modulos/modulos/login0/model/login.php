<?php

	class Login{
		public function __CONSTRUCT(){
			try{
				$this->cn = Conexion::getConnection();
			}catch(Exception $e){
				die($e->getMessage());
			}
		}
		public function __DESTRUCT(){
			//$db;
			//$this->cn;
		}
		function isNull($nombre, $user, $pass, $pass_con, $email){
			if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1){
				return true;
			}else{
				return false;
			}
		}
		function isEmail($email){
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
				return true;
			}else{
				return false;
			}
		}
		function validaPassword($var1, $var2)
		{
			if (strcmp($var1, $var2) !== 0){
				return false;
				} else {
				return true;
			}
		}
		function minMax($min, $max, $valor){
			if(strlen(trim($valor)) < $min)
			{
				return true;
			}
			else if(strlen(trim($valor)) > $max)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		function usuarioExiste($usuario)
		{

			$sql = 'SELECT usuario_id FROM usuarios  WHERE usuario_usuario = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $usuario, PDO::PARAM_STR);
			$stm->execute();
			//$stm->store_result();
			//$num = $stm->num_rows;
			$num = $stm->rowCount();

			if ($num > 0){
				return true;
				} else {
				return false;
			}
		}
		function emailExiste($email)
		{

			$sql = 'SELECT usuario_id FROM usuarios  WHERE usuario_email = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $email, PDO::PARAM_STR);
			$stm->execute();
			//$stm->store_result();
			//$num = $stm->num_rows;
			$num = $stm->rowCount();
			//$stm->close();

			if ($num > 0){
				return true;
				} else {
				return false;
			}
		}
		function generateToken()
		{
			$gen = md5(uniqid(mt_rand(), false));
			return $gen;
		}
		function resultBlock($errors){
			if(count($errors) > 0)
			{
				/*
				echo "<div id='error' class='alert alert-danger' role='alert'>
				<a href='#' onclick=\"showHide('error');\">[X]</a>
				<ul>";
				*/
				echo "<div id='error' class='alert alert-danger alert-dismissible fade show' role='alert'>
				<a href='#' onclick=\"showHide('error');\">
	  		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	    	<span aria-hidden='true'>&times;</span></button></a><ul>";


				foreach($errors as $error)
				{
					echo "<li>".$error."</li>";
				}
				echo "</ul>";
				echo "</div>";
			}
		}
		// este esta para arreglar last insert id

		function registraUsuario($usuario, $pass_hash, $nombre, $apellido, $dni, $email, $activo, $token, $tipo_usuario){

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
																		secretaria_id,
																		destino_id,
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
																		0,
																		0,
																		:usrtipo,
																		:activo)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':usr', $usuario, PDO::PARAM_STR);
			$dec->bindValue(':dni', $dni, PDO::PARAM_STR);
			$dec->bindValue(':apellido', $apellido, PDO::PARAM_STR);
			$dec->bindValue(':nombres', $nombre, PDO::PARAM_STR);
			$dec->bindValue(':email', $email, PDO::PARAM_STR);
			$dec->bindValue(':clave', $pass_hash, PDO::PARAM_STR);
			$dec->bindValue(':token', $token, PDO::PARAM_STR);
			$dec->bindValue(':usrtipo', $tipo_usuario, PDO::PARAM_STR);
			$dec->bindValue(':activo', $activo, PDO::PARAM_STR);
			/*$dec->execute();
			return 1;*/
			if($dec->execute()){
				//return $mysqli->insert_id;
				return $this->cn->lastInsertId();
			}else{
				return 0;
			}
		}

		function hashPassword($password)
		{
			$hash = password_hash($password, PASSWORD_DEFAULT);
			return $hash;
		}
		function enviarEmail($email, $nombre, $asunto, $cuerpo){

			require_once 'PHPMailer/PHPMailerAutoload.php';

			/*$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl'; //Modificar
			$mail->Host = 'smtp.gmail.com'; //Modificar
			$mail->Port = 465; //Modificar

			$mail->Username = 'adhemarcaminos@gmail.com'; //Modificar
			$mail->Password = 'caminos38593123'; //Modificar

			$mail->setFrom('adhemarcaminos@gmail.com', 'nombre de correo emisor'); //Modificar
			$mail->addAddress($email, $nombre);

			$mail->Subject = $asunto;
			$mail->Body    = $cuerpo;
			$mail->IsHTML(true);

			if($mail->send())
			return true;
			else
			return false;*/
			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl'; //Modificar
			$mail->Host = 'c1840430.ferozo.com'; //Modificar
			$mail->Port = 465; //Modificar

			$mail->Username = 'noresponder@gualeguay.gob.ar'; //Modificar
			$mail->Password = 'CraM7sWe'; //Modificar

			$mail->setFrom('noresponder@gualeguay.gob.ar', 'Municipalidad de Gualeguay'); //Modificar
			$mail->addAddress($email, $nombre);

			$mail->Subject = $asunto;
			$mail->Body    = $cuerpo;
			$mail->IsHTML(true);

			if($mail->send())
			return true;
			else
			return false;
		}

		function validaIdToken($id, $token){
			//global $mysqli;
			$sql = 'SELECT usuario_estado
								FROM usuarios
							 WHERE usuario_id = ?
							 	 AND usuario_token = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $id, PDO::PARAM_STR);
			$dec->bindValue(2, $token, PDO::PARAM_STR);
			$dec->execute();
			//return $dec->fetch(PDO::FETCH_OBJ);
			/*$dec->store_result();*/
			$num = $dec->rowCount();

			if($num > 0) {
				list($activacion) = $dec->fetch( PDO::FETCH_NUM);
				//$usractivo = $dec->fetch(PDO::FETCH_OBJ);
				//$activacion = $usractivo->usuario_activo;

				if($activacion == 1){
					$msg = "La cuenta ya se activo anteriormente.";
					} else {
					if(Login::activarUsuario($id)){
						$msg = 'Cuenta activada.';
						} else {
						$msg = 'Error al Activar Cuenta';
					}
				}
				} else {
				$msg = 'No existe el registro para activar.';
			}
			return $msg;
		}


		function activarUsuario($id){
			//global $mysqli;

			$sql = 'UPDATE usuarios
								 SET usuario_estado = 1
							 WHERE usuario_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $id, PDO::PARAM_STR);
			$result = $dec->execute();
			return $result;


		}

		function isNullLogin($usuario, $password){
			if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function login($usuario, $password){

			$sql = 'SELECT usuario_id,usuario_apellido,usuario_nombres,usuario_tipo_id,usuario_password FROM usuarios  WHERE usuario_usuario = ? || usuario_email = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $usuario, PDO::PARAM_STR);
			$stm->bindValue(2, $usuario, PDO::PARAM_STR);
			$stm->execute();
			$rows = $stm->rowCount();

			if($rows > 0){

				if(Login::isActivo($usuario)){

					list($id, $usuarioapellido, $usuarionombres, $id_tipo, $passwd) = $stm->fetch(PDO::FETCH_NUM);

					$validaPassw = password_verify($password, $passwd);

					if($validaPassw){

						Login::lastSession($id);
						session_start();
						$_SESSION['usuario_id'] = $id;
						$_SESSION['usuario_apellido'] = $usuarioapellido;
						$_SESSION['usuario_nombres'] = $usuarionombres;
						$_SESSION['usuariotipo_id'] = $id_tipo;

						header("location: ../panel/index.php");
						}else{
						$errors = "La contrase&ntilde;a es incorrecta";
						}
					}else{
					$errors = 'El usuario no esta activo';
					}
				}else{
				$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
			}
			return $errors;
		}
		function lastSession($id){

			$sql = 'UPDATE usuarios SET usuario_lastsession=NOW(), usuario_tokenpassword="", usuario_passwordrequest=0 WHERE usuario_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_STR);
			$stm->execute();
		}
		function isActivo($usuario){

			$sql = 'SELECT usuario_estado FROM usuarios  WHERE usuario_usuario = ? || usuario_email = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $usuario, PDO::PARAM_STR);
			$stm->bindValue(2, $usuario, PDO::PARAM_STR);
			$stm->execute();
			//$stm->bind_result($activacion);
			//$stm->fetch();
			list($activacion) = $stm->fetch( PDO::FETCH_NUM);


			if ($activacion == 1){
				return true;
			}else{
				return false;
			}
		}

		function generaTokenPass($user_id){
			//global $mysqli;

			$token = Login::generateToken();

			$sql = 'UPDATE usuarios SET usuario_tokenpassword = ?, usuario_passwordrequest = 1 WHERE usuario_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $token, PDO::PARAM_STR);
			$stm->bindValue(2, $user_id, PDO::PARAM_STR);
			$stm->execute();

			/*$stmt = $mysqli->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?");
			$stmt->bind_param('ss', $token, $user_id);
			$stmt->execute();*/
			//$stmt->close();

			return $token;
		}


		function getValor($campo, $campoWhere, $valor){
			//global $mysqli;
			$sql = 'SELECT '.$campo.' FROM usuarios  WHERE '.$campoWhere.' = ? LIMIT 1';
			$dec = $this->cn->prepare($sql);
			/*$dec->bindValue(1, $campo, PDO::PARAM_STR);
			$dec->bindValue(2, $campoWhere, PDO::PARAM_STR);*/
			$dec->bindValue(1, $valor, PDO::PARAM_STR);
			$dec->execute();

			/*$stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");
			$stmt->bind_param('s', $valor);
			$stmt->execute();
			$stmt->store_result();
			$num = $stmt->num_rows;*/
			$num = $dec->rowCount();

			if($num > 0){
				/*$stmt->bind_result($_campo);
				$stmt->fetch();*/
				list($_campo) = $dec->fetch( PDO::FETCH_NUM);
				return $_campo;
			}else{
				return null;
			}
		}

		/*
		function getPasswordRequest($id)
		{
			global $mysqli;

			$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?");
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->bind_result($_id);
			$stmt->fetch();

			if ($_id == 1)
			{
				return true;
			}
			else
			{
				return null;
			}
		}
		*/

		function verificaTokenPass($user_id, $token){

			//global $mysqli;
			$sql = 'SELECT usuario_estado FROM usuarios WHERE usuario_id = ? AND usuario_tokenpassword = ? AND usuario_passwordrequest = 1 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $user_id, PDO::PARAM_STR);
			$dec->bindValue(2, $token, PDO::PARAM_STR);
			$dec->execute();

			$num = $dec->rowCount();

			if($num > 0){
				/*$stmt->bind_result($activacion);
				$stmt->fetch();*/
				list($activacion) = $dec->fetch(PDO::FETCH_NUM);
				//return $_campo;
				if($activacion == 1){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}


			/*$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
			$stmt->bind_param('is', $user_id, $token);
			$stmt->execute();
			$stmt->store_result();
			$num = $stmt->num_rows;

			if ($num > 0)
			{
				$stmt->bind_result($activacion);
				$stmt->fetch();
				if($activacion == 1)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}*/
		}


	  function cambiaPassword($password, $user_id, $token){

			//global $mysqli;
			$sql = 'UPDATE usuarios SET usuario_password = ?, usuario_tokenpassword = "", usuario_passwordrequest = 0 WHERE usuario_id = ? AND usuario_tokenpassword = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $password, PDO::PARAM_STR);
			$dec->bindValue(2, $user_id, PDO::PARAM_STR);
			$dec->bindValue(3, $token, PDO::PARAM_STR);
			if($dec->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function ListarUsuarios(){
			try{
				$sql = $this->cn->prepare("SELECT * FROM usuarios");
				$sql->execute();
				return $sql->fetchAll(PDO::FETCH_OBJ);
			}catch (Exception $e){
				die($e->getMessage());
			}
		}
	}
