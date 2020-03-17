<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include '../models/Business.php';

// Instantiate Business object
$business = new Business();
$response = $business->get_all();
if(count($response->data)===0){
    return false;
}
echo json_encode($response->data);
