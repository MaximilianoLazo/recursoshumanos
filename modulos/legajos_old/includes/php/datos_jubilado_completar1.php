<?php
			//llenar datos usuario
		//$usuid = $_POST['val'];
		$usuid='1963613';
		$data = array();

		$usu_datos = $this->model->JubiladoObtener($usuid);

					$data["cbotipodocumento"] = $usu_datos->doc_tipo_id;
					$data["txtapellido"] = $usu_datos->cjmdg_personal_apellido;
					$data["txtnombres"] = $usu_datos->cjmdg_personal_nombre;
					$data["txtfnac"] = $usu_datos->cjmdg_personal_fecnac;
					$data["cbosexo"] = $usu_datos->sexo_id;
					//$data["cbocivil"] = $usu_datos->;
					//$data["txtcelular"] = $usu_datos->;
					$data["cboobrasocial"] = $usu_datos->cjmdg_personal_os;

			echo json_encode($data);
			//llenar historial ticket
?>
