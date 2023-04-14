<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

class CustomMail
{
    function mailMan($obj){
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $obj->host;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $obj->senderEmail;                     //SMTP username
            $mail->Password   = 'TomRuNek2022?';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        
            //Recipients
            $mail->setFrom($obj->senderEmail, $obj->senderName);
            $mail->addAddress($obj->recipientEmail, $obj->recipientName);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            if(isset($obj->replyToEmail) && isset($obj->replyToFullName)){
                $mail->addReplyTo($obj->replyToEmail, $obj->replyToFullName);
            }
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $obj->subject;
            $mail->Body    = $obj->body;
            if(isset($obj->altBody) && ($obj->altBody)){
                $mail->AltBody = $obj->altBody;
            } else {
                $mail->AltBody = 'Please use a HTML mail client';
            }
        
            $mail->send();
            $output = array(
                "message" => "Message has been sent",
                "status" => true
            );
        } catch (Exception $e) {
            $output = array(
                "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
                "status" => false
            );
        }
        return $output;
    }
}

?>