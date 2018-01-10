<?php

session_start();
$userId = $_SESSION['userId'];

include "../classes/barcode/php-barcode.php";
include "../classes/post.php";
$post = new Post();

$userId = $_POST['id'];

$getUser = $post->getUser($userId);
$approve = $post->approveUser($userId);
foreach ($getUser as $id => $record):
    $email = $record['email'];
endforeach;

if ($approve == 1) {
    require('mail/class.phpmailer.php');
    require('mail/class.smtp.php');
    $encrypt_id = md5($userId . 'geotagWeb');

    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    $mail = new PHPMailer();
    $body = "Thank you for signing up with GeoTag web. Your account is now ready. Click on the link below to verify your account.
			<br><br>
			" . $root . "geotag_web/confirmation/" . $encrypt_id . "
			<br><br><br>
			Sincerely,<br>
			Development Team"; #HTML tags can be included
    $mail->MsgHTML($body);
    $mail->IsSMTP();
    $mail->SMTPAuth = true;                 #enable SMTP authentication
    $mail->SMTPSecure = "ssl";               #sets the prefix to the server
    $mail->Host = "smtp.gmail.com";         #sets GMAIL as the SMTP server
    $mail->Port = 465;                 #set the SMTP port
    $mail->Username = "dbmp.mailer@gmail.com";                  #your gmail username
    $mail->SMTPDebug = 1;
    $mail->Password = "philrice";                  #Your gmail password
    $mail->From = "dbmp.mailer@gmail.com";                  #your gmail id
    $mail->FromName = "PhilRice GeoTagging Tool";                  #your name
    $mail->Subject = "Account Registration";
    $mail->WordWrap = 50;
    $mail->AddAddress($email);
    $mail->IsHTML(true); // send as HTML
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo '1';
    }
}
?>