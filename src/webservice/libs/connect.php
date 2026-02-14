<?php
	define ("DB_SERVER", getenv('DB_SERVER') ?: "mysql");
	define ("DB_NAME", getenv('DB_NAME') ?: "mpe");
	define ("DB_USER", getenv('DB_USER') ?: "root");
	define ("DB_PASSWORD", getenv('DB_PASSWORD') ?: "root");
	
	$connect=mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
	$link=mysql_select_db(DB_NAME, $connect) or die("Cannot find database!");
?>
