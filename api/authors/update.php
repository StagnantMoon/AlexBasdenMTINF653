<?php

include_once "../../config/Database.php";
include_once "../../models/Author.php";

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate Author obj
$author = new Author($db);
$data = json_decode(file_get_contents("php://input")); // get raw posted datas

if (!$data || !isset($data->author) || !isset($data->id)) 
{
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
} else {
    $author->author = $data->author;
    $author->id = $data->id;
    
    if ($author->update()) //updates author
    {
        echo json_encode(
            array(
                'id' => $author->id,
                'author' => $author->author
            )
        );
    } else {
        echo json_encode(
            array('message' => 'author_id Not found')
        );
    }
} // checks author and id paraments
?>