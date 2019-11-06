<?php
$allTicketsAPI = "getTicket.php";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $allTicketsAPI
));

$response = json_decode(curl_exec($curl));

foreach($response as $invitee) {
    $id = $invitee['id'];
    $name = $invitee['name'];
    $arrived = $invitee['arrived'];
    $email = $invitee['email'];
    $ticketSent = $invitee['ticketSent'];

    if (!$ticketSent) {
        $generateTicketAPI = "generateTicket.php?id=" . $id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $generateTicketAPI
        ));

        curl_exec($curl);


        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $email_to = "jesus.cruz@oracle.com";
        $email_subject = "Oracle Party Ticket";

        $message = "<html><head>
<title>Your email at the time</title>
</head>
<body>
<img src=\"/generatedTicket/'$idTicket'.jpg\">
</body>";

$success = mail($email_to, $email_subject , $message,$headers);

        echo 'Successfully sent == ' . $success;
        if (!$success) {
            $errorMessage = error_get_last()['message'];
            header("HTTP/1.1 500");
        } else {
            echo 'Successfully sent';
        }



    }





}
header("HTTP/1.1 200 OK");