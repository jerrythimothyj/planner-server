<?php
	$validations = new validations();
            
    $validObj = new stdClass();
    
    $validObj->validAll = 1;
    if(!isset($newUserObj->user->email)) {
        $validObj->validEmail = 0;
        $validObj->validAll = 0;
    }

    if(!isset($newUserObj->user->pwd)) {
        $validObj->validPwd = 0;
        $validObj->validAll = 0;
    }
    else if(!isset($newUserObj->user->confPwd)) {
        $validObj->validConfPwd = 0;
        $validObj->validAll = 0;
    }

    if($validObj->validAll == 1) {

        // Email Validation
        $validObj->validEmail = $validations->validateEmail($newUserObj->user->email);
        
        // Password Validation
        $validObj->validPwd = $validations->validatePwd($newUserObj->user->pwd);
        
        // Confirm Password Validation
        $validObj->validConfPwd = $validations->validateConfPwd($newUserObj->user->pwd, $newUserObj->user->confPwd);
        
        $validObj->validAll = 1;
        if(!$validObj->validEmail || 
          !$validObj->validPwd || 
          !$validObj->validConfPwd)
            $validObj->validAll = 0;
        
        if($validObj->validAll == 1) {
            
            $_SESSION['users_email'] = $newUserObj->user->email;
            
            $dbConfig = new dbConfig();
            $dbConfig->dbConnect();
            
            $miscMethods = new miscMethods();

            $validObj->existingUser = 0;
            $newUserSql = "SELECT sl FROM users ";
            $newUserSql .= "WHERE email='".$_SESSION['users_email']."'";
            
            $dbResult = $dbConfig->dbQuery($newUserSql);
            if ($dbResult->num_rows > 0) {
                while($dbRow = $dbResult->fetch_assoc()) {
                    $_SESSION['users_sl'] = $dbRow['sl'];
                    $validObj->existingUser = 1;
                }
            }

            if($validObj->existingUser == 1)
            	$validObj->validAll = 0;

            if($validObj->validAll == 1) {
    	        $newUserSql = "INSERT INTO users (email,";
    	        $newUserSql .= "password,";
    	        $newUserSql .= "ip,"; 
    	        $newUserSql .= "time)";
    	        $newUserSql .= "VALUES ('".$newUserObj->user->email."',";
    	        $newUserSql .= "'".$newUserObj->user->pwd."',";
    	        $newUserSql .= "'".$miscMethods->getIP()."',";
    	        $newUserSql .= "'".$miscMethods->getDTTM()."')";
    	        
    	        $dbConfig->dbQuery($newUserSql);
    	        
    	        $newUserSql = "SELECT sl FROM users ";
    	        $newUserSql .= "WHERE email='".$_SESSION['users_email']."'";
    	        
    	        $dbResult = $dbConfig->dbQuery($newUserSql);
    	        if ($dbResult->num_rows > 0) {
    	            while($dbRow = $dbResult->fetch_assoc()) {
    	                $_SESSION['users_sl'] = $dbRow['sl'];
    	                $validObj->validUser = 1;

                        if(!in_array($_SERVER['REMOTE_ADDR'], $GLOBALS['whitelist'])) {

                            $subject = "BigJApps - Money Manager: New User Registration";

                            $message = "<b>New user is: " . $newUserObj->user->email . "</b>";

                            $header = "From:moneymanager@bigjapps.com \r\n";
                            $header .= "MIME-Version: 1.0\r\n";
                            $header .= "Content-type: text/html\r\n";

                            $retval = mail ('jerrythimothy@gmail.com',$subject,$message,$header);
                        }
    	            }
    	        }
    	    }
        }

    }

    $returnObj = $validObj;
?>