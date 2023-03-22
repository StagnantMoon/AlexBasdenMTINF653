<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";
// Instantiate DB AND CONENCT
$database = new Database();
$db = $database->connect();
// instantiate Quote obj
$quote = new Quote($db);
$data = json_decode(file_get_contents("php://input")); // data get


$response = array();
if (!$data || !isset($data->id)) 
{
    $response['message'] = 'Missing Required Parameters';
} else {
    $quote->id = $data->id;
   
    if ($quote->delete()) {//deletes the quote
        $response['id'] = $quote->id;
    } else {
        $response['message'] = 'No Quotes Found';
    }
} //checks the array
echo json_encode($response);
?>