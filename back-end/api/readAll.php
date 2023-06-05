<?php

// Check HTTP request method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}

// Set HTTP response headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object and connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate a Bookmark object
$bookmark = new Bookmark($dbConnection);

// Read all bookmark items
$result = $bookmark->readAll();

if (!empty($result)) {
    echo json_encode($result);
} else {
    echo json_encode(array('message' => 'No bookmark items were found'));
}