<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
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

    //Check to see all parameters exist if they do not send message and exit
    if (!isset($data->quote) || !isset($data->category_id) || !isset($data->author_id)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }elseif(!isset($data->id)){
        echo json_encode(array('message' => 'No Quotes Found'));
        exit(); 
    }

    //Set ID to update
    $quote->id = $data->id;

    //Assign what is in the data to the quote object
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    //Update Post
    if($quote->update()){

         //Create arrays
      $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'category_id' => $quote->category_id,
        'author_id' => $quote->author_id
        );
    
        //Convert to  JSON
        print_r(json_encode($quote_arr));
       
    } else {
        echo json_encode(

        array('message' => 'author_id Not Found',
                'message' => 'category_id Not Found')
        );
    }
     ?>