<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require "graphql-php/autoload.php";
require "../header.php";

use GraphQL\Type\Definition\ObjectType;
use GraphQl\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

try {
    // Object Definitions


    $schema = new Schema([
        'query' => 'queryType'
    ]);

    $rawinput = file_get_contents('php://input');
    $input = json_decode($rawinput);

    $query = $input["query"];

    $variableValues = isset($input['variables']) ? $input['variables'] : null;

    $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);

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