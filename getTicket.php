<?php


require_once('include/header.php');
/*
*	This service get all data of a ticket
*
*	Parámetros:
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
        t.photo,
        t.arrived
        FROM Ticket t
        WHERE t.id = $idTicket
        "

    );
    $db->printQuery();

    while ($row = $ticket->fetch_assoc()) {
        array_push($response, array(

                'id' => $row['id'],
                'name' => $row['name'],
                'photo' => $row['photo'],
                'arrived' => $row['arrived']
            )
        );
    }
}
echo(json_encode($response));
exit;
if (!isset($_GET['id']) || trim($_GET['id']) == "") {
    /// Get all buses
    $allBuses = $db->querySelect(
        "Get all routes",
        "SELECT
        b.Id,
        b.name,
        b.color
    FROM
        BusRoutes b 
    "
    );


    while ($row = $allBuses->fetch_assoc()) {

        $id = $row['Id'];
        $points = $db->querySelect(
            "Get points for every route",
            "
        SELECT 
            *
        FROM
        RoutePoints r
        WHERE
        r.route = $id
        "
        );


        $coordinates = array();

        while ($coordRow = $points->fetch_assoc()) {
            array_push($coordinates, array(
                'latitude' => $coordRow['latitude'],
                'longitude' => $coordRow['longitude']
            ));
        }

        array_push($response, array(

                'id' => $row['Id'],
                'name' => $row['name'],
                'color' => $row['color'],
                'points' => $coordinates

            )
        );
    }

} else {
    /// Get stops for the given route id
    $idRoute = $_GET['id'];

    $allBuses = $db->querySelect(
        "Get the stops for the given route",
        "SELECT
        b.Id,
        b.latitude,
        b.longitude,
        b.name,
        b.photo
    FROM
        BusStops b INNER JOIN
        BusSchedule s ON
        b.Id = s.stop
        
    WHERE 
        s.route = $idRoute
    "
    );
//$db->printQuery();


    while ($row = $allBuses->fetch_assoc()) {
        array_push($response, array(

                'id' => $row['Id'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'name' => $row['name'],
                'photo' => $row['photo']
            )
        );
    }


}

$staticModels = array(
    array(
        'id' => 1,
        'route' => 1,
        'serialNumber' => 'DS3',
        'plates' => 'GYU4321'
    ),
    array(
        'id' => 3,
        'route' => 5,
        'serialNumber' => 'GD24T',
        'plates' => 'SEFWS3'
    )


);


echo(json_encode($response));

