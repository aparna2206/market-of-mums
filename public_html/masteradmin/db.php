<?php
	//error_reporting(0);
	$con = new mysqli("localhost", "root", "", "mums");
	if ($con->connect_errno) 
	{
		printf("Connect failed: %s\n", $con->connect_error);
		exit();
	}
?>