<?php

	require_once INCLUDE_PATH."lib/configures.php";
	require_once INCLUDE_PATH."libs/SmartyBC.class.php";
	require_once INCLUDE_PATH."lib/function.php";
	//$smarty = new Smarty;

	//$smarty->caching = 1;
	spl_autoload_register(function ($class) {
		require_once INCLUDE_PATH."classes/$class.php";
	});
?>