<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $config = require __DIR__ . '/../Config/Mail.php';


    function sendEmail($toEmail, $toName, $subject, $body) {
        global $config;

        $mail = new PHPMailer(true);

        try {
            
            $mail->isSMTP();
            $mail->Host        = $config['host'];
            $mail->SMTPAuth    = true;
            $mail->Username    = $config['username'];
            $mail->Password    = $config['password'];
            $mail->SMTPSecure  = $config['encryption'];
            $mail->Port        = $config['port'];

            $mail->setFrom($config['username'], 'Likha Museum'); //optional

            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
            return true;

        }

        catch (Exception $e) {
            return $mail->ErrorInfo;
        }

    }

?>