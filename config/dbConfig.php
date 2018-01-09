<?php

    class dbConfig {

        // private $dbHost     = $GLOBALS['dbHost'];
        // private $dbUsername = $GLOBALS['dbUsername'];
        // private $dbPassword = $GLOBALS['dbPassword'];
        // private $dbName     = $GLOBALS['dbName'];

        private $dbCon;
        
        function dbConnect() {
            $this->dbCon = mysqli_connect($GLOBALS['dbHost'],$GLOBALS['dbUsername'],$GLOBALS['dbPassword'],$GLOBALS['dbName']);

            // Check connection
            if (mysqli_connect_errno()) {
                // echo "Failed to connect to MySQL: " . mysqli_connect_error();
                echo "Failed to connect to MySQL";
            }
        }
        
        function dbQuery($sql) {
              return $this->dbCon->query($sql);
//            $queryResult = $this->dbCon->query($sql);
//            if ($queryResult === TRUE) {
//                return $queryResult;
//            } else {
//                $this->dbError($sql, mysqli_error($this->dbCon));
//                return 0;
//            }
        }
        
        function dbError($sql, $error) {
            $sql = urlencode($sql);
            $error = urlencode($error);
            $miscMethods = new miscMethods();
            
            $errorSql = "INSERT INTO db_errors(users_sl,";
            $errorSql .= "file_name,";
            $errorSql .= "query,";
            $errorSql .= "error,";
            $errorSql .= "ip,";
            $errorSql .= "time)"; 
            $errorSql .= "VALUES('',";
            $errorSql .= "'',";
            $errorSql .= "'".$sql."',";
            $errorSql .= "'".$error."',";
            $errorSql .= "'".$miscMethods->getIP()."',";
            $errorSql .= "'".$miscMethods->getDTTM()."');";
            
            $this->dbQuery($errorSql);
        }
    }
?>