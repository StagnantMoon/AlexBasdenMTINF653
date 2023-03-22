<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate Category obj
$category = new Category($db);

$category->id = ($_GET['id']); // gets id 

if (!empty($category->id)) 
{    
    $category->read_single(); // gets category
  // array creation
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    if (!empty($category_arr) && $category_arr['category'] !== null) 
    {
        print_r(json_encode($category_arr)); // json make
    } else {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }
} else {
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
}
?>