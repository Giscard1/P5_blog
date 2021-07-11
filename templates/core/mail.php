<?php


if ($_SERVER['REQUEST_METHOD']=='POST'){

    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $email = htmlentities($_POST['email']);
    $body = htmlentities($_POST['body']);

    $destinataire = 'giscarddesousajunior@hotmail.fr';

    $contenu .= '<p>Tu as un nouveau message !</p>';
    $contenu .= '<p><strong>Prénom</strong>: '.$firstname.'</p>';
    $contenu .= '<p><strong>Nom</strong>: '.$lastname.'</p>';
    $contenu .= '<p><strong>Email</strong>: '.$email.'</p>';
    $contenu .= '<p><strong>Message</strong>: '.$body.'</p>';
    $contenu .= '</body></html>';

    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

    mail($destinataire, $contenu, $headers);
}
