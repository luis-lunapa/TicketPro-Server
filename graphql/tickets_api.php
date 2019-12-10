<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require "graphql-php/autoload.php";
require_once ("../header.php");

use GraphQL\Type\Definition\ObjectType;
use GraphQl\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

use GraphQL\Error\Debug;

$debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;

try {
    $db = new DBManager();
    // Object Definitions

    $ticketsCount = new ObjectType([
        'name' => 'ticketCount',
        'fields' => [
            'count' => ['type' => Type::int()]
        ]
    ]);

    $ticketType = new ObjectType([
        'name' => 'ticket',
        'fields' => [
            'id' => Type::string(),
            'name' => Type::string(),
            'arrived' => Type::boolean(),
            'email' => Type::string(),
            'ticketSent' => Type::boolean(),
            'ticketGenerated' => Type::boolean(),
            'urlSent' => Type::boolean(),
        ]
    ]);

    $queryType = new ObjectType([
       'name' => 'Tickets',
        'fields' => [
            'ticket' => [
                'type' => Type::listOf($ticketType),
                'args' => [
                    'id' => Type::string(),
                    'name' => Type::string(),
                    'email' => Type::string()
                ],

                'resolve' => function($root, $args, $context) {
                    $rows = array();
                    if(isset($args['id'])) {
                        $id = $args['id'];
                        $ticketQueryResult = DBManager()->querySelect(
                            "Get id ticket",
                            "SELECT
                            t.id,
                            t.name,
                            t.arrived,
                            t.email,
                            t.ticketSent,
                            t.ticketGenerated,
                            t.urlSent
                            FROM Ticket t
                            WHERE t.id = '$id'
                            "
                        );

                        while ($row = $ticketQueryResult->fetch_assoc()) {
                            array_push($rows, array(

                                    'id' => $row['id'],
                                    'name' => $row['name'],
                                    'arrived' => $row['arrived'],
                                    'email' => $row['email'],
                                    'ticketSent' => $row['ticketSent'],
                                    'ticketGenerated' => $row['ticketGenerated'],
                                    'urlSent' => $row['urlSent']
                                )
                            );
                        }
                        print_r($rows);
                        return $rows;
                    }
                }
            ]

        ]
    ]);

    echo $queryType;

    $schema = new Schema([
        'query' => $queryType
    ]);

    $rawinput = file_get_contents('php://input');
    $input = json_decode($rawinput, true);


    $query = $input["query"];

    $variableValues = isset($input['variables']) ? $input['variables'] : null;

    $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues)->toArray(true);

    $output = $result->toArray();

} catch (\Exception $e) {
    $output = [
        'error' => [
            'message' => $e->getMessage()
        ]
    ];
}


header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

echo json_encode($output);