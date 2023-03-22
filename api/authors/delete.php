<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();

//instantiate author object
$author = new Author($db);
$data = json_decode(file_get_contents("php://input")); // gets the data

if (!$data || !isset($data->id)) {
    echo json_encode(
        array('message' => "Missing Required Parameters")
    );
} else {
    $author->id = $data->id;
    if ($author->delete()) { // delets the author
        echo json_encode(
            array('id' => $author->id)
        );
    } else {
        echo json_encode(
            array('message' => 'author_id not found')
        );
    }
} // checks if id exists
?>