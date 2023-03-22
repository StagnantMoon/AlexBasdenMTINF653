<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate Author obj
$author = new Author($db);
$data = json_decode(file_get_contents("php://input")); // get the raw data

if (!$data || !isset($data->author)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
} else {
    $author->author = $data->author;
    if ($author->create()) { //author create
        echo json_encode(
            array(
                'id' => $author->id,
                'author' => $author->author
            )
        );
    } else {
        echo json_encode(
            array('message' => 'author_id not found')
        );
    }
} // checks if author parament exists yay
?>
