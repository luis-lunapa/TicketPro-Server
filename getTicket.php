<?php


require_once('header.php');
/*
*	This service get all data of a ticket
*
*	Parameters:
*    - id
 *   - personName

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

if (isset($_GET['id']) && trim($_GET['id']) != "") {
    // Get only id ticket
    $idTicket = $_GET['id'];
    $ticket = $db->querySelect(
        "Get id ticket",
        "SELECT
        t.id,
        t.name,
        t.arrived,
        t.email
        FROM Ticket t
        WHERE t.id = $idTicket
        "
    );

    while ($row = $ticket->fetch_assoc()) {
        array_push($response, array(

                'id' => $row['id'],
                'name' => $row['name'],
                'arrived' => $row['arrived'],
                'email' => $row['email']
            )
        );
    }

} else if (isset($_GET['name']) && trim($_GET['name']) != "") {
    // Get only name ticket
    $nameTicket = $_GET['name'];
    $ticket = $db->querySelect(
        "Get name ticket",
        "SELECT
        t.id,
        t.name,
        t.arrived,
        t.email
        FROM Ticket t
        WHERE t.name LIKE '%$nameTicket%'
        "
    );

    while ($row = $ticket->fetch_assoc()) {
        array_push($response, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'arrived' => $row['arrived'],
                'email' => $row['email']
            )
        );
    }
} else {
    // Get all tickets
    $tickets = $db->querySelect(
        "Get all tickets",
        "SELECT
        t.id,
        t.name,
        t.arrived,
        t.email
        FROM Ticket t

        "
    );

    while ($row = $tickets->fetch_assoc()) {
        array_push($response, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'arrived' => $row['arrived'],
                'email' => $row['email']
            )
        );
    }
}
echo(json_encode($response));
exit;