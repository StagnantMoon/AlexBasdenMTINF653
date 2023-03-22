<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

// Instantiate DB AND CONNECT
$database = new Database();
$db = $database->connect();

//instantiate Quote object
$quote = new Quote($db);
//rseads Quote query and get row count
$result = $quote->read();
$num = $result->rowCount();
if ($num > 0) { //checks categories
    
    $quote_arr = array(); //array quote

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author_name,
            'category' => $category_name
        );
        array_push($quote_arr, $quote_item);
    }
    echo json_encode($quote_arr);//output json
} else {
    echo json_encode(
        array('message' => 'quote_id Not Found')
    );
}
?>