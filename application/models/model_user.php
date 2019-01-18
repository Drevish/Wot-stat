<?php

class Model_User extends Model {

    private $curl;

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
     * @param $nickname user nickname or user's nickname left part
     * @return string user id
     */
    private function getUserId($nickname) {

        curl_setopt($this->curl, CURLOPT_URL,
            "https://api.worldoftanks.ru/wot/account/list/?application_id=$this->application_id&search=$nickname");

        $response = curl_exec($this->curl);
        $response = json_decode($response);

        // no account with such nickname or with nickname which starts with this letters
        if (count($response->data) == 0) {
            // TODO OWN EXCEPTION CLASSES FOR THIS MODEL
            // TODO PARCE EXCEPTIONS
            throw \http\Exception;
        }

        $user_id = $response->data[0]->account_id;

        return $user_id;
    }

    function getData($nickname = null)
    {
        // looking for user id by nickname
        $user_id = $this->getUserId($nickname);

        curl_setopt($this->curl, CURLOPT_URL,
            "https://api.worldoftanks.ru/wot/account/info/?application_id=$this->application_id&account_id=$user_id");

        $response = curl_exec($this->curl);
        $response = json_decode($response);

        echo '<pre>';
        var_dump($response);
        echo '</pre>';

        return $user_id;
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }
}