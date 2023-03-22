<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";
//Instantiate a NEW DB OBJECT AND CONNECT TO THE DB
$database = new Database();
$db = $database->connect();

//instantiate a NEW Quote obj.
$quote = new Quote($db);
$data = json_decode(file_get_contents("php://input")); //gsets the raw post dataa

if (!$data || !isset($data->quote) || !isset($data->id) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
} else {
//Properties of Quote obj setting:
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;
    $quote->id = $data->id;
    
    try {
        if ($quote->update()) { //create new quote
            echo json_encode(
                array(
                    'id' => $quote->id,
                    'quote' => $quote->quote,
                    'author_id' => $quote->author_id,
                    'category_id' => $quote->category_id
                )
            );
        } else {
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    } catch (PDOException $e) { //PDOException - I got suck here had to search engine it with Bing.
        if ($e->getCode() == '23503') {
            $key_value = substr($e->getMessage(), strpos($e->getMessage(), '(') + 1, strpos($e->getMessage(), ')') - strpos($e->getMessage(), '(') - 1);
            if ($key_value === 'author_id') {
                echo json_encode(
                    array('message' => 'author_id Not Found')
                );
            } else {
                echo json_encode(
                    array('message' => 'category_id Not Found')
                );
            }
        }
    }
}
?>