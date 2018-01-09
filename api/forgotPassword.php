<?php
	$validations = new validations();
            
    $validObj = new stdClass();

    $validObj->validAll = 1;
    if(!isset($userObj->user->email)) {
        $validObj->validEmail = 0;
        $validObj->validAll = 0;
    }

    if($validObj->validAll == 1) {
    
        // Email Validation
        $validObj->validEmail = $validations->validateEmail($userObj->user->email);
        
        $validObj->validAll = 1;
        if(!$validObj->validEmail)
            $validObj->validAll = 0;
        
        if($validObj->validAll == 1) {
            
            $validObj->validAll = 0;
            $_SESSION['users_email'] = $userObj->user->email;
            
            $dbConfig = new dbConfig();
            $dbConfig->dbConnect();
            
            $validObj->existingUser = 0;
            $password = "";
            $userSql = "SELECT password FROM users ";
            $userSql .= "WHERE email='".$_SESSION['users_email']."'";
            
            $dbResult = $dbConfig->dbQuery($userSql);
            if ($dbResult->num_rows > 0) {
                while($dbRow = $dbResult->fetch_assoc()) {
                    $password = $dbRow['password'];
                    $validObj->existingUser = 1;
                }
            }

            if($validObj->existingUser == 1 && $password != "")
            	$validObj->validAll = 1;

            if($validObj->validAll == 1) {

                if(!in_array($_SERVER['REMOTE_ADDR'], $GLOBALS['whitelist'])) {
        	        $to = $_SESSION['users_email'];
                    $subject = "BigJApps - Money Manager: Password Retrieval";

                    $message = "<b>Your password is: " . $password . "</b>";

                    $header = "From:moneymanager@bigjapps.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                    $retval = mail ($to,$subject,$message,$header);
                 
                    if( $retval == true ) {
                        $validObj->emailStatus = "Email sent successfully...";
                    }else {
                        $validObj->emailStatus = "Email could not be sent...";
                    }
                }
    	    }
        }
    }

    $returnObj = $validObj;
?>