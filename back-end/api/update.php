<?php

// Check HTTP request method
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}

// Set HTTP response headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object and connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate a Bookmark object
$bookmark = new Bookmark($dbConnection);

// Get the HTTP PUT request JSON body
$data = json_decode(file_get_contents('php://input'));
if (!$data || !isset($data->id) || !isset($data->done)) {
    http_response_code(422);
    echo json_encode(array('message' => 'Error: Missing required parameters id and done in the JSON body'));
    return;
}

// Update the bookmark item
$bookmark->setId($data->id);
$bookmark->setDone($data->done);

if ($bookmark->update()) {
    echo json_encode(array('message' => 'The bookmark item was updated'));
} else {
    echo json_encode(array('message' => 'The bookmark item was not updated'));
}