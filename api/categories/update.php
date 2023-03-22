<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate Category obj
$category = new Category($db);
$data = json_decode(file_get_contents("php://input")); // get the data

if (!$data || !isset($data->category) || !isset($data->id))
{
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
} else {
    $category->category = $data->category;
    $category->id = $data->id;
    
    if ($category->update()) { //updates category
        echo json_encode(
            array(
                'id' => $category->id,
                'category' => $category->category
            )
        );
    } else {
        echo json_encode(
            array('message' => 'category_id Not found')
        );
    }
} // if function checks the id & category parameters
?>