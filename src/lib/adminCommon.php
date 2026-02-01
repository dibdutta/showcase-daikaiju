<?php
	$smarty = new SmartyBC;

	$smarty->setCompileCheck(COMPILE_CHECK);
	$smarty->debugging = DEBUGGING;
	$smarty->setCaching(CACHING ? Smarty::CACHING_LIFETIME_CURRENT : Smarty::CACHING_OFF);

	$smarty->setTemplateDir(INCLUDE_PATH.'admin_templates/');
	$smarty->setCompileDir(INCLUDE_PATH.'admin_templates_c/'); 
	
	$smarty->assign('actualPath', PAGE_LINK);
	$smarty->assign('adminActualPath', ADMIN_PAGE_LINK);
	$smarty->assign('adminImagePath', ADMIN_IMAGE_LINK);
	$smarty->assign('actualImagePath', IMAGE_LINK);
	
	$smarty->assign('pageTitle', ADMIN_PAGE_TITLE);
	$smarty->assign('pageHeaderName', PAGE_HEADER_TEXT);
	
	//$smarty->assign('imageWidth', IMAGE_WIDTH);
	//$smarty->assign('imageHeight', IMAGE_HEIGHT);
	$smarty->assign('selfPage', $_SERVER['PHP_SELF']);
		
	$smarty->assign('adminLastLoginDate', !empty($_SESSION['adminLastLoginDate']) ? date("dS M, Y h:i:s:A", strtotime($_SESSION['adminLastLoginDate'])) : '');
	$smarty->assign('adminCurrentDate', date("dS M, Y h:i:s:A"));

	if(empty($_SESSION['adminErr']) && !empty($_REQUEST['msg'])){
		$_SESSION['adminErr'] = $_REQUEST['msg'];
	}
	$smarty->assign('errorMessage', $_SESSION['adminErr'] ?? '');
	$_SESSION['adminErr'] = "";

	if(basename($_SERVER['PHP_SELF'])!="admin_main.php" && basename($_SERVER['PHP_SELF'])!="admin_login.php" && ($_SESSION['superAdmin'] ?? 0)!=1 && MULTIUSER_ADMIN == true){
		if(!in_array(basename($_SERVER['PHP_SELF']), $_SESSION['accessPages'] ?? [])){
			$_SESSION['adminErr'] = "You don't have the access of this page.";
			redirect_admin("admin_main.php");
		}
	}
	
	$commonCatsObj = new Category();
	$commonCatTypes = $commonCatsObj->selectData(TBL_CATEGORY_TYPE);
	$smarty->assign('commonCatTypes', $commonCatTypes);
	
	
	/********* Count Unread Messages *********/
	
	if(isset($_SESSION['adminLoginID'])){
		$menuMessageObj = new Message();
		
		if(($_REQUEST['mode'] ?? '') == 'read' && ($_REQUEST['from'] ?? '') != 'sent'){
			$menuMessageObj->updateData(TBL_MESSAGE, array('message_is_new' => 0), array('message_id' => $_REQUEST['message_id'] ?? ''), true);
		}		
		$messageWhere = array('message_to' => $_SESSION['adminLoginID'], 'message_is_new' => '1', 'message_is_toadmin' => '1','message_is_fromadmin' => '0',"message_is_deleted_to" => 0);
		$countMsg = $menuMessageObj->countData(TBL_MESSAGE, $messageWhere);
		//if($countMsg < 1) $countMsg = 0; else $countMsg = $countMsg-1;
		$smarty->assign('countMsg', $countMsg);
		$smarty->assign('adminTracker', $_SESSION['adminLoginID']);
	}
	
?>