<?php
class Legajo{
	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		$this->cn;
	}

	public function DniTiposListar(){
	 try{
		 $sql = $this->cn->prepare("SELECT *
																	FROM documentos_tipo
																ORDER BY doctipo_nombre");
		 $sql->execute();
		 return $sql->fetchAll(PDO::FETCH_OBJ);
	 }catch (Exception $e){
		 die($e->getMessage());
	 }
	}

	public function EstadoCivilListar(){
	 try{
		 $sql = $this->cn->prepare("SELECT *
																	FROM estados_civiles
																ORDER BY estcivil_nombre");
		 $sql->execute();
		 return $sql->fetchAll(PDO::FETCH_OBJ);
	 }catch (Exception $e){
		 die($e->getMessage());
	 }
	}

	public function EscuelaListar(){
	 try{
		 $sql = $this->cn->prepare("SELECT *
																	FROM escuelas
																ORDER BY escuela_nombre");
		 $sql->execute();
		 return $sql->fetchAll(PDO::FETCH_OBJ);
	 }catch (Exception $e){
		 die($e->getMessage());
	 }
	}
	public function NivelListar(){
	 try{
		 $sql = $this->cn->prepare("SELECT *
																	FROM escuelas_nivel
																ORDER BY escuela_nivel_nombre");
		 $sql->execute();
		 return $sql->fetchAll(PDO::FETCH_OBJ);
	 }catch (Exception $e){
		 die($e->getMessage());
	 }
	}

	public function SexoListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM sexos
															 	 ORDER BY sexo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObraSocialListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM obra_social
																 ORDER BY obra_social_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function LocalidadListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM localidades
																 ORDER BY localidad_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

public function JubiladoObtener($doc){
	try{

		$sql = 'SELECT *
						FROM cjmdg_personal
						WHERE cjmdg_personal_nrodoc= ?
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $doc, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function JubiladoObtenerHaber($leg){
	try{

		$sql = 'SELECT *
						FROM legajos a,obra_social b
						WHERE legajo_id= ?
						AND a.obra_social_id=b.obra_social_id
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function JubiladoObtenerLeg($leg){
	try{

		$sql = 'SELECT *
						FROM legajos a,obra_social b,documentos_tipo c
						WHERE legajo_id= ?
						AND a.obra_social_id=b.obra_social_id
						and a.tipo_docto_id =c.doctipo_id
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function FamiliaresListar($leg){
	try{

		$sql = 'SELECT *
						FROM hijos a, documentos_tipo b
						WHERE legajo_id= ?
						AND a.hijo_tipodocto=b.doctipo_id
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ConyugeListar($leg){
	try{

		$sql = 'SELECT *
						FROM conyuges a, documentos_tipo b
						WHERE legajo_id= ?
						AND a.conyuge_tipodocto=b.doctipo_id
						AND conyuge_estado_id=1
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ConyugeModiListar($leg){
	try{

		$sql = 'SELECT *
						FROM conyuges a, documentos_tipo b
						WHERE conyuge_id= ?
						AND a.conyuge_tipodocto=b.doctipo_id
						AND conyuge_estado_id=1
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ApoderadoListar($leg){
	try{

		$sql = 'SELECT *
						FROM legajos_apoderado
						WHERE legajo_id= ?
						AND legapoderado_estado=1
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ApoderadoObtenerLeg($leg){
	try{

		$sql = 'SELECT *
						FROM legajos_apoderado
						WHERE legajo_id= ?
						AND legapoderado_estado=1
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ListarJubilados(){
	try{

		$sql = "SELECT *
						FROM legajos a,documentos_tipo b,sexos c,situaciones_revista d
						WHERE d.situacion_revista_fecingreso != 'NULL'
						AND empresa_id=2
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						AND a.legajo_id=d.legajo_id
						AND d.situacion_revista_descripcion='JUBILACION'
						";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ListarPensionados(){
	try{

		$sql = "SELECT *
						FROM legajos a,documentos_tipo b,sexos c,situaciones_revista d
						WHERE d.situacion_revista_fecingreso != 'NULL'
						AND empresa_id=2
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						AND a.legajo_id=d.legajo_id
						AND d.situacion_revista_id=3
						";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ListarAJubilar(){
	try{

		$sql = "SELECT *
						FROM legajos a,documentos_tipo b,sexos c,situaciones_revista d
						WHERE d.situacion_revista_fecegreso != 'NULL'
						AND empresa_id=1
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						AND a.legajo_id=d.legajo_id
						AND d.situacion_revista_descripcion='JUBILACION'
						";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ListarUnAJubilar($id){
	try{

		$sql = 'SELECT *
						FROM legajos a,documentos_tipo b,sexos c
						WHERE empresa_id=2
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						AND a.id=?
						';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $id, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function LegajoDatosFamiliaresModiExe($data){
	try{


		$sql = 'INSERT INTO hijos (legajo_id,
																					 hijo_tipodocto,
																					 hijo_nrodocto,
																					 hijo_apellido,
																					 hijo_nombres,
																					 sexo_id,
																					 hijo_fecnacto,
																					 hijo_direccion,
																					 localidad_id,
																					 hijo_disc,
																					 hijo_esc
																				   )
																			 VALUES(:legajo,
																				 			:tipodocto,
																							:nrodocto,
																							:apellido,
																							:nombres,
																							:sexo,
																							:fecnac,
																							:dir,
																							:loc,
																							:disc,
																							:esc
																							)';
		$dec = $this->cn->prepare($sql);

		$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(':tipodocto', $data->leghijo_tipodocto, PDO::PARAM_STR);
		$dec->bindValue(':nrodocto', $data->leghijo_nrodocto, PDO::PARAM_STR);
		$dec->bindValue(':apellido', $data->leghijo_apellido, PDO::PARAM_STR);
		$dec->bindValue(':nombres', $data->leghijo_nombres, PDO::PARAM_STR);
		$dec->bindValue(':sexo', $data->sexo_id, PDO::PARAM_STR);
		$dec->bindValue(':fecnac', $data->leghijo_fecnacto, PDO::PARAM_STR);
		$dec->bindValue(':dir', $data->leghijo_direccion, PDO::PARAM_STR);
		$dec->bindValue(':loc', $data->localidad_id, PDO::PARAM_STR);

		$dec->bindValue(':disc', 1, PDO::PARAM_STR);
		$dec->bindValue(':esc', 1, PDO::PARAM_STR);
		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}

}


public function LegajoDatosConyugeModiExe($data){
	try{

	 $sql = 'UPDATE conyuges
							 SET conyuge_apellido = ?,
							     conyuge_nombres = ?,
									 conyuge_nrodocto = ?,
									 conyuge_tipodocto = ?,
									 conyuge_fecnato = ?,
									 conyuge_direccion = ?,
							   	 conyuge_celular = ?
							 WHERE conyuge_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_apellido, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_nombres, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_dni, PDO::PARAM_STR);
		$dec->bindValue(4, $data->legajo_tipodni, PDO::PARAM_STR);
		$dec->bindValue(5, $data->legajo_fecnac, PDO::PARAM_STR);
		$dec->bindValue(6, $data->legajo_direccion, PDO::PARAM_STR);
		$dec->bindValue(7, $data->legajo_celular, PDO::PARAM_STR);
		$dec->bindValue(8, $data->legajo_conyugeid, PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function LegajoDatosPersonalesModiExe($data){
	try{

		$sql = 'UPDATE legajos
							 SET sexo_id = ?,
							 		 estado_civil_id = ?,
									 legajo_direccion = ?,
									 legajo_fecnacto = ?,
									 obra_social_id = ?,
									 localidad_id = ?,
									 legajo_celular = ?
							 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_sexo_id, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_ecivil, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_direccion, PDO::PARAM_STR);
		$dec->bindValue(4, $data->legajo_fecnacto, PDO::PARAM_STR);
		$dec->bindValue(5, $data->legajo_os, PDO::PARAM_STR);
		$dec->bindValue(6, $data->legajo_localidad, PDO::PARAM_STR);
		$dec->bindValue(7, $data->legajo_celu, PDO::PARAM_STR);
		$dec->bindValue(8, $data->legajo_nroleg, PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function LegajoDatosJubiladoNuevo($data){
	try{
		$sql = 'UPDATE situaciones_revista
							 SET situacion_revista_fecegreso = ?,
							 situacion_revista_activo=0,
							 situacion_revista_descripcion="JUBILACION"
							 WHERE legajo_id = ?
							 AND situacion_revista_activo=1';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajos_fecing, PDO::PARAM_STR);
	  	$dec->bindValue(2, $data->legajos_nroleg, PDO::PARAM_STR);
	  	$dec->bindValue(2, $data->legajos_nroleg, PDO::PARAM_STR);


		$dec->execute();

		$sql = 'INSERT INTO situaciones_revista (legajo_id,
																					 situacion_revista_fecingreso,
																				   situacion_revista_activo)
																			 VALUES(:legajo,
																							:fecha,
																							1)';
		$dec = $this->cn->prepare($sql);

		$dec->bindValue(':legajo', $data->legajos_nroleg, PDO::PARAM_STR);
		$dec->bindValue(':fecha', $data->legajos_fecing, PDO::PARAM_STR);
		$dec->execute();

		$sql = 'UPDATE legajos
							 SET empresa_id = 2
							 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajos_nroleg, PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}

}

public function LegajoDatosApoderadoModiExe($data){
	try{

		$sql = 'UPDATE legajos_apoderado
							 SET  legapoderado_nrodocto= ?,
							 legapoderado_nombres=?,
							 legapoderado_apellido=?,
							 legapoderado_direccion=?
							 WHERE legajos_apoderado_legapoderado_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajos_apoderado_dni , PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajos_apoderado_nombre, PDO::PARAM_STR);
  	$dec->bindValue(3, $data->legajos_apoderado_ape, PDO::PARAM_STR);
		$dec->bindValue(4, $data->legajos_apoderado_direccion, PDO::PARAM_STR);
		$dec->bindValue(5, $data->legajos_apoderado_legapoderado_id, PDO::PARAM_STR);
		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ApoderadoGuardarExe($data){
	try{

		$sql = 'INSERT INTO legajos_apoderado (legajo_id,
																					 legapoderado_nrodocto,
																					 legapoderado_apellido,
																					 legapoderado_nombres,
																					 legapoderado_direccion,
																					 legapoderado_estado,
																					 legapoderado_celular
																					 )
																			 VALUES(:legajo,
																							:nrodocto,
																							:apellido,
																							:nombres,
																						  :dir,
																							1,
																							:cel
																							)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(':nrodocto', $data->legapoderado_nrodocto , PDO::PARAM_STR);
		$dec->bindValue(':apellido', $data->legapoderado_apellido, PDO::PARAM_STR);
  	$dec->bindValue(':nombres', $data->legapoderado_nombres, PDO::PARAM_STR);
		$dec->bindValue(':dir', $data->legapoderado_direccion, PDO::PARAM_STR);
		$dec->bindValue(':cel', $data->legapoderado_celular, PDO::PARAM_STR);


		$dec->execute();
	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ConyugeGuardarExe($data){
	try{

		$sql = 'INSERT INTO conyuges (legajo_id,
																					 conyuge_tipodocto,
																					 conyuge_nrodocto,
																					 conyuge_apellido,
																					 conyuge_nombres,
																					 conyuge_fecnato,
																					 conyuge_direccion,
																					 conyuge_celular,
																					 conyuge_estado_id
																					 )
																			 VALUES(:legajo,
																				 	    :tipodocto,
																							:nrodocto,
																							:apellido,
																							:nombres,
																							:fecnato,
																						  :dir,
																							:cel,
																							1)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
    $dec->bindValue(':tipodocto', $data->legapoderado_tipo_docto_id , PDO::PARAM_STR);
		$dec->bindValue(':nrodocto', $data->legapoderado_nrodocto , PDO::PARAM_STR);
		$dec->bindValue(':apellido', $data->legapoderado_apellido, PDO::PARAM_STR);
  	$dec->bindValue(':nombres', $data->legapoderado_nombres, PDO::PARAM_STR);
		$dec->bindValue(':fecnato', $data->legapoderado_fec, PDO::PARAM_STR);
		$dec->bindValue(':dir', $data->legapoderado_direccion, PDO::PARAM_STR);
		$dec->bindValue(':cel', $data->legapoderado_celular, PDO::PARAM_STR);

		$dec->execute();
	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function JubiladoGuardarExe($data){
	try{

		$sql = 'INSERT INTO legajos (legajo_nrodocto,
																tipo_docto_id,
																legajo_apellido,
																legajo_nombres,
																sexo_id,
																legajo_fecnacto,
																obra_social_id,
																localidad_id,
																legajo_direccion,
																legajo_celular,
																cjmdg_personal_nroleg,
																empresa_id,
																legajo_estado_id
																)
																VALUES(:nrodocto,
																		   :tipo,
																	  	 :apellido,
																			 :nombres,
																		   :sexo,
																			 :fec,
																			 :os,
																			 :loc,
																		   :dir,
																	 		 :cel,
																			 :nroleg,
																			 1,
																			 1
																			 )';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':nrodocto', $data->legapoderado_nrodocto , PDO::PARAM_STR);
		$dec->bindValue(':tipo', $data->legapoderado_tipo_docto_id , PDO::PARAM_STR);
		$dec->bindValue(':apellido', $data->legapoderado_apellido, PDO::PARAM_STR);
  	$dec->bindValue(':nombres', $data->legapoderado_nombres, PDO::PARAM_STR);
		$dec->bindValue(':sexo', $data->legapoderado_sexo, PDO::PARAM_STR);
   	$dec->bindValue(':fec', $data->legapoderado_fecnac, PDO::PARAM_STR);
		$dec->bindValue(':os', $data->legapoderado_os, PDO::PARAM_STR);
		$dec->bindValue(':loc', $data->legapoderado_localidad, PDO::PARAM_STR);
		$dec->bindValue(':dir', $data->legapoderado_direccion, PDO::PARAM_STR);
  	$dec->bindValue(':cel', $data->legapoderado_celular, PDO::PARAM_STR);
    $dec->bindValue(':nroleg', $data->legapoderado_nroleg, PDO::PARAM_STR);

		$dec->execute();
		$ultimoid = $this->cn->lastInsertId();

		$sql = 'INSERT INTO situaciones_revista (legajo_id,
																					 situacion_revista_fecingreso,
																					 situacion_revista_fecegreso,
																					 situacion_revista_descripcion,
																					 situacion_revista_activo)
																			 VALUES(:nroleg,
																							NOW(),
																							NOW(),
																							"JUBILACION",
																							1)';
		$dec = $this->cn->prepare($sql);

		$dec->bindValue(':nroleg', $ultimoid, PDO::PARAM_STR);
		//$dec->bindValue(':fecha', $data->legajos_fecing, PDO::PARAM_STR);
		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ApoderadoEliminarExe($data){
	try{

		$sql = 'UPDATE legajos_apoderado
							 SET  legapoderado_estado=0
							 WHERE legapoderado_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legapoderado_id, PDO::PARAM_STR);
		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ConyugeEliminarExe($data){
	try{

		$sql = 'UPDATE conyuges
							 SET  conyuge_estado_id=0
							 WHERE conyuge_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legapoderado_id, PDO::PARAM_STR);
		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ApoderadoModificarExe($data){
	try{

		$sql = 'UPDATE legajos_apoderado
  					 SET legapoderado_nrodocto = ?,
						 legapoderado_tipo_doc = ?,
						 legapoderado_nombres = ?,
						 legapoderado_apellido = ?,
						 legapoderado_direccion = ?,
						 legapoderado_celular = ?
 						 WHERE legapoderado_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legapoderado_dni, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legapoderado_tipodni, PDO::PARAM_STR);
  	$dec->bindValue(3, $data->legapoderado_nombres, PDO::PARAM_STR);
		$dec->bindValue(4, $data->legapoderado_apellido, PDO::PARAM_STR);
		$dec->bindValue(5, $data->legapoderado_direccion, PDO::PARAM_STR);
		$dec->bindValue(6, $data->legapoderado_celular, PDO::PARAM_STR);
	  $dec->bindValue(7, $data->legapoderado_id, PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

}
