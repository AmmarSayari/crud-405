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


if (!isset($_GET['id'])) {
    http_response_code(422);
    echo json_encode(array('message' => 'Error missing required query parameter id.'));
    return;
}

// Read Bookmark details
$bookmark->setId($_GET['id']);
if ($bookmark->readOne()) {
    $result = array(
        'id' => $bookmark->getId(),
        'title' => $bookmark->getTitle(),
        'link' => $bookmark->getLink(),
        'date_added' => $bookmark->getDateAdded()
    );
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'Error: No such bookmark item.'));
}
