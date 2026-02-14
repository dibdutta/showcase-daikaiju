<?php

//////////////   common variables  //////////////////////

define ("HOST_NAME", $_SERVER['HTTP_HOST']);
//echo $_SERVER['HTTP_HOST'];
//define ("LOCAL_HOST_NAME", "localhost:100");

define ("MULTIUSER_ADMIN", false);

define ("FIXED_PAGE_CREATION", true);
define ("CUSTOM_PAGE_CREATION", false);

define ("SUPER_ADMIN_CREATION", false);

// Application environment: 'production' or 'local'
define("APP_ENV", getenv('APP_ENV') ?: 'local');

////////////////////////////////////////////////////////


//////////////   Database connection variables   ///////////////////////////////


	define ("DB_SERVER", getenv('DB_SERVER') ?: "mysql");
	define ("DB_NAME", getenv('DB_NAME') ?: "mpe");
	define ("DB_USER", getenv('DB_USER') ?: "root");
	define ("DB_PASSWORD", getenv('DB_PASSWORD') ?: "root");
	


////////////////////////////////////////////


?>
