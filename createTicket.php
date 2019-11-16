<?php
require_once('header.php');
header('Content-Type: application/json');


if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


$data = json_validate(file_get_contents('php://input'));
$responseArray = $data["response"];
foreach($responseArray as $invitee) {
    $id = $invitee['id'];
    $name = $invitee['name'];
    $arrived = $invitee['arrived'];
    $email = $invitee['email'];

    $insertQuery = $db ->queryInsert(
        "Inserts the invitees to the db",
        array ("
            INSERT INTO 
                Ticket
                (id, name, arrived, email)
                VALUES
                ('$id', '$name', $arrived, '$email')
        ")
    );
    if ($insertQuery) {
        header("HTTP/1.1 200 OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

function json_validate($string) {
    // decode the JSON data
    $result = json_decode($string, true);

    // switch and check possible JSON errors
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = ''; // JSON is valid // No error has occurred
            break;
        case JSON_ERROR_DEPTH:
            $error = 'The maximum stack depth has been exceeded.';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Invalid or malformed JSON.';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Control character error, possibly incorrectly encoded.';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON.';
            break;
        // PHP >= 5.3.3
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_RECURSION:
            $error = 'One or more recursive references in the value to be encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_INF_OR_NAN:
            $error = 'One or more NAN or INF values in the value to be encoded.';
            break;
        case JSON_ERROR_UNSUPPORTED_TYPE:
            $error = 'A value of a type that cannot be encoded was given.';
            break;
        default:
            $error = 'Unknown JSON error occured.';
            break;
    }

    if ($error !== '') {
        // throw the Exception or exit // or whatever :)
        exit($error);
    }

    // everything is OK
    return $result;
}