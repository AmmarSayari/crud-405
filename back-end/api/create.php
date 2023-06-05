<?php

// Check HTTP request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}
//// just igonre it :) / http://localhost/405-CRUD/api/create.php
// Set HTTP response headers
// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');
// header('Access-Control-Allow-Methods: POST');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object and connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate a Bookmark object
$bookmark = new Bookmark($dbConnection);



////down to create
// Get the HTTP POST request JSON body
$data = json_decode(file_get_contents('php://input'), true);

// If no title or link is included in the JSON body, return an error
if (!$data || !isset($data['title']) || !isset($data['link'])) {
    http_response_code(422);
    echo json_encode(array('message' => 'Error missing required parameters (title or link) in the JSON body'));
    return;
}

// Create a bookmark item
$bookmark->setTitle($data['title']);
$bookmark->setLink($data['link']);

if ($bookmark->create()) {
    echo json_encode(array('message' => 'A bookmark item was created'));
} else {
    echo json_encode(array('message' => 'Error: No bookmark item was created'));
}
