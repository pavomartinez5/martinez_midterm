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

    //Get ID form url
    //Logic Statement if id is set in request(Example: something.com?id=3 ), then set to id that was requested to category id, else end
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    //Check to see if read_single was successful
    if ($category->read_single()){
       
        //Create arrays
        $category_arr = array(
        'id' => (int)$category->id,
        'category' => $category->category,
        );
    
        //Convert to  JSON
        print_r(json_encode($category_arr));
    }else{
        echo json_encode(
            array('message' => 'category_id Not Found'));
    }

?>
