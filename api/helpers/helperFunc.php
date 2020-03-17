<?php

// return bad response output
function failSafeResponse()
{
    $output = new stdClass();
    $output->data = null;
    return $output;
}

// https://www.geeksforgeeks.org/how-to-merge-two-php-objects/
// emulate extend in jquery
function responseMissingFields($obj, $fieldsArr)
{
    $data = new stdClass();
    for ($i = 0; $i < count($fieldsArr); $i++) {
        $field = $fieldsArr[$i];
        if (!isset($obj->{$field}) || empty($obj->{$field})) {
            $data->{$field} = "missing " . $field;
        }
    }
    return $data;
}
