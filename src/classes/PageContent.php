<?php

class PageContent{

	var $pageID;
	var $pageName;
	
	var $pageContentID;
	var $pageTitle;
	var $pageHeaderName;
	var $pageContent;
	var $metaKeywords;
	var $metaDescription;
	var $metaTags;
	var $customPage;
	
	var $contentSSL;
	var $pageSSL;
	
	var $pageType;
		
	var $status;
	var $postIP;
	
	function __construct(){
		$this->postIP = $_SERVER['REMOTE_ADDR'];
		$this->status = 0;
		
		$this->offset = $GLOBALS['offset'];
		$this->toShow = $GLOBALS['toshow'];
		$this->orderType = $GLOBALS['order_type'];
		$this->orderBy = $GLOBALS['order_by'];
	}
	
	function totalCustomPages(){
		$sql = "SELECT COUNT(pct.".PAGE_CONTENT_ID.") AS counter 
				FROM ".PAGE_CONTENT_TABLE." AS pct 
				LEFT JOIN ".PAGE_TABLE." AS pt ON pt.".PAGE_ID." = pct.".PAGE_ID." 
				WHERE pt.".CUSTOM_PAGE." = '1'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($res);
		if($row['counter']>0){
			return $row['counter'];
		}
		else{
			return 0;
		}
	}
	
	
	function totalFixedPages(){
		$sql = "SELECT COUNT(pt.".PAGE_ID.") AS counter 
				FROM ".PAGE_TABLE." AS pt 
				WHERE 1 AND pt.".CUSTOM_PAGE." != '1' ";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($res);
		if($row['counter']>0){
			return $row['counter'];
		}
		else{
			return 0;
		}
	}
	
	
	function totalFixedPageContent(){
		$sql = "SELECT COUNT(pct.".PAGE_CONTENT_ID.") AS counter 
				FROM ".PAGE_CONTENT_TABLE." AS pct 
				WHERE pct.".PAGE_ID." = '".$this->pageID."'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($res);
		if($row['counter']>0){
			return $row['counter'];
		}
		else{
			return 0;
		}
	}
	
	
	function checkPageContent(){
		if($this->pageID == ""){
			$this->pageID = $this->fetchPageID();
		}
		
		$sql = "SELECT COUNT(".PAGE_CONTENT_ID.") AS counter 
				FROM ".PAGE_CONTENT_TABLE." 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($this->pageContentID != ""){
			$sql .= " AND ".PAGE_CONTENT_ID." != '".$this->pageContentID."'";
		}
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter']>0){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	
	function fetchPageID(){
		$sql = "SELECT ".PAGE_ID." 
				FROM ".PAGE_CONTENT_TABLE." 
				WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			return $row[PAGE_ID];
		}
		else{
			return false;
		}
	}
	
	
	function fetchPageContentID(){
		$sql = "SELECT pct.".PAGE_CONTENT_ID." 
				FROM ".PAGE_CONTENT_TABLE." AS pct 
				WHERE pct.".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			return $row[PAGE_CONTENT_ID];
		}
		else{
			return 0;
		}
	}
	
	function fetchFixedPageContents(){
		$sql = "SELECT pct.*, pt.".PAGE_NAME." 
				FROM ".PAGE_CONTENT_TABLE." AS pct 
				LEFT JOIN ".PAGE_TABLE." AS pt ON pt.".PAGE_ID." = pct.".PAGE_ID." 
				WHERE 1 
				AND pt.".PAGE_ID." = '".$this->pageID."' 
				ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_array($res)){
				$result[] = $row;
			}
			return $result;
		}
		else{
			return false;
		}
	}
	
	
	function fetchCustomPages(){
		$sql = "SELECT pct.* FROM ".PAGE_CONTENT_TABLE." AS pct 
				LEFT JOIN ".PAGE_TABLE." AS pt ON pt.".PAGE_ID." = pct.".PAGE_ID." 
				WHERE 1 
				AND pt.".CUSTOM_PAGE." = '1' 
				ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_array($res)){
				$result[] = $row;
			}
			return $result;
		}
		else{
			return false;
		}
	}
	
	
	function fetchFixedPages(){
		$sql = "SELECT pt.*,pct.".PAGE_CONTENT_ID." FROM ".PAGE_CONTENT_TABLE." AS pct 
				RIGHT JOIN ".PAGE_TABLE." AS pt ON pt.".PAGE_ID." = pct.".PAGE_ID." 
				WHERE 1 
				AND pt.".CUSTOM_PAGE." = '0' 
				ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_array($res)){
				$result[] = $row;
			}
			return $result;
		}
		else{
			return false;
		}
	}
	
	
	function changeFixedPageStatus(){
		$sqlChk = " SELECT ".STATUS." 
					FROM ".PAGE_TABLE." 
					WHERE ".PAGE_ID." = '".$this->pageID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		if($rowChk[STATUS] == 1){
			return $this->setInactiveFixedPage();
		}
		else{
			return $this->setActiveFixedPage();
		}
	}
	
	
	
	function changeCustomPageStatus(){
		$sqlChk = " SELECT ".STATUS." 
					FROM ".PAGE_CONTENT_TABLE." 
					WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		if($rowChk[STATUS] == 1){
			return $this->setInactiveCustomPage();
		}
		else{
			return $this->setActiveCustomPage();
		}
	}
	
	
	function changeFixedPageSSLStatus(){
		$sqlChk = " SELECT ".PAGE_SSL_PERMISSION." 
					FROM ".PAGE_TABLE." 
					WHERE ".PAGE_ID." = '".$this->pageID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		if($rowChk[PAGE_SSL_PERMISSION] == 1){
			return $this->setInactiveSSLFixedPage();
		}
		else{
			return $this->setActiveSSLFixedPage();
		}
	}
	
	
	
	function changeCustomPageSSLStatus(){
		$sqlChk = " SELECT ".PAGE_CONTENT_SSL_PERMISSION." 
					FROM ".PAGE_CONTENT_TABLE." 
					WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		if($rowChk[PAGE_CONTENT_SSL_PERMISSION] == 1){
			return $this->setInactiveSSLCustomPage();
		}
		else{
			return $this->setActiveSSLCustomPage();
		}
	}
	
	
	function setActiveFixedPage(){
		$this->status = 1;
		$sql = "UPDATE ".PAGE_TABLE." SET 
				".STATUS." = '".$this->status."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}
	}
	
	
	function setInactiveFixedPage(){
		$this->status = 0;
		$sql = "UPDATE ".PAGE_TABLE." SET 
				".STATUS." = '".$this->status."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}
	}
	
	
	function setActiveCustomPage(){
		$this->status = 1;
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".STATUS." = '".$this->status."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}
	}
	
	
	function setInactiveCustomPage(){
		$this->status = 0;
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".STATUS." = '".$this->status."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}
	}
	
	
	function setActiveSSLFixedPage(){
		$this->pageSSL = 1;
		$sql = "UPDATE ".PAGE_TABLE." SET 
				".PAGE_SSL_PERMISSION." = '".$this->pageSSL."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->pageSSL;
		}
		else{
			return $this->pageSSL;
		}
	}
	
	
	function setInactiveSSLFixedPage(){
		$this->pageSSL = 0;
		$sql = "UPDATE ".PAGE_TABLE." SET 
				".PAGE_SSL_PERMISSION." = '".$this->pageSSL."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->pageSSL;
		}
		else{
			return $this->pageSSL;
		}
	}
	
	
	function setActiveSSLCustomPage(){
		$this->contentSSL = 1;
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".PAGE_CONTENT_SSL_PERMISSION." = '".$this->contentSSL."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->contentSSL;
		}
		else{
			return $this->contentSSL;
		}
	}
	
	
	function setInactiveSSLCustomPage(){
		$this->contentSSL = 0;
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".PAGE_CONTENT_SSL_PERMISSION." = '".$this->contentSSL."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->contentSSL;
		}
		else{
			return $this->contentSSL;
		}
	}
	
	
	function checkPage(){
		$sql = "SELECT COUNT(".PAGE_ID.") AS counter 
				FROM ".PAGE_TABLE." 
				WHERE ".PAGE_NAME."='".$this->pageName."'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($res);
		if($row['counter']>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function checkCustomPage(){
		$sql = "SELECT COUNT(".PAGE_ID.") AS counter 
				FROM ".PAGE_TABLE." 
				WHERE ".CUSTOM_PAGE."='1'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($res);
		if($row['counter']>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function createPage(){
		$sql = "INSERT INTO ".PAGE_TABLE." SET 
				".PAGE_NAME." = '".$this->pageName."', 
				".CUSTOM_PAGE." = '".$this->customPage."', 
				".POST_DATE."=now(), 
				".UPDATE_DATE." = now(), 
				".STATUS."='1', 
				".POST_IP."='".$this->postIP."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$this->pageID;
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function addCustomPage(){
		$sqlChk = " SELECT ".PAGE_ID." 
					FROM ".PAGE_TABLE." 
					WHERE ".CUSTOM_PAGE." = '1'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		$this->pageID = $rowChk[PAGE_ID];
		return $this->createContent();
	}


	function createContent(){
		$sql = "INSERT INTO ".PAGE_CONTENT_TABLE." SET 
				".PAGE_ID." = '".$this->pageID."', 
				".PAGE_HEADER_NAME." = '".$this->pageHeaderName."', 
				".PAGE_TITLE." = '".$this->pageTitle."', 
				".PAGE_CONTENT." = '".$this->pageContent."', 
				".META_KEYWORDS." = '".$this->metaKeywords."', 
				".META_DESCRIPTION." = '".$this->metaDescription."', 
				".META_TAGS." = '".$this->metaTags."', 
				".POST_DATE."=now(), 
				".UPDATE_DATE." = now(), 
				".STATUS."='1', 
				".POST_IP."='".$this->postIP."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$this->pageContentID = mysqli_insert_id($GLOBALS['db_connect']);
			return true;
		}
		else{
			return false;
		}
	}
	
	function pageContentDetails(){
		$sql = "SELECT pct.*, pt.".PAGE_SSL_PERMISSION." 
				FROM ".PAGE_TABLE." AS pt 
				LEFT JOIN ".PAGE_CONTENT_TABLE." AS pct ON pct.".PAGE_ID." = pt.".PAGE_ID." 
				WHERE pt.".PAGE_NAME." = '".$this->pageName."'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		if($row = mysqli_fetch_array($res)){
			return $row;
		}
		else{
			return "";
		}
	}
	
	
	function pageCustomContentDetails(){
		$sql = "SELECT pct.* 
				FROM ".PAGE_CONTENT_TABLE." AS pct 
				WHERE pct.".PAGE_CONTENT_ID." = '".$this->pageContentID."'";

		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		if($row = mysqli_fetch_array($res)){
			return $row;
		}
		else{
			return "";
		}
	}
	
	function pageDetails(){
		$sql = "SELECT pct.*, pt.".PAGE_NAME." 
				FROM ".PAGE_CONTENT_TABLE." AS pct 
				LEFT JOIN ".PAGE_TABLE." AS pt ON pt.".PAGE_ID." = pct.".PAGE_ID." 
				WHERE 1 ";
		if($this->pageContentID!=""){
			$sql .=" AND pct.".PAGE_CONTENT_ID."='".$this->pageContentID."'";
		}
		if($this->pageID!=""){
			$sql .=" AND pt.".PAGE_ID."='".$this->pageID."'";
		}
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		if($row = mysqli_fetch_array($res)){
			return $row;
		}
		else{
			return false;
		}
	}
	
	
	function fixedPageDetails(){
		$sql = "SELECT * 
				FROM ".PAGE_TABLE." 
				WHERE ".PAGE_ID."='".$this->pageID."'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		if($row = mysqli_fetch_array($res)){
			return $row;
		}
		else{
			return false;
		}
	}
	
	function editPageContent(){
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET  
				".PAGE_HEADER_NAME."='".addslashes($this->pageHeaderName)."', 
				".PAGE_CONTENT."='".addslashes($this->pageContent)."', 
				".UPDATE_DATE."=now(), 
				".POST_IP."='".$this->postIP."' 
				WHERE ".PAGE_CONTENT_ID."='".$this->pageContentID."'";

		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function addPageContent(){
		$sql = "INSERT INTO ".PAGE_CONTENT_TABLE." SET 
				".PAGE_ID."='".$this->pageID."', 
				".PAGE_HEADER_NAME."='".addslashes($this->pageHeaderName)."', 
				".PAGE_CONTENT."='".addslashes($this->pageContent)."', 
				".POST_DATE." = now(), 
				".STATUS." = '".$this->status."', 
				".UPDATE_DATE."=now(), 
				".POST_IP."='".$this->postIP."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function addMetaContent(){
		$sql = "INSERT INTO ".PAGE_CONTENT_TABLE." SET 
				".PAGE_ID."='".$this->pageID."', 
				".PAGE_HEADER_NAME."='".$this->pageHeaderName."', 
				".PAGE_TITLE."='".$this->pageTitle."', 
				".META_KEYWORDS."='".$this->metaKeywords."', 
				".META_DESCRIPTION."='".$this->metaDescription."', 
				".META_TAGS."='".$this->metaTags."', 
				".POST_DATE." = now(), 
				".STATUS." = '".$this->status."', 
				".UPDATE_DATE."=now(), 
				".POST_IP."='".$this->postIP."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function editMetaContent(){
			$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
					".PAGE_HEADER_NAME."='".$this->pageHeaderName."', 
					".PAGE_TITLE."='".$this->pageTitle."', 
					".META_KEYWORDS."='".$this->metaKeywords."', 
					".META_DESCRIPTION."='".$this->metaDescription."', 
					".META_TAGS."='".$this->metaTags."', 
					".UPDATE_DATE."=now(), 
					".POST_IP."='".$this->postIP."' 
					WHERE ".PAGE_ID."='".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
		
	function deleteFixedPage(){
		$sqlDelContent = "DELECT FROM ".PAGE_CONTENT_TABLE." 
							WHERE ".PAGE_ID." = '".$this->pageID."'";
		$resDelContent = mysqli_query($GLOBALS['db_connect'],$sqlDelContent);
		
		$sql = "DELETE FROM ".PAGE_TABLE." 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function deleteCustomPage(){
		$sql = "DELETE FROM ".PAGE_CONTENT_TABLE." 
				WHERE ".PAGE_CONTENT_ID."='".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function deleteCustomPageContent(){
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".PAGE_CONTENT." = '', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function deleteFixedPageContent(){
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".PAGE_CONTENT." = '', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function deleteCustomPageMeta(){
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".PAGE_TITLE."='', 
				".META_KEYWORDS."='', 
				".META_DESCRIPTION."='', 
				".META_TAGS."='', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function deleteFixedPageMeta(){
		$sql = "UPDATE ".PAGE_CONTENT_TABLE." SET 
				".PAGE_TITLE."='', 
				".META_KEYWORDS."='', 
				".META_DESCRIPTION."='', 
				".META_TAGS."='', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."' 
				WHERE ".PAGE_ID." = '".$this->pageID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function deleteFixedAndCustomPage(){
		$flag = 1;
		$sqlChk = "SELECT ".PAGE_ID." 
					FROM ".PAGE_CONTENT_TABLE." 
					WHERE ".PAGE_CONTENT_ID." = '".$this->pageContentID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		while($rowChk = mysqli_fetch_array($resChk)){
			$this->pageID = $rowChk[PAGE_ID];
			$chk = $this->deleteFixedPage();
			if($chk == false){
				$flag = 0;
			}
		}
		if($flag == 1){
			return true;
		}
		else{
			return false;
		}
	}
}
?>