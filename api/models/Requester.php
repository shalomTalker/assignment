<?php

class Requester
{
    private $base_url = 'https://devapi.bobile.com/apiV6/partner/';
    private $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJCSUZMUzlKVDBBIiwia2lkIjoiLS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS1cbk1JSUJJakFOQmdrcWhraUc5dzBCQVFFRkFBT0NBUThBTUlJQkNnS0NBUUVBMHgxY003UUZrWWpyUERxcU1mXC9EXG5NeTh5bm11ZGZsNWJWN0F4SGJXVFFyZGU4alwvUUZLVWxuRWdGVHF1NXBRQjIwMkVVS1lydWlyb0VhcHI3TGxnTlxubk9jN2F0VEdwRGRpc1h6K2RRc1dPajBUQkw1M0hMTHNCUHFUMVZqalFPWlBDbUxFUSthQlFac09wcGc1NVpoclxuRHlkWFNGZHpWVEMxYVQ5dlwvUWhoTlpTMDB6cDNVcW05Y3h4Q1wvME9qSGY4WWVkK2x4akppWEJyazBiSWd6VmJ5XG52Z20wM1wvaWZCZitBRHVyMFlmcU1OcU1zcG1CbGh5NXBrZTZQVm4rZ2RPa0VxbmNDYlNjMEV1SXJRQk9iQnNFY1xueXlkYWVDT2ZIMjN3eXFUQ21VYm5SSnlUY1RKRlJON3ZVOXBJMUZLejBTTHNIMjRacHJjb1pLaUFOSmRCYlpRdFxuNXdJREFRQUJcbi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLVxuIiwiaWF0IjoxNTgzNzcxMjE0fQ.4J38Jlo2bae0azL55ts_zzv5tI9oT9gidMyrwte5KGM';
    private $content_type = 'application/json';

    public function makeRequest($entryPoint, $data = null)
    {
        // make curl GET/POST request
        $curl = curl_init($this->base_url . $entryPoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if (!is_null($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization:' . $this->token, 'Content-Type:' . $this->content_type]);

        $response = curl_exec($curl);
        curl_close($curl);

        // check JSON validity
        if ($this->isJson($response)) {
            $decoded = json_decode($response);
            return $decoded;
        } else {
            $emptyObj = new stdClass();
            return $emptyObj;
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
