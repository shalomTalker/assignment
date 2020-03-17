<?php
include 'Requester.php';
class Business
{

    // Get All buisnesses
    public function get_all()
    {
        $entryPoint = "getPartnerBusinesses";
        $requester = new Requester();

        return $requester->makeRequest($entryPoint);
    }

    // Get single buisness
    public function get_one($buisness_token)
    {

        $entryPoint = "getBusinessDetails";
        $data = new stdClass();
        $data->businessToken = $buisness_token;
        $requester = new Requester();
        
        return $requester->makeRequest($entryPoint, $data);
    }
    
    public function change_activity($buisness_token,$operation)
    {
        $entryPoint = "{$operation}PartnerBusiness";
        $data = new stdClass();
        $data->businessToken = $buisness_token;
        
        $requester = new Requester();
        return $requester->makeRequest($entryPoint, $data);
    }
   

}
