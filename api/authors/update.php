<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

    //Import Database
    include_once '../../config/Database.php';

    //Import Author model
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();//This object is instantiated from the class located in file Database.php
    $db = $database->connect();//The connect method is a method we created in Database.php

     //Instantiate Author object
     $author = new Author($db);//This object is instantiated from the class located in file Author.php and we must pas in a $db object

    //GET raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $author->id = $data->id;

    //Assign what is in the data to the author object
    $author->author = $data->author;

    //Update Post
    if($author->update()){
          //Create arrays

        $author_arr = array(
        'id' => $author->id,
        'author' => $author->author,
        );
    
        //Convert to  JSON
        print_r(json_encode($author_arr));
       
    } else {
        echo json_encode(
        array('message' => 'author_id Not Found')
        );
    }
     ?>