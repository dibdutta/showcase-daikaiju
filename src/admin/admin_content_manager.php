<?php

/**************************************************/
define ("PAGE_HEADER_TEXT", "Content Management Section");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST["order_by"]!="") {
	$GLOBALS["order_by"] = $_REQUEST["order_by"];
}
else {
	if($_REQUEST['type'] == "custom"){
		$GLOBALS["order_by"] = "pct.".PAGE_HEADER_NAME;
	}
	else{
		$GLOBALS["order_by"] = "pt.".PAGE_NAME;
	}
}


if($_REQUEST['mode']=="edit_content"){
	edit_content();
}
elseif($_REQUEST['mode']=="save_content"){
	if($_POST['type'] == "fixed"){
		$chk = chkContent();
		if($chk == true){
			save_content();
		}
		else{
			edit_content();
		}
	}
	else{
		save_content();
	}
}
elseif($_REQUEST['mode']=="add_content"){
	add_content();
}
elseif($_REQUEST['mode']=="save_add_content"){
	if($_POST['type'] == "fixed"){
		$chk = chkContent();
		if($chk == true){
			save_add_content();
		}
		else{
			add_content();
		}
	}
	else{
		save_add_content();
	}
}
elseif($_REQUEST['mode']=="open_content"){
	open_content();
}
elseif($_REQUEST['mode']=="delete_content"){
	delete_content();
}
elseif($_REQUEST['mode']=="delete_page"){
	delete_page();
}
elseif($_REQUEST['mode']=="create_page"){
	if(FIXED_PAGE_CREATION == true){
		create_page();
	}
	else{
		$_SESSION['adminErr'] = "Sorry! You don't have the access.";
		redirect_admin("admin_content_manager.php");
	}	
}
elseif($_REQUEST['mode']=="saveNewPage"){
	if(FIXED_PAGE_CREATION == true){
		$chk=chkPage();
		if($chk==true){
			createPage();
		}
		else{
			create_page();
		}
	}
	else{
		$_SESSION['adminErr'] = "Sorry! You don't have the access.";
		redirect_admin("admin_content_manager.php");
	}
}
elseif($_REQUEST['mode']=="create_custom_page"){
	if(CUSTOM_PAGE_CREATION == true){
		create_custom_page();
	}
	else{
		$_SESSION['adminErr'] = "Sorry! You don't have the access.";
		redirect_admin("admin_content_manager.php");
	}	
}
elseif($_REQUEST['mode']=="save_custom_page"){
	if(CUSTOM_PAGE_CREATION == true){
		$chk=chkCustomPage();
		if($chk==true){
			save_custom_page();
		}
		else{
			create_custom_page();
		}
	}
	else{
		$_SESSION['adminErr'] = "Sorry! You don't have the access.";
		redirect_admin("admin_content_manager.php");
	}	
}
else{
	dispmiddle();
}

ob_end_flush();
/*************************************************/




/*********************	START of dispmiddle Function	*********/
function dispmiddle() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$smarty->assign ("type", $_REQUEST['type']);
	
	$obj = new PageContent();

	$obj->customPage = $_REQUEST['type']=="custom" ? 1 : 0;
	$total = $_REQUEST['type']=="custom" ? $obj->totalCustomPages() : $obj->totalFixedPages();
		
	if($total>0){
		if($_REQUEST['type']=="custom"){
			$smarty->assign('pageNameTXT', orderBy("Page Header Name", "pct.".PAGE_HEADER_NAME, 1, "toplink"));
			$smarty->assign('statusTXT', orderBy("Status", "pct.".STATUS, 1, "toplink"));
		}
		else{
			$smarty->assign('pageNameTXT', orderBy("Page Name", "pt.".PAGE_NAME, 1, "toplink"));
			$smarty->assign('statusTXT', orderBy("Status", "pt.".STATUS, 1, "toplink"));
		}
		/*if($_REQUEST['type'] == "fixed"){
			$smarty->assign('permissionTXT', orderBy("Permission", "pt.".PAGE_PERMISSION, 1, "toplink"));
			$smarty->assign('sslTXT', orderBy("SSL", "pt.".PAGE_SSL_PERMISSION, 1, "toplink"));
		}
		else{
			$smarty->assign('permissionTXT', orderBy("Permission", "pct.".PAGE_CONTENT_PERMISSION, 1, "toplink"));
			$smarty->assign('sslTXT', orderBy("SSL", "pct.".PAGE_CONTENT_SSL_PERMISSION, 1, "toplink"));
		}*/
		
		
		$smarty->assign('startIndex', $GLOBALS['offset']+1);
		
		$row = $_REQUEST['type']=="custom" ? $obj->fetchCustomPages() : $obj->fetchFixedPages();		
		
		for($n=0; $n<count($row); $n++){
			$pageName[] = $_REQUEST['type']=="custom" ? $row[$n][PAGE_HEADER_NAME] : $row[$n][PAGE_NAME];

			$pageID[] = $row[$n][PAGE_CONTENT_ID] =='' ? $row[$n][PAGE_ID] : $row[$n][PAGE_CONTENT_ID];

			/*$ptext = $_REQUEST['type']=="custom" ? $row[$n][PAGE_CONTENT_PERMISSION] : $row[$n][PAGE_PERMISSION];
			$permission[] = $ptext!="" ? ucfirst($ptext) : "Not Set";*/

			if($row[$n][STATUS] == 1){
				$pageStatus[] = "Active";
			}
			else{
				$pageStatus[] = "Inactive";
			}
			/*if($_REQUEST['type']=="custom"){
				if($row[$n][PAGE_CONTENT_SSL_PERMISSION] == 1){
					$sslStatus[] = "Active";
				}
				else{
					$sslStatus[] = "Inactive";
				}
			}
			else{
				if($row[$n][PAGE_SSL_PERMISSION] == 1){
					$sslStatus[] = "Active";
				}
				else{
					$sslStatus[] = "Inactive";
				}
			}*/
			
			if($_REQUEST['type'] == "fixed"){
				$obj->pageID = $row[$n][PAGE_ID];
				$content = $obj->totalFixedPageContent();
				$totalContent[] = $content;
				if($content >0){
					$page_content_id = $obj->fetchPageContentID();
					$smarty->assign('page_content_id', $page_content_id);
				}
				$smarty->assign('totalContent', $totalContent);
			}
		}
		$smarty->assign('pageName', $pageName);
		$smarty->assign('pageID', $pageID);
		$smarty->assign('languagePage', $languagePage);
		$smarty->assign('pageStatus', $pageStatus);
		$smarty->assign('permission', $permission);
		$smarty->assign('sslStatus', $sslStatus);

			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->display('admin_content_manager.tpl');
}

/**********	  END of Middle		********************************/

function open_content(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$smarty->assign ("type", $_REQUEST['type']);
	$smarty->assign ("page_id", $_REQUEST['page_id']);
	
	$obj = new PageContent();
	$obj->pageID = $_REQUEST['page_id'];
	$total = $obj->totalFixedPageContent();
	
	if($total<$totalLanguages){
		$smarty->assign ("add_content_display", 1);
	}
		
	if($total>0){
		$smarty->assign('pageNameTXT', orderBy("Page Header Name", "pct.".PAGE_HEADER_NAME, 1, "toplink"));
		$smarty->assign('statusTXT', orderBy("Status", "pct.".STATUS, 1, "toplink"));
		$smarty->assign('permissionTXT', orderBy("Permission", "pct.".PAGE_CONTENT_PERMISSION, 1, "toplink"));
		$smarty->assign('sslTXT', orderBy("SSL", "pct.".PAGE_CONTENT_SSL_PERMISSION, 1, "toplink"));
		
		$smarty->assign('startIndex', $GLOBALS['offset']+1);
		
		$row = $obj->fetchFixedPageContents();		
		
		for($n=0; $n<count($row); $n++){
			$pageName[] = $row[$n][PAGE_HEADER_NAME] !="" ? $row[$n][PAGE_HEADER_NAME] : $row[$n][PAGE_NAME];
			$pageID[] = $row[$n][PAGE_CONTENT_ID];
			$languagePage[] = $row[$n][LANGUAGE_NAME];
			$permission[] = $row[$n][PAGE_CONTENT_PERMISSION]!="" ? ucfirst($row[$n][PAGE_CONTENT_PERMISSION]) : "Not Set";
			
			if($row[$n][STATUS] == 1){
				$pageStatus[] = "Active";
			}
			else{
				$pageStatus[] = "Inactive";
			}
			
			if($row[$n][PAGE_CONTENT_SSL_PERMISSION] == 1){
				$sslStatus[] = "Active";
			}
			else{
				$sslStatus[] = "Inactive";
			}
			
			$totalContent[] = 1;
			$smarty->assign('totalContent', $totalContent);
		}
		$smarty->assign('pageName', $pageName);
		$smarty->assign('pageID', $pageID);
		$smarty->assign('languagePage', $languagePage);
		$smarty->assign('pageStatus', $pageStatus);
		$smarty->assign('permission', $permission);
		$smarty->assign('sslStatus', $sslStatus);
		
			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->display('admin_fixed_content_manager.tpl');
}

/**********	  START of edit_content Function		 ************/

function edit_content() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
		
	$page = new PageContent();
	if(MULTILINGUAL == true){
		$page->pageContentID=$_REQUEST['page_content_id'];
	}
	else{
		$page->pageID=$_REQUEST['page_content_id'];
	}
	$pageDetails = $page->pageDetails();
	
	$smarty->assign('page_header_name', trim($_POST['page_header_name'])!=""?escape($_POST['page_header_name']):$pageDetails[PAGE_HEADER_NAME]);
	$smarty->assign('page_name', $pageDetails[PAGE_NAME]);
	
	ob_start();
	$oFCKeditor = new FCKeditor('page_content') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $pageDetails[PAGE_CONTENT];
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '500';
	$oFCKeditor->Create() ;
	$page_content = ob_get_contents();
	ob_end_clean();
	
	$smarty->assign('page_content', $page_content);
	
	$smarty->assign('page_content_id', $_REQUEST['page_content_id']);
	$smarty->assign('type', $_REQUEST['type']);
		
	$smarty->display('admin_edit_content_manager.tpl');
}
/**********	 END of edit_content Function	 *******************/




/**********	START of save_content Function	 *******************/
function save_content() {
	$page = new PageContent();

	$page->pageContentID=$_POST['page_content_id'];

	$page->pageType = trim($_REQUEST['type']);
	$page->pageHeaderName = stripslashes($_POST['page_header_name']);
	$page->pageContent = stripslashes($_POST['page_content']);
	
	$editContent = $page->editPageContent();
	if($editContent==true){
		$_SESSION['adminErr']="The page content has been changed successfully.";
		//redirect_admin("admin_content_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit();
	}
	else{
		$_SESSION['adminErr']="The page content has not been changed successfully.";
		//redirect_admin("admin_content_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit();
	}
}
/**********	 END of save_content Function	 *******************/



/**********	  START of edit_content Function		 ************/

function add_content() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
		
	$page = new PageContent();
	$page->pageID=$_REQUEST['page_id'];
	$pageDetails = $page->fixedPageDetails();
	
	$smarty->assign('page_header_name', trim($_POST['page_header_name']));
	$smarty->assign('page_name', $pageDetails[PAGE_NAME]);
	
	ob_start();
	$oFCKeditor = new FCKeditor('page_content') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $_POST['page_content'];
	$oFCKeditor->Width  = '100%';
	$oFCKeditor->Height = '500';
	$oFCKeditor->Create() ;
	$page_content = ob_get_contents();
	ob_end_clean();
	
	$smarty->assign('page_content', $page_content);
	
	$smarty->assign('page_id', $_REQUEST['page_id']);
	$smarty->assign('type', $_REQUEST['type']);
		
	$smarty->display('admin_add_content_manager.tpl');
}
/**********	 END of edit_content Function	 *******************/




/**********	START of save_content Function	 *******************/
function save_add_content() {
	$page = new PageContent();
	$page->pageID = $_POST['page_id'];
	$page->pageHeaderName = $_POST['page_header_name'];
	$page->pageContent = $_POST['page_content'];
	$page->status = 1;
	
	$addContent = $page->addPageContent();
	if($addContent == true){
		$_SESSION['adminErr']="The page content has been added successfully.";
		//redirect_admin("admin_content_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit();
	}
	else{
		$_SESSION['adminErr']="The page content has not been added successfully.";
		//redirect_admin("admin_content_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit();
	}
}
/**********	 END of save_content Function	 *******************/

function chkContent(){
	$errCounter=0;
	
	$obj = new PageContent;
	$obj->pageID = $_POST['page_id'];
	$obj->pageContentID = $_POST['page_content_id'];
	$obj->languageID = $_POST['language_id'];
	$chk = $obj->checkPageContent();
	
	if($chk == true){
		$_SESSION['adminErr'] = "Sorry! You can't create more than one content in one language.";
		$errCounter++;
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function delete_content() {
	$obj = new PageContent;

	$obj->pageID = $_REQUEST['page_content_id'];
	$chk = $obj->deleteFixedPageContent();
	
	if($chk == true){
		$_SESSION['adminErr']="One ".$_REQUEST['type']." page content has been deleted successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
	else{
		$_SESSION['adminErr']="One ".$_REQUEST['type']." page content has not been deleted successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
}

function delete_page() {
	$obj = new PageContent;
	/*if($_REQUEST['type'] == "fixed"){
		$obj->pageID = $_REQUEST['page_content_id'];
		$chk = $obj->deleteFixedPage();
	}
	else{*/
		$obj->pageContentID = $_REQUEST['page_content_id'];
		$chk = $obj->deleteCustomPage();
	//}
	
	if($chk == true){
		$_SESSION['adminErr']="One ".$_REQUEST['type']." page has been deleted successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
	else{
		$_SESSION['adminErr']="One ".$_REQUEST['type']." page has not been deleted successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
}

function create_custom_page(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign('type', $_REQUEST['type']);
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, escape($value));
	}
	
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}
	
	$smarty->display("admin_create_custompage_manager.tpl");
}

function chkCustomPage(){
	$errCounter=0;

	if($_REQUEST['page_header']==""){
		$errCounter++;
		$GLOBALS['page_header_err']="Please enter the page header name.";
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function save_custom_page(){
	$obj = new PageContent;
	$obj->languageID = $_POST['language_id'];
	$obj->pageHeaderName = $_POST['page_header'];
	
	$chk = $obj->checkCustomPage();
	if($chk == true){
		$chkCreate = $obj->addCustomPage();
	}
	else{
		createCustomPageFile('pages.php');
		$chkCreate = $obj->addCustomPage();
	}
	
	if($chkCreate == true){
		$_SESSION['adminErr']="One custom page has been created successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
	else{
		$_SESSION['adminErr']="The custom has not been created successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
}

function createCustomPageFile($pageName){
	$pageName = strtolower($pageName);
	$filePath = $pageName;
	
	$tplFileName = substr($pageName, 0, -4);
	$tplFileName = $tplFileName.".tpl";
	$tplFilePath = "templates/".$tplFileName;
	
	$page = new PageContent();
	$page->pageName = $pageName;
	$page->customPage = 1;
	$newPage = $page->createPage();
	
	if($newPage==true){
		$fp = fopen("samplePage.tpl","r");
		$data=fread($fp, filesize("samplePage.tpl"));
		fclose($fp);
		
		$fp_tpl = fopen("sample_tpl.tpl","r");
		$data_tpl=fread($fp_tpl, filesize("sample_tpl.tpl"));
		fclose($fp_tpl);
		
		$data = str_replace('tpl_page_name', $tplFileName, $data);
		
		if(false == file_exists($_SERVER['DOCUMENT_ROOT']."/".$filePath)){
			if($file = fopen($_SERVER['DOCUMENT_ROOT']."/".$filePath, "w")){
				chmod($filePath, 0777);
				fwrite($file, $data);
			}
		}
		
		if(false == file_exists($_SERVER['DOCUMENT_ROOT']."/".$tplFilePath)){
			if($file = fopen($_SERVER['DOCUMENT_ROOT']."/".$tplFilePath, "w")){
				chmod($tplFilePath, 0777);
				fwrite($file, $data_tpl);
			}
		}
		return true;
	}
	else{
		return false;
	}
}

function create_page() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign('type', $_REQUEST['type']);
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, escape($value));
	}
	
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}
	
	$smarty->display("admin_create_page_manager.tpl");
}

function chkPage(){
	$errCounter=0;
	if($_REQUEST['page_name']==""){
		$errCounter++;
		$GLOBALS['page_name_err']="Please enter the file name.";
	}
	else{
		$ext=strtolower(substr($_REQUEST['page_name'], -4));
		if($ext!=".php"){
			$errCounter++;
			$GLOBALS['page_name_err']="File name must be with extension .php";
		}
		
		if(strpos($_REQUEST['page_name'], " ")){
			$errCounter++;
			$GLOBALS['page_name_err']="White space is not allowed.";
		}
		
		$chkPage = new PageContent();
		$chkPage->pageName = $_REQUEST['page_name'];
		$chk = $chkPage->checkPage();
		if($chk==true){
			$errCounter++;
			$GLOBALS['page_name_err']="This file is already exists.";
		}
	}
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function createPage(){
	$pageName = strtolower($_POST['page_name']);
	$filePath = $pageName;
	
	$tplFileName = substr($pageName, 0, -4);
	$tplFileName = $tplFileName.".tpl";
	$tplFilePath = "templates/".$tplFileName;
	
	$page = new PageContent();
	$page->pageName = $_POST['page_name'];
	$page->pageHeaderName = $_POST['page_header_name'];
	$page->customPage = 0;
	$newPage = $page->createPage();
	
	if($newPage==true){
		$fp = fopen("samplePage.tpl","r");
		$data=fread($fp, filesize("samplePage.tpl"));
		fclose($fp);
		
		$fp_tpl = fopen("sample_tpl.tpl","r");
		$data_tpl=fread($fp_tpl, filesize("sample_tpl.tpl"));
		fclose($fp_tpl);
		
		$data = str_replace('tpl_page_name', $tplFileName, $data);
		
		if(false == file_exists($_SERVER['DOCUMENT_ROOT']."/".$filePath)){
			if($file = fopen($_SERVER['DOCUMENT_ROOT']."/".$filePath, "w")){
				@chmod($_SERVER['DOCUMENT_ROOT']."/".$filePath, 0777);
				@fwrite($file, $data);
			}
		}
		
		if(false == file_exists($_SERVER['DOCUMENT_ROOT']."/".$tplFilePath)){
			if($file = fopen($_SERVER['DOCUMENT_ROOT']."/".$tplFilePath, "w")){
				chmod($tplFilePath, 0777);
				fwrite($file, $data_tpl);
			}
		}
		
		$_SESSION['adminErr']="One file has been created successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
	else{
		$_SESSION['adminErr']="One file has not been created successfully.";
		redirect_admin("admin_content_manager.php?type=".$_REQUEST['type']."");
	}
}

function delete_message(){
	$obj = new Message();
	$obj->userID = $_REQUEST['user_id'];
	
	$chk = $obj->deleteData();

	if($chk == true){
		$_SESSION['adminErr'] = "The User has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
	else{
		$_SESSION['adminErr'] = "Can not delete user. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}

}

function delete_all_messages(){

	$flag = 1;
	$obj = new Message();
	foreach($_REQUEST['messages_ids'] as $val){
		$obj->userID = $val;

		/*$image_present = $obj->fetch_image();
		if(file_exists("..".$image_present)){
			unlink("..".$image_present);
		}*/

		$chk = $obj->deleteData();
		if($chk == false){
			$flag = 0;
		}
	}	
	
	if($flag == 1){
		$_SESSION['adminErr']="All User deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}else{
		$_SESSION['adminErr'] .="All User not deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
}

?>