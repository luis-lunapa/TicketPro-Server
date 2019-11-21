<?php
require_once('header.php');

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

}

echo(json_encode($response));
