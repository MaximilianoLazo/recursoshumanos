<?php

		$relojid = $_REQUEST['term'];

		$data = array();

		foreach($this->model->AutocompletarReloj($relojid) as $row){
				$data[] = array(
						//'label' => $row->reloj_id,
						'value' => $row->reloj_id
		}
		echo json_encode($data);
?>
