<?php

$idTicket = "";
if (!isset($_GET['id']) && trim($_GET['id']) == "") {
    header("HTTP/1.1 422 Unprocessable Entity");
    exit;
}
$idTicket = $_GET['id'];


$ticketGen = "https://barcode.tec-it.com/barcode.ashx?data=" . "id:$idTicket" . "&code=PDF417&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0";

echo $ticketGen;