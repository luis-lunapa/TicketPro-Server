<?php
require_once('header.php');
require_once('Mail.php');

if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
$allTicketsAPI = $domain . "tickets/getTicket.php";

$ch = curl_init ($allTicketsAPI);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);

$raw=curl_exec($ch);

$response = json_decode($raw, true);
$urlResponse = array();
foreach($response as $invitee) {
    $id = $invitee['id'];
    $email = $invitee['email'];

    $url = $domain . "tickets/ticket.php?id=$id";
    array_push($urlResponse, array(
        "url" => $url
    ));

    $contentType .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $email_to = "luis.g.pena@oracle.com";
    $email_subject = "Oracle Party Ticket Link";
    $message = "<h1>En el siguiente link podras descargar tu ticket en caso de no haberlo recibido</h1>

<br>
<a href='$url'>Obtener Ticket</a>
";

    $headers = array (
        'From' => 'Oracle Ticket System <tickets@oracle.com>',
        'To' => $email_to,
        'Subject' => $email_subject,
        'Content-type' => $contentType);


$host = "smtp.hostinger.mx";
    $smtp = Mail::factory('smtp',
        array ('host' => $host,
            'auth' => true,
            'username' => 'tickets@luislunapa.com',
            'password' => 'Welcome1'));

   // $success = mail($email_to, $email_subject , $message, $headers);
    $mail = $smtp->send($email_to, $headers, $message);
    if (PEAR::isError($mail)) {
        echo("<p>" . $mail->getMessage() . "</p>");
    } else {
        echo("<p>Message successfully sent!</p>");
    }
    exit;

}

echo(json_encode($urlResponse));
