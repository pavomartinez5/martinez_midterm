<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //Import Database
    include_once '../../config/Database.php';

    //Import Author model
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();//This object is instantiated from the class located in file Database.php
    $db = $database->connect();//The connect method is a method we created in Database.php

    //Instantiate Author object
    $author = new Author($db);//This object is instantiated from the class located in file Author.php and we must pas in a $db object

    //Get ID form url
    //Logic Statement if id is set in request(Example: something.com?id=3 ), then set to id that was requested to author id, else end
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    //Check to see if read_single was successful
    if ($author->read_single()){
       
        //Create arrays
        $author_arr = array(
        'id' => (int)$author->id,
        'author' => $author->author,
        );
    
        //Convert to  JSON
        print_r(json_encode($author_arr));
    }else{
        echo json_encode(
            array('message' => 'author_id Not Found'));
    }

?>
