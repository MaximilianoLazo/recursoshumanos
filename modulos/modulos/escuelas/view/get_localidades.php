<?php
		require_once '../../../database/Conexion.php';
		require_once '../model/escuela.php';
		$ppdl = $_GET['departamento'];
		$localidades = new Escuela();
		$localidad = null;

		if(is_numeric($ppdl)){
			$departamento = $ppdl;
		}else{
			$ppdl = explode("-", $ppdl);
			$departamento = $ppdl[2];
			$localidad = $ppdl[3];
		}
			echo "<option value=''>-- SELECCIONE --</option>";
		foreach($localidades->ObtenerLocalidades($departamento) as $row){
		?>
			<option value="<?php echo $row->localidad_id; ?>"<?php if (!(strcmp($row->localidad_id, $localidad))) {echo "selected=\"selected\"";} ?>><?php echo $row->localidad_nombre; ?></option>
		<?php
		}
?>
