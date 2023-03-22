<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

//Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate category obj
$category = new Category($db);

// gets teh data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id)) 
{
    echo json_encode(
        array('message' => "Missing Required Parameters")
    );
} else {
    $category->id = $data->id;
    // delete category
    if ($category->delete()) {
        echo json_encode(
            array('id' => $category->id)
        );
    } else {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }
} // checks if category exits if statment
?>