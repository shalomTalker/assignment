<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include '../models/Customer.php';
include '../helpers/helperFunc.php';

// Instantiate Business object
$customer = new Customer();

$body = json_decode(file_get_contents("php://input"));

if (isset($body->businessToken) && !empty($body->businessToken)) {
    $businessToken = filter_var($body->businessToken, FILTER_SANITIZE_STRING);
    $type = "";
    if (isset($body->type)) {
        $type = filter_var($body->type, FILTER_SANITIZE_STRING);
    }
    $output = $customer->get_all($businessToken, $type);
    if (isset($output->code) && $output->code === 1) {
        echo json_encode($output->data);
    } else {
        echo json_encode(failSafeResponse());
    }
} else {
    echo json_encode(responseMissingFields($body, ["businessToken"]));
}
