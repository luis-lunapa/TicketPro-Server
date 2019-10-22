<?php
require_once('header.php');
/*
*	This service creates a session
*
*	Parameters:
*    - username
 *   - password

*
*	Return JSON
*
*	Lista de status:
*	- 0         No execution
*	- 200 	    Success
*/

header('Content-Type: application/json');


if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$response = array();

$username = "";
if (!isset($_GET['username']) || trim($_GET['username']) == "") {
    header("HTTP/1.1 422 Unprocessable Entity");
    $response['msg'] = "Missing username";
    echo json_encode($response);
    exit;

} else {
    $username = $_GET['username'];
}

$password = "";
if (!isset($_GET['password']) || trim($_GET['password']) == "") {
    header("HTTP/1.1 422 Unprocessable Entity");
    $response['msg'] = "Missing password";
    echo json_encode($response);
    exit;

}


$session = $db->querySelect(
    "Login",
    "SELECT
        u.id,
        u.name
        FROM User u
        WHERE u.username = '$username'
        AND u.password = '$password'
        "
);

$userId = '';
$name = '';

if ($row = $session->fetch_assoc()) {
    $userId = $row['id'];
    $name = $row['name'];
} else {
    header("HTTP/1.1 401 Unauthorized");
    echo(json_encode($response));
    exit;
}

$newToken = md5(uniqid(rand(), true));
/// Create session
$db->queryInsert(
    "Creates a new session",
    array(
        "INSERT INTO Session
(user, token, valid)
VALUES ($userId, '$newToken', 1)

"
    )
);




