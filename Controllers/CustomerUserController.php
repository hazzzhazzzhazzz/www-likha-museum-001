<?php

    session_start();        
    require_once '../BusinessLogic/CustomerUserManagement.php';
    require_once '../Helper/SendEmails.php';

    if (!isset($_SESSION['userArray'])) {
        $_SESSION['userArray'] = [];
    }

    $userManagement = new CustomerUserManagement();

    
    function hasNonEmptyPostKeys($keys) {
        foreach ($keys as $key) {
            if (!isset($_POST[$key]) || trim((string)$_POST[$key]) === '') {
                return false;
            }
        }

        return true;
    }

    
    if (hasNonEmptyPostKeys(['fName', 'mName', 'lName', 'customerTypeID', 'email', 'contactNumber', 'birthDate', 'scheduledDate'])) {
        if (!ctype_digit((string)$_POST['customerTypeID'])) { //int kasi si customerTypeID base sa ginawa ko sa HeidiSQL
            http_response_code(400);
            echo 'Invalid customer type selected.';
            exit;
        }

        /* SENDING WELCOME EMAIL TO NEW EMPLOYEES */

/*        $name = htmlspecialchars(trim((string)$_POST['fName']) . ' ' . trim((string)$_POST['lName']), ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if(!$email) {
            die("Invalid Email Address");
        }

        $templatePath = __DIR__ . '/../View/Emails/welcome_email_for_employees.html';
        $body = file_get_contents($templatePath);

        if ($body === false) {
            die('Unable to load email template.');
        }

        $body = str_replace('SomeName', $name, $body); //kasi may SomeName sa template, papalitan siya ng actual name from the input $name variable

        $result = sendEmail(
            $email,
            $name,
            "Welcome to Likha Museum!",
            $body
        );

        
        if ($result === true) {
            echo "Email sent successfully.";
        }
        else {
            echo "Failed to send email: $result";
        } */

        /* AND SAKA NA SIYA I-ADD SA TABLE AND DATABASE KAYA PALA HINDI NAKA-ADD SA DATABASE NA-COMMENT KO ITO NOONG NAKARAAN */
        $userManagement -> proceedPaymentUserFunc($_POST['fName'], $_POST['mName'], $_POST['lName'], $_POST['customerTypeID'], $_POST['email'], $_POST['contactNumber'], $_POST['birthDate'], $_POST['scheduledDate']);
        exit;

    }

    else if (hasNonEmptyPostKeys(['uFName', 'uMName', 'uLName', 'uID', 'email', 'contactNumber', 'birthDate', 'scheduledDate', 'customerTypeID'])) {
        if (!ctype_digit((string)$_POST['uID']) || !ctype_digit((string)$_POST['customerTypeID'])) {
            http_response_code(400);
            echo 'Invalid user or customer type ID.';
            exit;
        }

/*        $name = htmlspecialchars(trim((string)$_POST['uFName']) . ' ' . trim((string)$_POST['uLName']), ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if(!$email) {
            die("Invalid Email Address");
        }

        $templatePath = __DIR__ . '/../View/Emails/update_email_for_employees.html';
        $body = file_get_contents($templatePath);

        if ($body === false) {
            die('Unable to load email template.');
        }

        $body = str_replace('SomeName', $name, $body); //kasi may SomeName sa template, papalitan siya ng actual name from the input $name variable

        $result = sendEmail(
            $email,
            $name,
            "Did you change your account details?",
            $body
        );

        
        if ($result === true) {
            echo "Email sent successfully.";
        }
        else {
            echo "Failed to send email: $result";
        } */

        
        $userManagement -> updateUserFunc(
            $_POST['uFName'],
            $_POST['uMName'],
            $_POST['uLName'],
            $_POST['uID'],
            $_POST['email'],
            $_POST['contactNumber'],
            $_POST['birthDate'],
            $_POST['scheduledDate'],
            $_POST['customerTypeID']
        );

        exit;
    }

    //delete php
    else if(hasNonEmptyPostKeys(['dID'])) { 
        if (!ctype_digit((string)$_POST['dID'])) {
            http_response_code(400);
            echo 'Invalid user ID for delete.';
            exit;
        }

        //sinabi ni sir na bakit yung iba pa may FirstName MiddleName LastName, magdedelate lang naman
        //hindi na kailangan ang firstname middlename lastname kasi ang redundant na

        $userManagement -> deleteUserFunc($_POST['dID']);
        exit;
    }

    else {
        http_response_code(400);
        echo 'Ay nag-error!';
    }

?>