<?php

$idTicket = "";
if (!isset($_GET['id']) && trim($_GET['id']) == "") {
    header("HTTP/1.1 422 Unprocessable Entity");
    exit;
}
$idTicket = $_GET['id'];


$ticketAPI = "https://barcode.tec-it.com/barcode.ashx?data=" . "id:$idTicket" . "&code=PDF417&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=png&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0";

grab_image($ticketAPI, $idTicket);

$ticketCode = imagecreatefrompng("generatedTickets/onlyCode" . $idTicket . ".png");
$ticketImage = imagecreatefrompng('resources/ticket.png');

imagealphablending($ticketImage, false);
imagesavealpha($ticketImage, true);

$done = imagecopymerge($ticketImage, $ticketCode, 0, 761, 0, 0, 250, 40, 100);

if ($done) {

} else {
    header("HTTP/1.1 500 Internal Server Error");
}
header('Content-Type: image/png');
imagepng($ticketImage);




function grab_image($url, $idTicket){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    $saveto = "generatedTickets/onlyCode" . $idTicket . ".png";
    if(file_exists($saveto)){
        unlink($saveto);
    }

    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
}