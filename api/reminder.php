<?php
    class reminder {
        function newUserRegistration($newUserObj) {
            require('./api/newUserRegistration.php');
            return $returnObj;
        }

        function login($userObj) {
            require('./api/login.php');
            return $returnObj;
        }

        function forgotPassword($userObj) {
            require('./api/forgotPassword.php');
            return $returnObj;
        }

        function logout() {
            require('./api/logout.php');
            return $returnObj;
        }

        function saveReminders($reminderObj) {
            require('./api/saveReminders.php');
            return $returnObj;
        }

        function getReminders($reminderObj) {
            require('./api/saveReminders.php');
            return $returnObj;
        }
    }
?>