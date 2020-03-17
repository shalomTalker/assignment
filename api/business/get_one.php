<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');


include '../models/Business.php';
include '../helpers/helperFunc.php';

// Instantiate Business object
$business = new Business();

// // Get ID
$body = json_decode(file_get_contents("php://input"));

if (isset($body->businessToken) && !empty($body->businessToken)) {
    $businessToken = filter_var($body->businessToken, FILTER_SANITIZE_STRING);
    $output = $business->get_one($businessToken);

    if (isset($output->code) && $output->code === 1) {
        echo json_encode($output->data);
    } else {
        echo json_encode(failSafeResponse());
    }
} else {
    echo json_encode(responseMissingFields($body, ["businessToken"]));
}

