<?php

namespace App\Service;

class CurlService
{


    public function __construct()
    {
    }

    public function executer(string $APIUrl): array
    {
        $result=["success"=>false,"message"=>"No action","data"=>[]];
        try {
            $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_URL,$APIUrl);
            $response=curl_exec($ch);
            curl_close($ch);

            $result["success"]=true;
            $result["message"]="Successfully";
            $result["data"]=$response;
        }catch (\Exception $exception){
            $result["message"]=$exception->getMessage();
        }
        return $result;
    }
}