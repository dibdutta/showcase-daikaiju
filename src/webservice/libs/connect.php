<?php
	define ("DB_SERVER", "mpedatabse-cluster-1.cluster-cgfyvtkhw6tb.us-west-2.rds.amazonaws.com");
	define ("DB_NAME", "mpe");
	define ("DB_USER", "geotech");
	define ("DB_PASSWORD", "Hello4321");
	
	$connect=mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
	$link=mysql_select_db(DB_NAME, $connect) or die("Cannot find database!");
?>
