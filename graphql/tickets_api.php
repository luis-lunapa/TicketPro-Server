<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require "graphql-php/autoload.php";
require "../header.php";
require "DB.php";

use GraphQL\Type\Definition\ObjectType;
use GraphQl\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;







header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");