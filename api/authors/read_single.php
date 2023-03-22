<?php

include_once "../../config/Database.php";
include_once "../../models/Author.php";

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate Author obj
    $author = new Author($db);
    $author->id = ($_GET['id']); // gets the id

if (!empty($author->id)) // get author
{
    $author->read_single();

    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    ); // array creation

    if (!empty($author_arr) && $author_arr['author'] !== null) 
    {   
        print_r(json_encode($author_arr)); //json make
    } else { // no id or category
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }
} else {
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
}
?>