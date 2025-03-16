<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

    //Import Database
    include_once '../../config/Database.php';

    //Import Category model
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();//This object is instantiated from the class located in file Database.php
    $db = $database->connect();//The connect method is a method we created in Database.php

     //Instantiate Category object
     $category = new Category($db);//This object is instantiated from the class located in file Category.php and we must pas in a $db object

    //GET raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $category->id = $data->id;

    //Assign what is in the data to the category object
    $category->category = $data->category;

    //Update Post
    if($category->update()){
          //Create arrays

        $category_arr = array(
        'id' => $category->id,
        'category' => $category->category,
        );
    
        //Convert to  JSON
        print_r(json_encode($category_arr));
       
    } else {
        echo json_encode(
        array('message' => 'category_id Not Found')
        );
    }
     ?>