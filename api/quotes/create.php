<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

// Instantiate a NEW Database object & connect tothe database
$database = new Database();
$db = $database->connect();

// Instantiate a new Quote object
$quote = new Quote($db);
//Ty Bing :P
$data = json_decode(file_get_contents("php://input")); //get raw data and sets json

if (!$data || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();

}
//sets properties
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

//new create quote - tries
try {
    if ($quote->create()) 
    {
        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id
            )
        );
    }
} catch (PDOException $e) {
    if ($e->getCode() == '23503') {
        $key_value = substr($e->getMessage(), strpos($e->getMessage(), '(') + 1, strpos($e->getMessage(), ')') - strpos($e->getMessage(), '(') - 1);
        if ($key_value === 'author_id') {
            echo json_encode(array('message' => 'author_id Not Found'));
        } else {
            echo json_encode(array('message' => 'category_id Not Found'));
        }
    }
}
?>