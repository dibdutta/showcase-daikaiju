<?php

/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Meta Content Section");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';

if(($_REQUEST["order_by"] ?? '') != "") {
	$GLOBALS["order_by"] = $_REQUEST["order_by"];
}
else {
	if(($_REQUEST['type'] ?? '') == "custom"){
		$GLOBALS["order_by"] = "pct.".PAGE_HEADER_NAME;
	}
	else{
		$GLOBALS["order_by"] = "pt.".PAGE_NAME;
	}
}

if($mode=="edit_content"){
	edit_content();
}
elseif($mode=="save_content"){
	if(($_POST['type'] ?? '') == "fixed"){
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
elseif($mode=="add_content"){
	add_content();
}
elseif($mode=="save_add_content"){
	if(($_POST['type'] ?? '') == "fixed"){
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
elseif($mode=="open_content"){
	open_content();
}
elseif($mode=="delete_content"){
   delete_content();
}
elseif($mode=="delete_page"){
   delete_page();
}
elseif($mode=="create_page"){
	if(FIXED_PAGE_CREATION == true){
		create_page();
	}
	else{
		$_SESSION['adminErr'] = "Sorry! You don't have the access.";
		redirect_admin("admin_meta_manager.php");
	}
}
elseif($mode=="saveNewPage"){
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
		redirect_admin("admin_meta_manager.php");
	}
}
elseif($mode=="create_custom_page"){
	if(CUSTOM_PAGE_CREATION == true){
		create_custom_page();
	}
	else{
		$_SESSION['adminErr'] = "Sorry! You don't have the access.";
		redirect_admin("admin_meta_manager.php");
	}
}
elseif($mode=="save_custom_page"){
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
		redirect_admin("admin_meta_manager.php");
	}
}
else{
	dispmiddle();
}

ob_end_flush();
/*************************************************/




/*********************   START of dispmiddle Function   *********/
function dispmiddle() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$smarty->assign ("type", $_REQUEST['type'] ?? '');

	$obj = new PageContent();
	if(($_REQUEST['language_id'] ?? '') != ""){
		$obj->languageID = $_REQUEST['language_id'];
	}
	$obj->customPage = ($_REQUEST['type'] ?? '') == "custom" ? 1 : 0;
	$total = ($_REQUEST['type'] ?? '') == "custom" ? $obj->totalCustomPages() : $obj->totalFixedPages();

	if($total>0){
		if(($_REQUEST['type'] ?? '') == "custom"){
			$smarty->assign('pageNameTXT', orderBy("Page Header Name", "pct.".PAGE_HEADER_NAME, 1, "toplink"));
			$smarty->assign('statusTXT', orderBy("Status", "pct.".STATUS, 1, "toplink"));
		}
		else{
			//$smarty->assign('pageNameTXT', orderBy("Page Name", "pt.".PAGE_NAME, 1, "toplink"));
			$smarty->assign('pageNameTXT', "Page Name");
			$smarty->assign('statusTXT', orderBy("Status", "pt.".STATUS, 1, "toplink"));
		}
		if(($_REQUEST['type'] ?? '') == "fixed"){
			$smarty->assign('permissionTXT', orderBy("Permission", "pt.".PAGE_PERMISSION, 1, "toplink"));
		}
		else{
			$smarty->assign('permissionTXT', orderBy("Permission", "pct.".PAGE_CONTENT_PERMISSION, 1, "toplink"));
		}


		$smarty->assign('startIndex', $GLOBALS['offset']+1);

		$row = ($_REQUEST['type'] ?? '') == "custom" ? $obj->fetchCustomPages() : $obj->fetchFixedPages();
		$row = $row ?? [];

		for($n=0; $n<count($row); $n++){
			$pageName[] = ($_REQUEST['type'] ?? '') == "custom" ? $row[$n][PAGE_HEADER_NAME] : $row[$n][PAGE_NAME];
			if(MULTILINGUAL == false){
				$pageID[] = $row[$n][PAGE_ID];
			}
			else{
				$pageID[] = ($_REQUEST['type'] ?? '') == "custom" ? $row[$n][PAGE_CONTENT_ID] : $row[$n][PAGE_ID];
			}
			$ptext = ($_REQUEST['type'] ?? '') == "custom" ? $row[$n][PAGE_CONTENT_PERMISSION] : $row[$n][PAGE_PERMISSION];
			$permission[] = $ptext!="" ? ucfirst($ptext) : "Not Set";
			$languagePage[] = $row[$n][LANGUAGE_NAME];
			if($row[$n][STATUS] == 1){
				$pageStatus[] = "Active";
			}
			else{
				$pageStatus[] = "Inactive";
			}


			if(($_REQUEST['type'] ?? '') == "fixed"){
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


		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));

		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}

	$smarty->assign('total', $total);
	$smarty->display('admin_meta_manager.tpl');
}

/**********     END of Middle      ********************************/



function open_content(){
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$smarty->assign ("type", $_REQUEST['type'] ?? '');
	$smarty->assign ("page_id", $_REQUEST['page_id'] ?? '');

	$obj = new PageContent();
	$obj->pageID = $_REQUEST['page_id'] ?? '';
	$total = $obj->totalFixedPageContent();

	if($total<$totalLanguages){
		$smarty->assign ("add_content_display", 1);
	}

	if($total>0){
		$smarty->assign('pageNameTXT', orderBy("Page Header Name", "pct.".PAGE_HEADER_NAME, 1, "toplink"));
		$smarty->assign('statusTXT', orderBy("Status", "pct.".STATUS, 1, "toplink"));
		$smarty->assign('languageNameTXT', orderBy("Language", "lt.".LANGUAGE_NAME, 1, "toplink"));
		$smarty->assign('permissionTXT', orderBy("Permission", "pct.".PAGE_CONTENT_PERMISSION, 1, "toplink"));

		$smarty->assign('startIndex', $GLOBALS['offset']+1);

		$row = $obj->fetchFixedPageContents();
		$row = $row ?? [];

		for($n=0; $n<count($row); $n++){
			$pageName[] = $row[$n][PAGE_HEADER_NAME];
			$pageID[] = $row[$n][PAGE_CONTENT_ID];
			$languagePage[] = $row[$n][LANGUAGE_NAME];
			$permission[] = $row[$n][PAGE_CONTENT_PERMISSION]!="" ? ucfirst($row[$n][PAGE_CONTENT_PERMISSION]) : "Not Set";

			if($row[$n][STATUS] == 1){
				$pageStatus[] = "Active";
			}
			else{
				$pageStatus[] = "Inactive";
			}
			$totalContent[] = 1;
			$smarty->assign('totalContent', $totalContent);
		}
		$smarty->assign('pageName', $pageName);
		$smarty->assign('pageID', $pageID);
		$smarty->assign('languagePage', $languagePage);
		$smarty->assign('pageStatus', $pageStatus);
		$smarty->assign('permission', $permission);


		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));

		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}

	$smarty->assign('total', $total);
	$smarty->display('admin_fixed_meta_manager.tpl');
}


/**********     START of edit_content Function       ************/

function edit_content() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", $_REQUEST['encoded_string'] ?? '');
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$page = new PageContent();
	if(MULTILINGUAL == true){
		$page->pageContentID=$_REQUEST['page_content_id'] ?? '';
	}
	else{
		$page->pageID=$_REQUEST['page_content_id'] ?? '';
	}
	$pageDetails = $page->pageDetails();

	$smarty->assign('page_header_name', trim($_POST['page_header_name'] ?? '')!=""?escape($_POST['page_header_name']):$pageDetails[PAGE_HEADER_NAME]);
	$smarty->assign('page_title', trim($_POST['page_title'] ?? '')!=""?escape($_POST['page_title']):$pageDetails[PAGE_TITLE]);
	$smarty->assign('keywords', trim($_POST['keywords'] ?? '')!=""?escape($_POST['keywords']):$pageDetails[META_KEYWORDS]);
	$smarty->assign('description', trim($_POST['description'] ?? '')!=""?escape($_POST['description']):$pageDetails[META_DESCRIPTION]);
	$smarty->assign('other_meta', trim($_POST['other_meta'] ?? '')!=""?escape($_POST['other_meta']):$pageDetails[META_TAGS]);

	$smarty->assign('page_name', $pageDetails[PAGE_NAME]);

	$smarty->assign('page_content_id', $_REQUEST['page_content_id'] ?? '');
	$smarty->assign('type', $_REQUEST['type'] ?? '');

	$smarty->display('admin_edit_meta_manager.tpl');
}
/**********    END of edit_content Function    *******************/




/**********   START of save_content Function    *******************/
function save_content() {
	$page = new PageContent();

	$page->pageID=$_POST['page_content_id'] ?? '';
	$page->pageHeaderName = $_POST['page_header_name'] ?? '';
	$page->pageTitle = $_POST['page_title'] ?? '';
	$page->metaKeywords = mysqli_real_escape_string($GLOBALS['db_connect'],$_POST['keywords'] ?? '');
	$page->metaDescription = mysqli_real_escape_string($GLOBALS['db_connect'],$_POST['description'] ?? '');
	$page->metaTags = mysqli_real_escape_string($GLOBALS['db_connect'],$_POST['other_meta'] ?? '');

	$editContent = $page->editMetaContent();
	if($editContent==true){
		$_SESSION['adminErr']="The meta content has been changed successfully.";
		//redirect_admin("admin_meta_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}
	else{
		$_SESSION['adminErr']="The meta content has not been changed successfully.";
		//redirect_admin("admin_meta_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}
}
/**********    END of save_content Function    *******************/



/**********     START of edit_content Function       ************/

function add_content() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", $_REQUEST['encoded_string'] ?? '');
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$page = new PageContent();
	$page->pageID=$_REQUEST['page_id'] ?? '';
	$pageDetails = $page->fixedPageDetails();

	$smarty->assign('page_header_name', trim($_POST['page_header_name'] ?? ''));
	$smarty->assign('page_name', $pageDetails[PAGE_NAME]);

	if(MULTILINGUAL == true){
		$smarty->assign('language_id', trim($_POST['language_id'] ?? '')!=""?escape($_POST['language_id']):$pageDetails[LANGUAGE_ID]);
	}

	$smarty->assign('page_content', $page_content ?? '');

	$smarty->assign('page_id', $_REQUEST['page_id'] ?? '');
	$smarty->assign('type', $_REQUEST['type'] ?? '');

	$smarty->display('admin_add_meta_manager.tpl');
}
/**********    END of edit_content Function    *******************/




/**********   START of save_content Function    *******************/
function save_add_content() {
	$page = new PageContent();
	$page->pageID = $_POST['page_id'] ?? '';
	$page->pageHeaderName = $_POST['page_header_name'] ?? '';
	$page->pageTitle = $_POST['page_title'] ?? '';
	$page->metaKeywords = mysqli_real_escape_string($GLOBALS['db_connect'],$_POST['keywords'] ?? '');
	$page->metaDescription = mysqli_real_escape_string($GLOBALS['db_connect'],$_POST['description'] ?? '');
	$page->metaTags = mysqli_real_escape_string($GLOBALS['db_connect'],$_POST['other_meta'] ?? '');
	$page->languageID = $_POST['language_id'] ?? '';
	$page->status = 1;

	$addContent = $page->addMetaContent();
	if($addContent == true){
		$_SESSION['adminErr']="The meta content has been added successfully.";
		//redirect_admin("admin_meta_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}
	else{
		$_SESSION['adminErr']="The meta content has not been added successfully.";
		//redirect_admin("admin_meta_manager.php?type=".$_POST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}
}
/**********    END of save_content Function    *******************/

function chkContent(){
	$errCounter=0;

	$obj = new PageContent;
	$obj->pageID = $_POST['page_id'] ?? '';
	$obj->pageContentID = $_POST['page_content_id'] ?? '';
	$obj->languageID = $_POST['language_id'] ?? '';
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
	if(MULTILINGUAL == true){
		if(($_REQUEST['type'] ?? '') == "fixed"){
			$obj->pageID = $_REQUEST['page_content_id'] ?? '';
			$chk = $obj->deleteFixedPageMeta();
		}
		else{
			$obj->pageContentID = $_REQUEST['page_content_id'] ?? '';
			$chk = $obj->deleteCustomPageMeta();
		}
	}
	else{
		$obj->pageContentID = $_REQUEST['page_content_id'] ?? '';
		$chk = $obj->deleteCustomPageMeta();
	}

	if($chk == true){
		$_SESSION['adminErr']="One ".($_REQUEST['type'] ?? '')." meta content has been deleted successfully.";
		//redirect_admin("admin_meta_manager.php?type=".$_REQUEST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}
	else{
		$_SESSION['adminErr']="One ".($_REQUEST['type'] ?? '')." meta content has not been deleted successfully.";
		//redirect_admin("admin_meta_manager.php?type=".$_REQUEST['type']."");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}
}

function delete_page() {
	$obj = new PageContent;
	if(($_REQUEST['type'] ?? '') == "fixed"){
		$obj->pageID = $_REQUEST['page_content_id'] ?? '';
		$chk = $obj->deleteFixedPage();
	}
	else{
		$obj->pageContentID = $_REQUEST['page_content_id'] ?? '';
		$chk = $obj->deleteCustomPage();
	}

	if($chk == true){
		$_SESSION['adminErr']="One ".($_REQUEST['type'] ?? '')." page has been deleted successfully.";
		redirect_admin("admin_meta_manager.php?type=".($_REQUEST['type'] ?? '')."");
	}
	else{
		$_SESSION['adminErr']="One ".($_REQUEST['type'] ?? '')." page has not been deleted successfully.";
		redirect_admin("admin_meta_manager.php?type=".($_REQUEST['type'] ?? '')."");
	}
}

function create_custom_page(){
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign('type', $_REQUEST['type'] ?? '');

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, escape($value));
	}

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}

	$smarty->display("admin_create_custompage_manager.tpl");
}

function chkCustomPage(){
	$errCounter=0;
	if(($_REQUEST['language_id'] ?? '') == "" && MULTILINGUAL == true){
		$errCounter++;
		$GLOBALS['language_id_err']="Please select language.";
	}
	if(($_REQUEST['page_header'] ?? '') == ""){
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
	$obj->languageID = $_POST['language_id'] ?? '';
	$obj->pageHeaderName = $_POST['page_header'] ?? '';

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
		redirect_admin("admin_meta_manager.php?type=".($_REQUEST['type'] ?? '')."");
	}
	else{
		$_SESSION['adminErr']="The custom has not been created successfully.";
		redirect_admin("admin_meta_manager.php?type=".($_REQUEST['type'] ?? '')."");
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

	$smarty->assign('type', $_REQUEST['type'] ?? '');

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, escape($value));
	}

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}

	$smarty->display("admin_create_page_manager.tpl");
}

function chkPage(){
	$errCounter=0;
	if(($_REQUEST['page_name'] ?? '') == ""){
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
	$pageName = strtolower($_POST['page_name'] ?? '');
	$filePath = $pageName;

	$tplFileName = substr($pageName, 0, -4);
	$tplFileName = $tplFileName.".tpl";
	$tplFilePath = "templates/".$tplFileName;

	$page = new PageContent();
	$page->pageName = $_POST['page_name'] ?? '';
	$page->pageHeaderName = $_POST['page_header_name'] ?? '';
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
		redirect_admin("admin_meta_manager.php?type=".($_REQUEST['type'] ?? '')."");
	}
	else{
		$_SESSION['adminErr']="One file has not been created successfully.";
		redirect_admin("admin_meta_manager.php?type=".($_REQUEST['type'] ?? '')."");
	}
}

?>
