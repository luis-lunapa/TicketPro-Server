<?php

$idTicket = "";
if (!isset($_GET['id']) && trim($_GET['id']) == "") {
    header("HTTP/1.1 422 Unprocessable Entity");
    exit;
}
$idTicket = $_GET['id'];


$ticketAPI = "https://barcode.tec-it.com/barcode.ashx?data=" . "id:$idTicket" . "&code=PDF417&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0";

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $ticketAPI
));

$ticketCode= curl_exec($curl);
$ticketImage = imagecreatefrompng('resources/ticket.png');

imagealphablending($ticketImage, false);
imagesavealpha($ticketImage, true);

imagecopymerge($ticketImage, $ticketCode, 10, 9, 0, 0, 181, 180, 100);

header('Content-Type: image/png');
imagepng($ticketImage);