<?php

	require_once INCLUDE_PATH."lib/configures.php";
	require_once INCLUDE_PATH."libs/SmartyBC.class.php";
	require_once INCLUDE_PATH."lib/function.php";
	//$smarty = new Smarty;

	//$smarty->caching = 1;
	spl_autoload_register(function ($class) {
		// Only load classes from the classes directory if the file exists
		// This prevents conflicts with Smarty's internal autoloader
		$classFile = INCLUDE_PATH."classes/$class.php";
		if (file_exists($classFile)) {
			require_once $classFile;
		}
	});
?>