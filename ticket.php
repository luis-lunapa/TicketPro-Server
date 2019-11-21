<?php
$idTicket = "";
if (!isset($_GET['id']) && trim($_GET['id']) == "") {
    header("HTTP/1.1 422 Unprocessable Entity");
    exit;
}
$idTicket = $_GET['id'];

$ticketImg = imagecreatefrompng("generatedTickets/TO" . $idTicket . ".png");

header('Content-Type: image/png');
header('Title: Oracle Ticket');
imagepng($ticketImg);