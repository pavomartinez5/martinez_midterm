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

    //Author query
    $result = $author->read();//The read method is a method we created in Author.php

    //Get row count
    $num = $result->rowCount();//rowCount is a predefined php method

     //Check if any authors
     if($num > 0){
        //Authors array
        $authors_arr = array();
        $authors_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $authors_item = array(
                'id' => $id,
                'author' => $author
            );

            //Push to 'data'
            array_push($authors_arr['data'], $authors_item);
        }

        // turn to JSON & output
        echo json_encode($authors_arr);
    }else{
        //No Posts
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }
?>