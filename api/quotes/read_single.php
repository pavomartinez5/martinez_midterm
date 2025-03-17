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

    //Get ID form url
    //Logic Statement if id is set in request(Example: something.com?id=3 ), then set to id that was requested to quote id, else end

    if(isset($_GET['id'])){
        $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    }else if(isset($_GET['author_id'])){ 
        $quote->author = isset($_GET['author_id']) ? $_GET['author_id'] : die();
        if(isset($_GET['category_id'])){
            $quote->category = isset($_GET['category_id']) ? $_GET['category_id'] : die(); 
        }
    }else{
        $quote->category = isset($_GET['category_id']) ? $_GET['category_id'] : die(); 
    }

 
    //Quote query
    $result = $quote->read_single();//The read method is a method we created in Quote.php

    //Get row count
    $num = $result->rowCount();//rowCount is a predefined php method

     //Check if any quotes
     if($num === 1){
    
        //Quotes array
    $quotes_arr = array();
            
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $quotes_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );
    }

        // turn to JSON & output
        echo json_encode($quotes_arr);
            

     }elseif($num > 1){
        //Quotes array
        $quotes_arr = array();
        
        /* 
        $quotes_arr['data'] = array();
         */

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quotes_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );


           /*  
           //Push to 'data'
            array_push($quotes_arr['data'], $quotes_item);
            */

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





/*     //Check to see if read_single was successful
    if ($quote->read_single()){
       
        //Create arrays
        $quote_arr = array(
        'id' => (int)$quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category,
        );
    
        //Convert to  JSON
        print_r(json_encode($quote_arr));
    }else{
        echo json_encode(
            array('message' => 'No Quotes Found'));
    }  */

?>
