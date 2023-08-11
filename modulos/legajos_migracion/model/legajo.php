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


	public function ObtenerTipoLegajo($nrodocto){
		try{

			$sql = 'SELECT b.legtipo_nombre FROM legajos a, legajos_tipo b WHERE a.legtipo_id = b.legtipo_id AND a.legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

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

public function JubiladoObtenerCat($leg){
	try{

		$sql = 'SELECT b.categoria_jub_id,categoria_jub_abreviacion
						FROM legajos a,categoria_jub b
						WHERE legajo_id= ?
						AND a.categoria_jub_id=b.categoria_jub_id
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function JubiladoObtenerEdicionHaber($leg){
	try{

		$sql = 'SELECT *
				FROM legajos a,haber_jub_anual b
				WHERE b.legajo_id= ?
				AND a.legajo_id=b.legajo_id
				LIMIT 1
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function ListarHaberAnual($jubi){
	try{

		$sql = 'SELECT *
		FROM haber_jubilado a,legajos b
		WHERE a.legajo_id= ?
		AND a.legajo_id=b.legajo_id
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $jubi, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ListarHaberMensual($jubi,$anio){
	try{

		$sql = 'SELECT *
						FROM haber_jub_mensual
						WHERE legajo_id= ?
						AND anio=?
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $jubi, PDO::PARAM_STR);
		$dec->bindValue(2, $anio, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Paises(){
	try{

		$sql = $this->cn->prepare("SELECT *
																 FROM paises
														 ORDER BY pais_nombre");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function TiposDocto(){
	try{
		$sql = $this->cn->prepare("SELECT * FROM documentos_tipo ORDER BY doctipo_abreviacion");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Sexos(){
	try{

		$sql = $this->cn->prepare("SELECT * FROM sexos ORDER BY sexo_nombre");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function EstadosC(){
	try{

		$sql = $this->cn->prepare("SELECT * FROM estados_civiles");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Provincias(){
	try{

	$sql = $this->cn->prepare("SELECT *
															  FROM provincias
													 ORDER BY provincia_nombre");
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function departamentos(){
	try{

		$sql = $this->cn->prepare("SELECT *
																 FROM departamentos
														 ORDER BY departamento_nombre");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function ObtenerDepartamentos($pro){
	try{

		$sql = 'SELECT *
		FROM departamentos
		WHERE provincia_id= ?
		ORDER BY departamento_nombre
		';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $pro, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Paises1($pa){
	try{

		$sql = "SELECT *
																 FROM paises
														 WHERE pais_id=?";

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $pa, PDO::PARAM_STR);
		$dec->execute();
		$row = $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Provincias1($p){
	try{

	$sql = "SELECT *
															  FROM provincias
															 WHERE provincia_id=?
													LIMIT 1 ";
	$dec = $this->cn->prepare($sql);
	$dec->bindValue(1, $p, PDO::PARAM_STR);
	$dec->execute();
	$row = $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Departamentos1($p){
	try{

	$sql = "SELECT *
															  FROM departamentos
															 WHERE departamento_id=?
													LIMIT 1 ";
	$dec = $this->cn->prepare($sql);
	$dec->bindValue(1, $p, PDO::PARAM_STR);
	$dec->execute();
	$row = $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Localidades1($p){
	try{

	$sql = "SELECT *
															  FROM localidades
															 WHERE localidad_id=?
													LIMIT 1 ";
	$dec = $this->cn->prepare($sql);
	$dec->bindValue(1, $p, PDO::PARAM_STR);
	$dec->execute();
	$row = $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function ObtenerProvincias($pa){
	try{

		$sql = 'SELECT *
		FROM provincias
		WHERE pais_id= ?
		ORDER BY provincia_nombre
		';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $pa, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}
public function Localidades(){
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

public function JubiladoObtenerLeg($leg){
	try{

		$sql = 'SELECT *
		FROM legajos a,obra_social b,documentos_tipo c
		WHERE a.legajo_id= ?
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

public function JubiladoObtenerHab($leg){
	try{

		$sql = 'SELECT *
		FROM haber_jubilado
		WHERE legajo_id= ?
		';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function JubiladoObtenerLiq($leg){
	try{

		$sql = 'SELECT *
		FROM liquidaciones
		WHERE legempleado_numerol=?
		LIMIT 1
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
						FROM legajos_hijo a
						WHERE legajo_id= ?
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
						FROM legajos_conyuge a
						WHERE legajo_id= ?
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
						FROM legajos_conyuge a, documentos_tipo b
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


public function ListarFechaJubilacion($leg){
	try{

		$sql = 'SELECT *
						FROM situaciones_revista
						WHERE legajo_id= ?
						ORDER BY situacion_revista_id DESC
						LIMIT 1
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}



public function JubiladoTiposListar(){
	try{

		$sql = "SELECT *
						FROM legajos_tipos
						";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function JubiladoTiposJubilacion(){
	try{

		$sql = "SELECT *
						FROM categoria_jub
						";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function ListarCategoriaAnual($leg){
	try{

		$sql = 'SELECT *
						FROM liquidacion_jub_categoria
						WHERE legajo_id= ?
						GROUP BY categoria_liq_id
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
						FROM legajos_apoderado a,legajos b
						WHERE a.legajo_id= b.legajo_id
						AND a.legajo_id=?
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

public function BancoObtenerLeg($leg){
	try{

		$sql = 'SELECT b.legajo_tipo_id,c.legajo_id, legajo_tipo_nombre,numero_cuenta,sucursal FROM legajos a,legajos_tipos b,legajo_banco c
		WHERE a.legajo_tipo_id=b.legajo_tipo_id
		AND a.legajo_id=c.legajo_id
		AND c.legajo_id=?
		AND c.activo_n=1
						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function JubilacionDatosObtener($leg){
	try{
		//armar la consulta
		$sql = 'SELECT *
						FROM situacion_revista
						WHERE legajo_id= ?
						ORDER BY anio DESC

						';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $leg, PDO::PARAM_STR);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function JubiladoHaberObtener($leg){
	try{

		$sql = 'SELECT *
						FROM haber_jub_anual
						WHERE legajo_id= ?
						ORDER BY anio DESC

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
						FROM legajos a,documentos_tipo b,sexos c,legajos_tipos d
						WHERE empresa_id=2
						AND d.legajo_tipo_id=a.legajo_tipo_id
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						ORDER BY a.legajo_id
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
						FROM legajos a,documentos_tipo b,sexos c,legajos_tipos d,legajo_banco e
						WHERE empresa_id=2
						AND d.legajo_tipo_id=a.legajo_tipo_id
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						AND a.legajo_tipo_id=3
						AND a.legajo_id=e.legajo_id
						ORDER BY a.legajo_id
							";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ListarActivos(){
	try{

		$sql = "SELECT *
						FROM legajos a,documentos_tipo b,sexos c,legajos_tipos d,legajo_banco e
						WHERE empresa_id=2
						AND d.legajo_tipo_id=a.legajo_tipo_id
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						AND a.legajo_tipo_id=1
						AND a.legajo_id=e.legajo_id
						ORDER BY a.legajo_id
							";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function ListarJubiladosUnico(){
	try{

		$sql = "SELECT *
						FROM legajos a,documentos_tipo b,sexos c,legajos_tipos d,legajo_banco e
						WHERE empresa_id=2
						AND d.legajo_tipo_id=a.legajo_tipo_id
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
						AND a.legajo_tipo_id=2
						AND a.legajo_fecegr='0000-00-00'
						AND a.legajo_id=e.legajo_id
						ORDER BY a.legajo_id
							";
		$dec = $this->cn->prepare($sql);
		$dec->execute();
		return $dec->fetchAll(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function ListarEmpleados(){
	try{

		$sql = "SELECT *
						FROM legajos a,documentos_tipo b,sexos c
						WHERE empresa_id=2
						AND legajo_tipo_id=1
						AND a.tipo_docto_id=b.doctipo_id
						AND a.sexo_id=c.sexo_id
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

		//$sql = "SELECT *
		//		FROM legajos a,documentos_tipo b,sexos c,situaciones_revista d
		//		WHERE empresa_id=2
		//		AND a.tipo_docto_id=b.doctipo_id
		//		AND a.sexo_id=c.sexo_id
		//		AND jubilado=0
		//		AND a.legajo_id=d.legajo_id
		//		ORDER BY d.situacion_revista_id DESC
		//		LIMIT 1
		//		";
		$sql = "SELECT *
				FROM legajos a,documentos_tipo b,sexos c
				WHERE empresa_id=2
				AND a.tipo_docto_id=b.doctipo_id
		    	AND a.sexo_id=c.sexo_id
				AND jubilado=0
				ORDER BY legajo_id DESC

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

public function ListarPrimerPeriodo($id){
	try{

		$sql = 'SELECT max(periodo_id) - 45,periodo_id
						FROM liquidaciones
						WHERE legempleado_numerol=?
						';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $id, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

	}catch (Exception $e){
		die($e->getMessage());
	}
}




public function ListarPrimerAnio($id){
	try{

		$sql = 'SELECT LEFT(periodo_nombre,4) anio,RIGHT(periodo_nombre,2) mes, periodo_id
						FROM periodos
						WHERE periodo_id=?
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


		$sql = 'INSERT INTO legajo_hijos (legajo_id,
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

		$sql = 'INSERT INTO liquidacion_novedades (legajo_id,
		liqcod_id,
		importe_novedad,
		 periodo_id)
		VALUES(:legajo,
		:codtipo,
		:importe,
		:peri
		)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(':codtipo', 200 , PDO::PARAM_STR);
		$dec->bindValue(':importe', 0, PDO::PARAM_STR);
		$dec->bindValue(':peri', $_SESSION['periodo'] , PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}

}


public function LegajoDatosConyugeModiExe($data){
	try{

	 $sql = 'UPDATE legajos_conyuge
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

public function LegajoDatosHijoModiExe($data){
	try{

	 $sql = 'UPDATE legajos_hijo
							 SET leghijo_apellido = ?,
							     leghijo_nombres = ?,
								 leghijo_nrodocto = ?,
								 leghijo_tipodocto = ?,
							     leghijo_direccion = ?,
									 leghijo_fecnacto=?
								 WHERE leghijo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_apellido, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_nombres, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_dni, PDO::PARAM_STR);
		$dec->bindValue(4, $data->legajo_tipodni, PDO::PARAM_STR);
		$dec->bindValue(5, $data->legajo_direccion, PDO::PARAM_STR);
		$dec->bindValue(6, $data->legajo_fecnac, PDO::PARAM_STR);
		$dec->bindValue(7, $data->legajo_hijoid, PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function HaberImporteModiExe($data){
	try{

		$sql = 'UPDATE haber_jubilado
							 SET importe_suma = ?,
							 	importe_haber=?,
								generada=1
							 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->importe_haber, PDO::PARAM_STR);
		$dec->bindValue(2, $data->importe_haber, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo, PDO::PARAM_STR);

		$dec->execute();


	}catch (Exception $e){
		die($e->getMessage());
	}
}




public function GenerarHaberInicialExe($data){
	try{
		$importe_ios=$data->importe * (3/100);

		$sql = 'INSERT INTO cjmdg_cabsueldo(cjmdg_cabsueldo_catjub,
							cjmdg_cabsueldo_nroleg2,
							periodo_id
							 )
							VALUES(:cat,
							:legajo2,
							:periodo)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':cat', 0, PDO::PARAM_STR);
		$dec->bindValue(':legajo2', $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(':periodo', 0, PDO::PARAM_STR);

		$dec->execute();

		$sql = 'INSERT INTO cjmdg_detsueldo(cjmdg_detsueldo_nroleg,cjmdg_detsueldo_codconcep,cjmdg_detsueldo_detconcep,cjmdg_detsueldo_importe)
		(SELECT c.legajo_id,a.liqcod_id,b.liqcod_descripcion,d.importe_haber FROM liquidacion_inicial_codigos a,liquidaciones_codigo b,legajos c,haber_jubilado d
		WHERE c.legajo_id=?
		AND c.legajo_id=d.legajo_id
		AND a.liqcod_id=b.liqcod_id
		AND a.legajo_tipo_id=c.legajo_tipo_id)';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);

		$dec->execute();

		$sql = 'UPDATE legajos
				 SET jubilado=1
				 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);

		$dec->execute();

		$sql = 'INSERT INTO liquidacion_codigos_mensual(liqcod_id,legajo_id,periodo_id,empresa_id,legajo_tipo_id)
		(SELECT a.liqcod_id,c.legajo_id,0,2,2
		FROM liquidacion_inicial_codigos a,liquidaciones_codigo b,legajos c,haber_jubilado d
		WHERE c.legajo_id=?
		AND c.legajo_id=d.legajo_id
		AND a.liqcod_id=b.liqcod_id
		AND a.legajo_tipo_id=c.legajo_tipo_id)';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);

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
									 legajo_fecing=?,
									 legajo_disc=?
							 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_sexo_id, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_ecivil, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_direccion, PDO::PARAM_STR);
		$dec->bindValue(4, $data->legajo_fecnacto, PDO::PARAM_STR);
		$dec->bindValue(5, $data->legajo_fecjub, PDO::PARAM_STR);
		$dec->bindValue(6, $data->legajo_disc, PDO::PARAM_STR);
		$dec->bindValue(7, $data->legajo_nroleg, PDO::PARAM_STR);


		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function LegajoDatosBancoModiExe($data){
	try{

		$sql = 'UPDATE legajo_banco
							 SET numero_cuenta = ?,
							 		 sucursal = ?
							 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_ctabco, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_suc, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_nroleg, PDO::PARAM_STR);

		$dec->execute();

		$sql = 'UPDATE legajos
							 SET legajo_tipo_id = ?,
							 		 categoria_liq_id = ?
							 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_tipoid, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_catid, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_nroleg, PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}






public function LegajoDatosJubiladoNuevo($data){
	try{
		//$sql = 'UPDATE situaciones_revista
		//				 SET situacion_revista_fecegreso = ?,
		//				 situacion_revista_activo=0,
		//				 situacion_revista_descripcion="JUBILACION"
		//				 WHERE legajo_id = ?
		//			 AND situacion_revista_activo=1';
		//$dec = $this->cn->prepare($sql);
		//$dec->bindValue(1, $data->legajos_fecing, PDO::PARAM_STR);
	  	//$dec->bindValue(2, $data->legajos_nroleg, PDO::PARAM_STR);

		//$dec->execute();

		list($aniojub, $mesjub, $diajub)= explode("-", $data->legajos_fecing);

		if($mesjub==1){$fec= date("Y-m-d",strtotime($data->legajos_fecing."- 10 year 1 month"));}else{$fec= date("Y-m-d",strtotime($data->legajos_fecing."- 10 year"));}

		list($anio, $mes, $dia)= explode("-", $fec);
		$anio2=$anio; if($mesjub!=1){$cantidad=12;}else{$cantidad=11;}

		$sql = 'INSERT INTO situaciones_revista (legajo_id,
								 situacion_revista_fecingreso,
								 situacion_revista_fecantiguedad,
								 situacion_revista_descripcion,
							     situacion_revista_activo)
								 VALUES(:legajo,
										:fecha,
										:fecha1,
										"JUBILADO",
										1)';
		$dec = $this->cn->prepare($sql);

		$dec->bindValue(':legajo', $data->legajos_nroleg, PDO::PARAM_STR);
		$dec->bindValue(':fecha', $data->legajos_fecing, PDO::PARAM_STR);
		$dec->bindValue(':fecha1', $fec, PDO::PARAM_STR);
		$dec->execute();
		$ultimoid = $this->cn->lastInsertId();

		$sql ='UPDATE legajos
						 SET empresa_id = 2,
						 situacion_revista_id=?,
						 jubilado=0
						 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajos_nroleg, PDO::PARAM_STR);
		$dec->execute();

		for($i=1; $i< $cantidad; $i++){

			$sql = 'INSERT INTO haber_jub_anual(importe_haber_anual,anio,legajo_id)
			VALUES(:monto,
							:anioo,
							:legajo)';

		//$sql = 'INSERT INTO haber_jub_anual (importe_haber_anual,anio,legajo_id)
		//				(SELECT SUM(importe_haber_mensual) importe,anio,legajo_id
		//				FROM haber_jub_mensual
		//				WHERE legajo_id=?
		//				GROUP BY anio)';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':monto', 0, PDO::PARAM_STR);
		$dec->bindValue(':anioo', $anio2, PDO::PARAM_STR);
		$dec->bindValue(':legajo', $data->legajos_nroleg, PDO::PARAM_STR);

		$dec->execute();
		$anio2++;
		}
		//$j=$mes;
		for($i=1; $i< 121; $i++){

				$sql = 'INSERT INTO haber_jub_mensual (legajo_id,anio,mes,importe_haber_mensual)
																		VALUES(:legajo,
																						:anioo,
																						:mes,
																						0)';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':legajo', $data->legajos_nroleg, PDO::PARAM_STR);
				$dec->bindValue(':anioo', $anio, PDO::PARAM_STR);
				$dec->bindValue(':mes', $mes, PDO::PARAM_STR);

				$dec->execute();
				if($mes==12){$anio++;$mes=1;}else{$mes++;}


		}

		$sql = 'INSERT INTO haber_jubilado(importe_suma,
				legajo_id,
				periodo_id)
				VALUES(0,
				:legajo,
				:perio)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':legajo', $data->legajos_nroleg, PDO::PARAM_STR);
		$dec->bindValue(':perio', $data->legajos_per, PDO::PARAM_STR);
		$dec->execute();


	}catch (Exception $e){
		die($e->getMessage());
	}

}

public function LegajoDatosHaberModiExe($data){
	try{
		$ultper=$data->per;
		$anio=$data->anio;

		for ($i = 1; $i < 120; $i++){
			$sql = 'INSERT INTO haber_jub_mensual (legajo_id,
																				 anio,
																				 importe_haber_anual)
																 	VALUES(:legajo,
																			  	:fecha,
																					0)';

			$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
			$dec->bindValue(':legajo', $anio, PDO::PARAM_STR);

			$dec->execute();
		}
		$sql = 'INSERT INTO haber_jub_mensual (importe_haber_mensual,
																			 anio,
																			 mes,
																		   legajo_id)
																			 (SELECT SUM(liquidacion_importe),LEFT(periodo_nombre,4) anio_jub,RIGHT(periodo_nombre,2) mes_jub,legempleado_numerol
																				FROM liquidaciones a, periodos b
																				WHERE liqcodtipo_id=1
																				AND legempleado_numerol=?
																				AND a.periodo_id=b.periodo_id
																				AND a.periodo_id > 3
																				GROUP BY RIGHT(periodo_nombre,2)
																				)';

				$dec = $this->cn->prepare($sql);

				$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
				$dec->execute();
		$sql='INSERT INTO haber_jub_anual (importe_haber_anual,anio,legajo_id)(SELECT SUM(liquidacion_importe) importe,LEFT(periodo_nombre,4) anio_jub,legempleado_numerol
				FROM liquidaciones a, periodos b
				WHERE liqcodtipo_id=1
				AND legempleado_numerol=?
				AND a.periodo_id=b.periodo_id
				GROUP BY LEFT(periodo_nombre,4))';



	}catch (Exception $e){
		die($e->getMessage());
	}

}

public function CategoriaEliminarExe($data){
	try{

		$sql = 'UPDATE haber_jub_mensual
							 SET  importe_haber_mensual= 0,
							 categoria_id=0,
							 porcentaje_antiguedad=0
							 WHERE legajo_id = ?
							 AND categoria_id=?
							 ';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_id , PDO::PARAM_STR);
		$dec->bindValue(2, $data->categoria_id, PDO::PARAM_STR);
  		$dec->execute();

		  $sql='UPDATE haber_jub_anual a
		  SET  importe_haber_anual=(SELECT SUM(importe_haber_mensual) FROM haber_jub_mensual
		  WHERE legajo_id=?
		  AND a.anio=anio
		  GROUP BY legajo_id,anio)
		  WHERE legajo_id=?
		  ';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_id, PDO::PARAM_STR);
		$dec->execute();

		$sql = 'UPDATE haber_jubilado
		SET  importe_suma=(SELECT SUM(importe_haber_anual) FROM haber_jub_anual
		WHERE legajo_id=?
		GROUP BY legajo_id),
		importe_haber=(SELECT (SUM(importe_haber_anual)/120)*0.82 FROM haber_jub_anual
		WHERE legajo_id=?
		GROUP BY legajo_id)
		WHERE legajo_id=?
		';

		$dec = $this->cn->prepare($sql);

		$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_id, PDO::PARAM_STR);

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

public function CategoriaGuardarExe($data){
	try{

		list($anioini, $mesini, $diaini)= explode("-", $data->fecha_inicio);
		list($aniofin, $mesfin, $diafin)= explode("-", $data->fecha_fin);

		$datetime1=date_create($data->fecha_inicio);
		$datetime2=date_create($data->fecha_fin);

		$cantmeses=$datetime1->diff($datetime2);

		$meses = ( $cantmeses->y * 12 ) + $cantmeses->m;

		$monto_jub=$data->monto*$data->porcentaje/100;
		$monto_anual=$data->monto;


		for($i=1; $i< $meses; $i++){

		$sql = 'INSERT INTO liquidacion_jub_categoria (legajo_id,
															fecha_inicio,
															fecha_fin,
															importe,
															categoria
															 )
															VALUES(:legajo,
															 :feci,
															:fecf,
															:importe,
															:cat)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
    	$dec->bindValue(':feci', $data->fecha_inicio, PDO::PARAM_STR);
		$dec->bindValue(':fecf', $data->fecha_fin , PDO::PARAM_STR);
		$dec->bindValue(':importe', $data->monto, PDO::PARAM_STR);
		$dec->bindValue(':cat', $data->categoria, PDO::PARAM_STR);

		$dec->execute();

		$sql = 'UPDATE haber_jub_mensual
							 SET  categoria_id= ?,
							 importe_haber_mensual=?,
							 porcentaje_antiguedad=?,
							 importe_antiguedad=?
							 WHERE legajo_id = ?
							 AND mes=?
							 AND anio=?
							 ';

		$dec = $this->cn->prepare($sql);

		$dec->bindValue(1, $data->categoria , PDO::PARAM_STR);
		$dec->bindValue(2, $data->monto, PDO::PARAM_STR);
  		$dec->bindValue(3, $data->porcentaje, PDO::PARAM_STR);
		$dec->bindValue(4, $monto_jub, PDO::PARAM_STR);
		$dec->bindValue(5, $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(6, $mesini, PDO::PARAM_STR);
		$dec->bindValue(7, $anioini, PDO::PARAM_STR);
		$dec->execute();
		if($mesini==12){

			$mesini=1;$anioini++;
			$monto_anual=0;
		}else{$mesini++; $monto_anual=$monto_anual+$monto_jub;}



		}

		$sql='UPDATE haber_jub_anual a
				SET  importe_haber_anual=(SELECT SUM(importe_haber_mensual) FROM haber_jub_mensual
				WHERE legajo_id=?
				AND a.anio=anio
				GROUP BY legajo_id,anio)
				WHERE legajo_id=?
				';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_id, PDO::PARAM_STR);
		$dec->execute();

		$sql = 'UPDATE haber_jubilado
		SET  importe_suma=(SELECT SUM(importe_haber_anual) FROM haber_jub_anual
		WHERE legajo_id=?
		GROUP BY legajo_id),
		importe_haber=(SELECT (SUM(importe_haber_anual)/120)*0.82 FROM haber_jub_anual
		WHERE legajo_id=?
		GROUP BY legajo_id)
		WHERE legajo_id=?
		';

		$dec = $this->cn->prepare($sql);

		$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(2, $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(3, $data->legajo_id, PDO::PARAM_STR);

		$dec->execute();



	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function ConyugeGuardarExe($data){
	try{

		$sql = 'INSERT INTO legajos_conyuge (legajo_id,
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


		$sql = 'INSERT INTO liquidacion_novedades (legajo_id,
		liqcod_id,
		importe_novedad,
		 periodo_id)
		VALUES(:legajo,
		:codtipo,
		:importe,
		:peri
		)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
		$dec->bindValue(':codtipo', 200 , PDO::PARAM_STR);
		$dec->bindValue(':importe', 0, PDO::PARAM_STR);
		$dec->bindValue(':peri', $_SESSION['periodo'] , PDO::PARAM_STR);

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
						cjmdg_personal_nroleg2,
						empresa_id,
						legajo_estado_id,
						legajo_tipo_id
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
					     :nroleg2,
						 1,
						 1,
						 2
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
		$dec->bindValue(':nroleg2', $data->legapoderado_nroleg, PDO::PARAM_STR);

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
		$ultimorev = $this->cn->lastInsertId();

		$sql = 'UPDATE legajos
							 SET  situacion_revista_id=?
							 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $ultimorev, PDO::PARAM_STR);
		$dec->bindValue(2, $ultimoid, PDO::PARAM_STR);
		$dec->execute();


		list($aniojub, $mesjub, $diajub)= explode("-", $data->legapoderado_fecing);

		if($mesjub==1){$fec= date("Y-m-d",strtotime($data->legapoderado_fecing."- 10 year 1 month"));}else{$fec= date("Y-m-d",strtotime($data->legapoderado_fecing."- 10 year"));}

		list($anio, $mes, $dia)= explode("-", $fec);
		$anio2=$anio; if($mesjub!=1){$cantidad=12;}else{$cantidad=11;}

		$sql = 'INSERT INTO situaciones_revista (legajo_id,
								 situacion_revista_fecingreso,
								 situacion_revista_fecantiguedad,
								 situacion_revista_descripcion,
							     situacion_revista_activo)
								 VALUES(:legajo,
										:fecha,
										:fecha1,
										"JUBILADO",
										1)';
		$dec = $this->cn->prepare($sql);

		$dec->bindValue(':legajo', $ultimoid, PDO::PARAM_STR);
		$dec->bindValue(':fecha', $data->legapoderado_fecing, PDO::PARAM_STR);
		$dec->bindValue(':fecha1', $fec, PDO::PARAM_STR);
		$dec->execute();
		$ultimoidsit = $this->cn->lastInsertId();

		$sql ='UPDATE legajos
						 SET empresa_id = 2,
						 situacion_revista_id=?
						 WHERE legajo_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $ultimoidsit, PDO::PARAM_STR);
		$dec->bindValue(2, $ultimoid, PDO::PARAM_STR);
		$dec->execute();


		for($i=1; $i< $cantidad; $i++){

			$sql = 'INSERT INTO haber_jub_anual(importe_haber_anual,anio,legajo_id)
			VALUES(:monto,
							:anioo,
							:legajo)';

		//$sql = 'INSERT INTO haber_jub_anual (importe_haber_anual,anio,legajo_id)
		//				(SELECT SUM(importe_haber_mensual) importe,anio,legajo_id
		//				FROM haber_jub_mensual
		//				WHERE legajo_id=?
		//				GROUP BY anio)';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':monto', 0, PDO::PARAM_STR);
		$dec->bindValue(':anioo', $anio2, PDO::PARAM_STR);
		$dec->bindValue(':legajo', $ultimoid, PDO::PARAM_STR);

		$dec->execute();
		$anio2++;
		}
		//$j=$mes;
		for($i=1; $i< 121; $i++){

				$sql = 'INSERT INTO haber_jub_mensual (legajo_id,anio,mes,importe_haber_mensual)
																		VALUES(:legajo,
																						:anioo,
																						:mes,
																						0)';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':legajo', $ultimoid, PDO::PARAM_STR);
				$dec->bindValue(':anioo', $anio, PDO::PARAM_STR);
				$dec->bindValue(':mes', $mes, PDO::PARAM_STR);

				$dec->execute();
				if($mes==12){$anio++;$mes=1;}else{$mes++;}

		}


		$sql = 'SELECT periodo_id FROM periodos
				WHERE periodo_cerrado=0
				AND periodo_activo=1';

				$dec1 = $this->cn->prepare($sql);

				$dec1->execute();

				$pe= $dec1->fetch(PDO::FETCH_OBJ);



		$sql = 'INSERT INTO haber_jubilado(importe_suma,
				legajo_id,
				periodo_id)
				VALUES(0,
				:legajo,
				:perio)';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue(':legajo', $ultimoid, PDO::PARAM_STR);
		$dec->bindValue(':perio', $_SESSION['periodo'] , PDO::PARAM_STR);

		$dec->execute();


		return $ultimoid;


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

		$sql = 'UPDATE legajos_conyuge
							 SET  conyuge_estado_id=0
							 WHERE conyuge_id = ?';

		$dec = $this->cn->prepare($sql);
		$dec->bindValue(1, $data->legapoderado_id, PDO::PARAM_STR);
		$dec->execute();


		$sql = 'DELETE FROM liquidacion_novedades WHERE liqcod_id = ? AND periodo_id = ? AND legajo_id=?
		';
		$dec = $this->cn->prepare($sql);
		$dec->bindValue('1', 200, PDO::PARAM_STR);
		$dec->bindValue('2', $_SESSION['periodo'], PDO::PARAM_STR);
		$dec->bindValue('3', $data->legjubilado_id, PDO::PARAM_STR);

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
