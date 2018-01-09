<?php
    class planner {
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

        function savePlans($plansObj) {
            require('./api/savePlans.php');
            return $returnObj;
        }

        function getPlans($plansObj) {
            require('./api/getPlans.php');
            return $returnObj;
        }
    }
?>