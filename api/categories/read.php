<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //Import Database
    include_once '../../config/Database.php';

    //Import Category model
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();//This object is instantiated from the class located in file Database.php
    $db = $database->connect();//The connect method is a method we created in Database.php

    //Instantiate Category object
    $category = new Category($db);//This object is instantiated from the class located in file Category.php and we must pas in a $db object

    //Category query
    $result = $category->read();//The read method is a method we created in Category.php

    //Get row count
    $num = $result->rowCount();//rowCount is a predefined php method

     //Check if any categories
     if($num > 0){
        //Categories array
        $categories_arr = array();
        
        //$categories_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $categories_item = array(
                'id' => $id,
                'category' => $category
            );
            
            /* 
            //Push to 'data'
            array_push($categories_arr['data'], $categories_item);
             */

            //push to array
            array_push($categories_arr, $categories_item);
        }

        // turn to JSON & output
        echo json_encode($categories_arr);
    }else{
        //No Posts
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }
?>