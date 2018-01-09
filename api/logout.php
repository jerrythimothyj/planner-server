<?php
	session_destroy();
	$logoutObj = new stdClass();
	$logoutObj->logoutInd = 1;
	$logoutObj->message = "Logged out successfully";

	$returnObj  = $logoutObj;
?>