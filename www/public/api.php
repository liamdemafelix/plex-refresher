<?php

header("Content-Type: application/json");

// Check parameters
$param = (isset($_GET['action']) ? trim(stripslashes($_GET['action'])) : false);
try {
    require __DIR__ . '/../app/functions.php';
    $key = (isset($_GET['key']) ? trim(stripslashes($_GET['key'])) : false);
    switch ($param) {
        default:
            throw new Exception('Invalid action specified.');
            break;

        case 'get.libraries':
            sendResponse(200, 'Libraries loaded.', loadLibraries());
            break;

        case 'get.items':
            if (!$key) {
                throw new Exception("Invalid library.");
            }
            sendResponse(200, 'Items loaded.', loadItems($key));
            break;

        case 'post.refresh':
            if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
                throw new Exception("This cannot be triggered via GET.");
            }
            sendResponse(200, 'Item refreshed.', refresh($key));
            break;
    }
} catch (Exception $e) {
    sendResponse(500, $e->getMessage());
}