<?php
// Headers

/* 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


// Get HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

 */

 //Headers for deploying on web
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Route based on HTTP method 
switch ($method) {
    case 'GET':
        //Check to see if id is provided in the request
        isset($_GET['id']) || isset($_GET['author_id']) || isset($_GET['category_id'])
        //Route to read_single.php if an id is provided
        ? include_once 'read_single.php'
        // Route to read.php
        :include_once 'read.php';
        break;

    case 'POST':
        // Route to create.php
        include_once 'create.php';
        break;

    case 'PUT':
        // Route to update.php
        include_once 'update.php';
        break;

    case 'DELETE':
        // Route to delete.php
        include_once 'delete.php';
        break;

    default:
        // Invalid method
        echo json_encode(array('message' => 'Method Not Allowed'));
        break;
}
?>
