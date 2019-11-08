<?php
include_once ('header.php');

header('Content-Type: application/json');
$response = array();

$id = "";

if (isset($_GET['id']) && trim($_GET['id']) != "") {
    header("HTTP/1.1 422 Unprocessable Entity");
    exit;
}

$id = $_GET['id'];

$updatedArrived = $db -> queryInsert(
    "Updates arrived ticket value",
    array(
        "UPDATE Ticket
                    SET arrived = 1
                    WHERE id = $id
                    
                    ")
);

if ($updatedArrived) {
    header("HTTP/1.1 200 OK");
    $response['msg'] = 'Successfully arrived';
} else {
    header("HTTP/1.1 500 Internal Server Error");
    $response['msg'] = 'Error updating arrived';
}
