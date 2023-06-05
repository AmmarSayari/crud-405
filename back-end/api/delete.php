<?php

// Check HTTP request method
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Allow: DELETE');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}

// Set HTTP response headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object and connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate a Bookmark object
$bookmark = new Bookmark($dbConnection);

// Get the HTTP DELETE request JSON body
$data = json_decode(file_get_contents('php://input'));
if (!$data || !$data->id) {
    http_response_code(422);
    echo json_encode(array('message' => 'Error: Missing required parameter id in the JSON body'));
    return;
}

// Set the ID of the bookmark to delete
$bookmark->setId($data->id);

// Delete the bookmark
if ($bookmark->delete()) {
    echo json_encode(array('message' => 'The bookmark was deleted'));
} else {
    echo json_encode(array('message' => 'The bookmark was not deleted'));
}
