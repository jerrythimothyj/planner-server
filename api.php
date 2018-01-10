<?php

    require('./config/config.php');

    if($_GET['api'] != 'newUserRegistration' && 
       $_GET['api'] != 'login' &&
       $_GET['api'] != 'forgotPassword' ) {

        if(!isset($_SESSION['users_sl'])) {
            header('HTTP/1.0 403 Forbidden');
            return 'You are forbidden!';
        };
    }

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $reminder = new reminder();

    switch($_GET['api']) {
        case 'newUserRegistration':
            print_r(json_encode($reminder->newUserRegistration($obj)));
            break;

        case 'login':
            print_r(json_encode($reminder->login($obj)));
            break;

        case 'forgotPassword':
            print_r(json_encode($reminder->forgotPassword($obj)));
            break;

        case 'logout':
            print_r(json_encode($reminder->logout($obj)));
            break;
    }
?>