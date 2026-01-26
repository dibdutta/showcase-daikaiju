<?php  
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();
if($_REQUEST['mode'] == 'insert_contact'){
	$validation = valid_contactus_form();
	if($validation==true){
		save_contactus();
	}else{
		content();       ////////////   For page content 
		dispmiddle();
	}
}else{
	content();       ////////////   For page content 
	dispmiddle();
}
ob_end_flush();

function dispmiddle(){
	require_once INCLUDE_PATH."lib/common.php";

	$smarty->display("contactus.tpl");
	
}
function save_contactus()
{
	$name = $_REQUEST['firstname'];
	$email = $_REQUEST['email'];
	$enquiry_type = $_REQUEST['category_id'];
	$comments = addslashes($_REQUEST['comments']);
	$sql="Insert into `contact_us` (name,email,enquiry_id,comments) values ('".$name."','".$email."','".$enquiry_type."','".$comments."')";
	
	if(mysqli_query($GLOBALS['db_connect'],$sql))
	{
		$toMail = ADMIN_EMAIL_ADDRESS;
		$toName = ADMIN_NAME;
		$subject = "Contact Us";
		$fromMail = $email;
		$fromName = $name;
		//$textContent = "Thank you for Contacting with us ".$toName."<br/>";
		$textContent = "Name: ".$name."<br />";
		$textContent = "Email: ".$name."<br />";
		/*if($enquiry_type == 1){
			$qtype = "Comedy";
		}elseif($enquiry_type == 2){
			$qtype = "Documentary";
		}elseif($enquiry_type == 3){
			$qtype = "Horror";
		}elseif($enquiry_type == 4){
			$qtype = "Rock & Roll";
		}*/
		
		$textContent = "Name: ".$name."<br />";
		$textContent .= "Email Address: ".$email."<br />";
		/*$textContent .= "Enquiry On: ".$qtype."<br />";*/
		$textContent .= "Comments: ".$comments."<br /><br />";
		
		$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
		$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
		if($check){
			$_SESSION['Err']="Thank You for Contacting with us. We will get back to you soon!";
			header("location: ".PHP_SELF);	
			exit();			
		}else{
			$_SESSION['Err']="Please provide your contact details again.";
			header("location: ".PHP_SELF);
			exit();
		}
	}
}
function valid_contactus_form(){
	
	$errCounter = 0;

	if($_REQUEST['firstname'] == ""){
		$GLOBALS['firstname_err'] = "Please enter Name.";
		 $errCounter++;	
	}

	if($_REQUEST['email'] == ""){
		$GLOBALS['email_err'] = "Please enter E-mail Address.";
		 $errCounter++;	
	}elseif(checkEmail($_REQUEST['email'], '') == 1){
		$GLOBALS['email_err'] = "Invalid E-mail Address.";
		 $errCounter++;
		
	}
	
	/*if($_REQUEST['category_id'] == ""){
		$GLOBALS['category_err'] = "Please enter Enquery On.";
		 $errCounter++;			
	}*/
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}

}
?>