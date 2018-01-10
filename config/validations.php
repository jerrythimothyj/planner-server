<?php
    class validations {
        function validateEmail($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
              return 0;
            return 1;
        }
        
        function validatePwd($pwd) {
            return (strlen($pwd) < 8)? 0 : 1;
        }
        
        function validateConfPwd($pwd, $confPwd) {
            return (strcmp($pwd,$confPwd) != 0)? 0 : 1; 
        }

        function validateDate($date) {
            $dateArr = explode('/', $date);
            return checkdate($dateArr[1], $dateArr[2], $dateArr[0]);
        }

        function validateTime($time) {
            if(preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $foo)) {
                $timeArr = explode(':', $time);
                return $timeArr[0] > 0 && $timeArr[0] < 24 && $timeArr[1] > 0 && $timeArr[0] < 59;
            }
            return false;
        }

        function validateEmailsList($emailsList) {
            $emailsList = trim($emailsList);
            if($emailsList == "") {
                return true;
            } else {
                $emailsListArr = explode(",", $emailsList);
                for($ictr = 0; $ictr < count($emailsListArr); $ictr++) {
                    if(!validateEmail(trim($emailsListArr))) {
                        return false;
                    }
                }
                return true;
            }
        }

        function validateNumber($number) {
            return is_numeric($number);
        }

        function validateFreeText($text) {
            return true;
        }
    }
?>