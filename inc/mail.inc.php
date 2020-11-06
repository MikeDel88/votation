<?
require 'db-connect.inc.php';
require_once 'router.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($email && $password && $pseudo) {

        $passwordCrypte = password_hash($password, PASSWORD_DEFAULT);

        $query = $db->prepare("INSERT INTO users(email, pseudo, password) VALUES (:email, :pseudo, :password)");
        $query->execute(array(
            ':email' => $email,
            ':pseudo' => $pseudo,
            ':password' => $passwordCrypte,
        ));
        $id = $db->lastInsertId();

        if ($query->errorCode() == '00000') {

            $message = "<html><body><a href='$lienMail/verif.php?id=$id&confirm=$passwordCrypte'>Merci de confirmer votre compte</a></body></html>";

            require 'gmail.inc.php';
            require '../password/password.inc.php';

            //Set who the message is to be sent to
            $mail->addAddress($email, $pseudo);
            //Set the subject line
            $mail->Subject = 'Confirmation du compte Votation';
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($message);
            //Replace the plain text body with one created manually
            // $mail->Body = $message;
            //Attach an image file
            // $mail->addAttachment('images/phpmailer_mini.png');
            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $info = "mailSend";
                accueilAvecError($chemin, $info);
            }

        } elseif ($query->errorCode() == '23000') {
            $info = "userExist";
            accueilAvecError($chemin, $info);

        }

    } else {
        $info = "errorValidation";
        accueilAvecError($chemin, $info);

    }
}
