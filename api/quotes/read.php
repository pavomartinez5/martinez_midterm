<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //Import Database
    include_once '../../config/Database.php';

    //Import Quote model
    include_once '../../models/Quote.php';

    //Instantiate DB & connect
    $database = new Database();//This object is instantiated from the class located in file Database.php
    $db = $database->connect();//The connect method is a method we created in Database.php

    //Instantiate Quote object
    $quote = new Quote($db);//This object is instantiated from the class located in file Quote.php and we must pas in a $db object

    //Quote query
    $result = $quote->read();//The read method is a method we created in Quote.php

    //Get row count
    $num = $result->rowCount();//rowCount is a predefined php method

     //Check if any quotes
     if($num > 0){
        //Quotes array
        $quotes_arr = array();

       /*  //Figure out what this does?
        $quotes_arr['data'] = array(); */

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quotes_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            /* //Push to 'data'
            array_push($quotes_arr['data'], $quotes_item); */

            //push to array
            array_push($quotes_arr, $quotes_item);
        }

        // turn to JSON & output
        echo json_encode($quotes_arr);
    }else{
        //No Posts
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
?>