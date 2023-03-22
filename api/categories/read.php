<?php

include_once "../../config/Database.php";
include_once "../../models/Category.php";

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();
//instantiate Category obj
$category = new Category($db);

$result = $category->read();//reads category query
$num = $result->rowCount(); // get row count

if ($num > 0) {
  
    $category_arr = array(); // category array

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        array_push($category_arr, $category_item); // pushes data
    }
    echo json_encode($category_arr); // json output
} else {
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
}// checks if category exists
?>