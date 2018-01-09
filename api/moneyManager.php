<?php
    class moneyManager {
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
        
        function expenseFields() {
            require('./api/expenseFields.php');
            return $returnObj;
        }
        
        function spendingFields() {
            require('./api/spendingFields.php');
            return $returnObj;
        }

        function saveExpenses($expenseObj) {
            require('./api/saveExpenses.php');
            return $returnObj;
        }

        function saveBudget($budgetObj) {
            require('./api/saveBudget.php');
            return $returnObj;
        }

        function getExpenses($expenseObj) {
            require('./api/getExpenses.php');
            return $returnObj;
        }

        function getBudget($budgetObj) {
            require('./api/getBudget.php');
            return $returnObj;
        }

        function getDashboard($expenseObj) {
            require('./api/getDashboard.php');
            return $returnObj;
        }
    }
?>