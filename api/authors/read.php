<?php

include_once "../../config/Database.php";
include_once "../../models/Author.php";

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate Author obj
$author = new Author($db);

    $result = $author->read(); //reads author query
    $num = $result->rowCount(); //gets row count

if ($num > 0) 
{
    $author_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        array_push($author_arr, $author_item); //push the data
    }
    echo json_encode($author_arr); //json output
} else {
    echo json_encode(
        array('message' => 'author_id is Not Found')
    );
}//checks if authors exists
?>