<?php

	session_start();
	session_destroy();
	header("location: ../modulos/login/?c=login&a=Index");

?>
