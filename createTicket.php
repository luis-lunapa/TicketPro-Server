<?php
require_once('header.php');
$data = json_validate(file_get_contents('php://input'));

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