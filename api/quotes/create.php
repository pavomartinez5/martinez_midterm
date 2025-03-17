<?php
//Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
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
    }
    
    //Assign what is in the data to the post
    $quote->quote = $data->quote;
    $quote->category_id = $data->category_id;
    $quote->author_id = $data->author_id;
    
    //Create Post
    if($quote->create()){
        
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
        if($quote->author_id === null){
            echo json_encode(
                array('message' => 'author_id Not Found')
                );
        }elseif($quote->category_id === null){
            echo json_encode(
                array('message' => 'category_id Not Found')
                );
        }else{
            echo json_encode(
            array('message' => 'No Quotes created')
            );
     } 
    }
?>