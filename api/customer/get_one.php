<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');


include_once '../models/Customer.php';
include '../helpers/helperFunc.php';
// Instantiate Business object
$customer = new Customer();

// // Get ID
$body = json_decode(file_get_contents("php://input"));
if (isset($body->customerToken)&&!empty($body->customerToken)) {
    $customer_token = filter_var($body->customerToken, FILTER_SANITIZE_STRING);
    $output = $customer->get_one($customer_token);
    if (isset($output->code) && $output->code === 1) {
        echo json_encode($output->data);
    } else {
        echo json_encode(failSafeResponse());
    }
} else {
    echo json_encode(responseMissingFields($body, ["customerToken"]));
}
