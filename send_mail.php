<?php
$webmaster_email = "chef1ryan@yahoo.com";

$thankyou_page = "thank_you.html";
$error_page = "error_message.html";

$email_address = $_REQUEST['email'];
$user_name = $_REQUEST['name'];
$email_subject = $_REQUEST['subject'];
$email_message = $_REQUEST['message'];
$msg = 
"Name: " . $user_name . "\r\n" .
"Email: " . $email_address . "\r\n" .
"Subject: " . $email_subject . "\r\n" .
"Message: " . $email_message ;


function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

if (!isset($_REQUEST['email_address'])) {
header( "Location: $thankyou_page" );
}
elseif (empty($user_name) || empty($email_address)) {
header( "Location: $error_page" );
}
elseif ( isInjected($email_address) || isInjected($user_name)  || isInjected($email_message) ) {
header( "Location: $error_page" );
}
else {

	mail( "$webmaster_email", "Feedback Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>