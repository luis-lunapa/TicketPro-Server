<?php
require_once('header.php');
header('Content-Type: application/json');


if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


$data = json_validate(file_get_contents('php://input'));
echo $data;
foreach($data as $invitee) {
    $name = $invitee['name'];
    $arrived = $invitee['arrived'];
    $rawRepresentation = md5(uniqid(rand(), true));

    $insertQuery = $db ->queryInsert(
        "Inserts the invitees to the db",
        array ("
            INSER INTO 
                Ticket
                (name, arrived, rawRepresentaion)
                VALUES
                ('$name', $arrived, '$rawRepresentation')
        ")
    );
    if ($insertQuery) {
        header("HTTP/1.1 200 OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}