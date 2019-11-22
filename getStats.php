<?php

require_once('header.php');

header('Content-Type: application/json');


if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$response = array();

$countQuery = $db->querySelect(
    "Get id ticket",
    "SELECT
        count(*)
        FROM Ticket t
        WHERE t.arrived = 1
        "
);

if ($row = $countQuery->fetch_assoc()) {
    $response = array (
        "Arrived" => $row["count"]
    );
}

