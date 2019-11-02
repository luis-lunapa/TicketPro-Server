<?php
require_once('header.php');
$data = json_validate(file_get_contents('php://input'));
