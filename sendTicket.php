<?php
$allTicketsAPI = "getTicket.php";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $allTicketsAPI
));

$response = json_decode(curl_exec($curl));

echo $response;