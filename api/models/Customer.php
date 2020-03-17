<?php
include 'Requester.php';

class Customer
{
    private $base_url = 'https://devapi.bobile.com/apiV6/partner/';
    private $auth_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJCSUZMUzlKVDBBIiwia2lkIjoiLS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS1cbk1JSUJJakFOQmdrcWhraUc5dzBCQVFFRkFBT0NBUThBTUlJQkNnS0NBUUVBMHgxY003UUZrWWpyUERxcU1mXC9EXG5NeTh5bm11ZGZsNWJWN0F4SGJXVFFyZGU4alwvUUZLVWxuRWdGVHF1NXBRQjIwMkVVS1lydWlyb0VhcHI3TGxnTlxubk9jN2F0VEdwRGRpc1h6K2RRc1dPajBUQkw1M0hMTHNCUHFUMVZqalFPWlBDbUxFUSthQlFac09wcGc1NVpoclxuRHlkWFNGZHpWVEMxYVQ5dlwvUWhoTlpTMDB6cDNVcW05Y3h4Q1wvME9qSGY4WWVkK2x4akppWEJyazBiSWd6VmJ5XG52Z20wM1wvaWZCZitBRHVyMFlmcU1OcU1zcG1CbGh5NXBrZTZQVm4rZ2RPa0VxbmNDYlNjMEV1SXJRQk9iQnNFY1xueXlkYWVDT2ZIMjN3eXFUQ21VYm5SSnlUY1RKRlJON3ZVOXBJMUZLejBTTHNIMjRacHJjb1pLaUFOSmRCYlpRdFxuNXdJREFRQUJcbi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLVxuIiwiaWF0IjoxNTgzNzcxMjE0fQ.4J38Jlo2bae0azL55ts_zzv5tI9oT9gidMyrwte5KGM';
    private $content_type = 'application/json';


    // get customer_list by buisness token 
    public function get_all($buisness_token, $type = '')
    {
        $entryPoint = "getCustomersList";
        $data = new stdClass();
        $data->businessToken = $buisness_token;
        $data->type = $type;

        $requester = new Requester();
        return $requester->makeRequest($entryPoint, $data);
    }
    
    // get one customer
    public function get_one($customer_token)
    {
        $entryPoint = "getCustomer";
        $data = new stdClass();
        $data->customerToken = $customer_token;
    
        $requester = new Requester();
        return $requester->makeRequest($entryPoint, $data);

    }

    // add customer
    public function add_customer($body)
    {
        $entryPoint = "addCustomer";
        $requester = new Requester();

        return $requester->makeRequest($entryPoint, $body);
    }

    // update customer
    public function update_customer($updatedCustomer)
    {

        $output = $this->get_one($updatedCustomer->customerToken);
        $data= $output->data;
        // validate if exist etc
        $data->customerToken = $updatedCustomer->customerToken;
        $data->customer_name = (!empty($updatedCustomer->customer_name)) ? $updatedCustomer->customer_name : $data->customer_name;
        $data->customer_email = (!empty($updatedCustomer->customer_email)) ? $updatedCustomer->customer_email : $data->customer_email;
        $data->customer_phone1 = (!empty($updatedCustomer->customer_phone1)) ? $updatedCustomer->customer_phone1 : $data->customer_phone1;
        $data->customer_phone2 = (!empty($updatedCustomer->customer_phone2)) ? $updatedCustomer->customer_phone2 : $data->customer_phone2;
        $data->customer_address = (!empty($updatedCustomer->customer_address)) ? $updatedCustomer->customer_address : $data->customer_address;
        $data->customer_city = (!empty($updatedCustomer->customer_city)) ? $updatedCustomer->customer_city : $data->customer_city;
        // $data->customer_zip = (!empty($updatedCustomer->zip)) ? $updatedCustomer->customer_zip : $data->customer_zip;
        // $data->customer_state = (!empty($updatedCustomer->state)) ? $updatedCustomer->customer_state : $data->customer_state;
        // $data->customer_country = (!empty($updatedCustomer->country)) ? $updatedCustomer->customer_country : $data->customer_country;
        // $data->customer_gender = (!empty($updatedCustomer->gender)) ? $updatedCustomer->customer_gender : $data->customer_gender;
        // $data->customer_birth_date = (!empty($updatedCustomer->birth_date)) ? $updatedCustomer->customer_birth_date : $data->customer_birth_date;
        // $data->customer_wedding_date = (!empty($updatedCustomer->wedding_date)) ? $updatedCustomer->customer_wedding_date : $data->customer_wedding_date;

        $entryPoint = "updateCustomer";
        $requester = new Requester();

        return $requester->makeRequest($entryPoint, $data);
    }

}
