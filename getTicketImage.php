<?php
require_once('header.php');
header('Content-Type: image/png');

if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $id = "";

    if (!isset($_GET['id']) && trim($_GET['id']) == "") {
        header("HTTP/1.1 422 Unprocessable Entity");
        exit;
    }

    $id = $_GET['id'];

    $ticketImage = imagecreatefrompng('resources/ticket.png');




    imagepng($ticketImage);
}
