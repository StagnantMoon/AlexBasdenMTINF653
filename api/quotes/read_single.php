<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

//Instantiate DB AND CONNECT 
$database = new Database();

$db = $database->connect();

//instantiate the QUOTE obj
$quote = new Quote($db);


$quote->id = ($_GET['id']);// get the ID

if (!empty($quote->id)) 
{
    $quote->read_single(); //get the quote

    if (!empty($quote->quote)) 
    {    
        $quote_arr = array( //array creation
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author_id,
            'category' => $quote->category_id
        );
       //json make
        echo json_encode($quote_arr);
    } else {
        
        echo json_encode(
            array('message' => 'No Quotes Were Found')//no quotes were found
        );
    }
} else {
    
    echo json_encode( //no id parameter is Foriegn key in db
        array('message' => 'quote_id Not Found')
    );
}

?>