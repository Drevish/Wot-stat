<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__.'/core/exceptions.php';

class Model {

    protected $application_id = '4e801652d5218a02d9c506f75f6c3fd5';

    // curl descriptor
    protected $curl;

    public function __construct()
    {
        // gets user statistics using wot api and returns it
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);   //Follow redirects, if any
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, false);          //We don't need the header
        curl_setopt($this->curl, CURLOPT_ENCODING, "");           // Accept any encoding
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
    }



    /**
     * @param $url string url which be used for the request
     * @return string data in json format
     * @throws FailedRequestException
     */
    protected function getJsonFromAPI($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);

        $response = curl_exec($this->curl);

        // failed request
        if (!$response)
            throw new FailedRequestException();

        return $response;
    }

    /**
     * @param $url string url which be used for the request
     * @return mixed response object, decoded from json
     * @throws FailedRequestException
     */
    protected function getDataFromAPI($url) {

        $response = $this->getJsonFromAPI($url);

        $response = json_decode($response);

        //failed request
        if ($response->status == 'error')
            throw new FailedRequestException();

        return $response;
    }



    public function getData() { }

    public function __destruct()
    {
        curl_close($this->curl);
    }
}