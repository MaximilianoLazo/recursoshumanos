<?php
		//require_once '../../../../database/Conexion.php';
		//require_once '../../model/empleado.php';
		$ppdl = $_GET['pais'];
		$provincia = null;
		//$provincias = new Empleado();

		if(is_numeric($ppdl)){
			$pais = $ppdl;
		}else{
			$ppdl = explode("-", $ppdl);
			$pais = $ppdl[0];
			$provincia = $ppdl[1];
		}
			echo "<option value=''>--Seleccione--</option>";
		foreach($this->model->ObtenerProvincias($pais) as $row){
		?>
			<option value="<?php echo $row->provincia_id; ?>"<?php if (!(strcmp($row->provincia_id, $provincia))) {echo "selected=\"selected\"";} ?>><?php echo $row->provincia_nombre; ?></option>
		<?php
		}
?>
