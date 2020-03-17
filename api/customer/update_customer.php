<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include '../models/Customer.php';
include '../helpers/helperFunc.php';


// Instantiate blog post object
$customer = new Customer();

// Get raw posted data
$body = json_decode(file_get_contents("php://input"));

if (isset($body->customerToken) && !empty($body->customerToken)) {
    $body->customerToken = filter_var($body->customerToken, FILTER_SANITIZE_STRING);
    $body->customer_name = filter_var($body->customer_name, FILTER_SANITIZE_STRING);
    $body->customer_email = filter_var($body->customer_email, FILTER_SANITIZE_STRING);
    $body->customer_phone1 = filter_var($body->customer_phone1, FILTER_SANITIZE_STRING);
    $body->customer_phone2 = filter_var($body->customer_phone2, FILTER_SANITIZE_STRING);
    $body->customer_address = filter_var($body->customer_address, FILTER_SANITIZE_STRING);
    $body->customer_city = filter_var($body->customer_city, FILTER_SANITIZE_STRING);
    // $body->customer_zip = filter_var($body->customer_zip, FILTER_SANITIZE_STRING);
    // $body->customer_state = filter_var($body->customer_state, FILTER_SANITIZE_STRING);
    // $body->customer_country = filter_var($body->customer_country, FILTER_SANITIZE_STRING);
    // $body->customer_gender = filter_var($body->customer_gender, FILTER_SANITIZE_STRING);
    // $body->customer_birth_date = filter_var($body->customer_birth_date, FILTER_SANITIZE_STRING);
    // $body->customer_wedding_date = filter_var($body->customer_wedding_date, FILTER_SANITIZE_STRING);

    $output = $customer->update_customer($body);
    
    if (isset($output->code) && $output->code === 1) {
        echo json_encode($body);
    } else {
        echo json_encode(failSafeResponse());
    }
} else {
    echo json_encode(responseMissingFields($body, ["customerToken"]));
}

