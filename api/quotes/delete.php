<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

    //Import Database
    include_once '../../config/Database.php';

    //Import Quote model
    include_once '../../models/Quote.php';

    //Instantiate DB & connect
    $database = new Database();//This object is instantiated from the class located in file Database.php
    $db = $database->connect();//The connect method is a method we created in Database.php

     //Instantiate Quote object
     $quote = new Quote($db);//This object is instantiated from the class located in file Quote.php and we must pas in a $db object

    //GET raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $quote->id = $data->id;

    //Delete Quote
    if($quote->delete()){
        echo json_encode(
            array('id' => $quote->id)
        );
    } else {
        echo json_encode(
        array('message' => 'No Quotes Found')
        );
    }
     ?>