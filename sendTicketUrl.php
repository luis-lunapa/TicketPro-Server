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
$count = 0;
foreach($response as $invitee) {
    $count += 1;
    $id = $invitee['id'];
    $email = $invitee['email'];
    $urlSent = $invitee['urlSent'];

    if(!$urlSent && $count < 10) {


        $url = $domain . "tickets/ticket.php?id=$id";


        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $email_to = $email;
        $email_subject = "Oracle Party Ticket";

        $email_to = "luis.g.pena@oracle.com";
        $email_subject = "Oracle Party Ticket Link";
        $message = "<html<body><h1>En el siguiente link podras descargar tu ticket en caso de no haberlo recibido</h1>

<br>
<a href='$url'>Obtener Ticket</a>
</body> </html>
";


        $success = mail($email_to, $email_subject, $message, $headers);
        if ($success) {
            $updated = $db->queryInsert(
                "Updates the ticket sent value",
                array(
                    "UPDATE Ticket
                    SET urlSent = 1
                    WHERE id = $id

                    ")
            );


            if ($updated) {
                array_push($urlResponse, array(
                    "sent" => true,
                    "url" => $url
                ));

            } else {
                array_push($urlResponse, array(
                    "sent" => false,
                    "queryError" => true,
                    "url" => $url
                ));
            }


        } else {
            array_push($urlResponse, array(
                "sent" => false,
                "url" => $url,
                "emailError" => true,
            ));
        }
    }



}

echo(json_encode($urlResponse));

exit;


