<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
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

    //Delete Author
    if($author->delete()){
        echo json_encode(
            array('id' => $author->id)
        );
    } else {
        echo json_encode(
        array('message' => 'author_id Not Found')
        );
    }
     ?>