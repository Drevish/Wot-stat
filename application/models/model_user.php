<?php

require_once __ROOT__.'/statistics/Statistics.php';
require_once __ROOT__.'/statistics/TankStatistics.php';
require_once __ROOT__.'/statistics/UserStatistics.php';

class Model_User extends Model {

    private $tanksDatabaseFile = DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."tanksDatabase.dat";

    /**
     * @param $nickname user nickname or user's nickname left part
     * @return string user id
     * @throws AccountNotFoundException
     * @throws FailedRequestException
     */
    private function getUserId($nickname) {

        $response = $this->getDataFromAPI(
                "https://api.worldoftanks.ru/wot/account/list/?application_id=$this->application_id&search=$nickname");

        // no account with such nickname or with nickname which starts with this letters
        if (count($response->data) == 0) {
            throw new AccountNotFoundException($nickname);
        }

        $user_id = $response->data[0]->account_id;

        return $user_id;
    }

    /**
     * @param $clan_id clan id
     * @return mixed clan info object
     * @throws FailedRequestException
     */
    private function getClanInfo($clan_id) {

        $response = $this->getDataFromAPI(
            "https://api.worldoftanks.ru/wgn/clans/info/?application_id=$this->application_id" .
            "&clan_id=$clan_id&fields=tag%2C+name%2C+clan_id");

        $response = $response->data->$clan_id;

        return $response;
    }

    /**
     * Gets info about user's tanks and their statistics
     * @param $user_id account id
     * @return mixed data object
     * @throws FailedRequestException
     */
    private function getTanksInfo($user_id) {

        $response = $this->getDataFromAPI(
            "https://api.worldoftanks.ru/wot/tanks/stats/?application_id=$this->application_id" .
            "&account_id=$user_id");

        $response = $response->data->$user_id;

        return $response;
    }

    /**
     * Downloads and saves tanks info database to a $tanksDatabaseFile
     */
    private function saveTanksDatabase () {
        $response = $this->getJsonFromAPI(
            "https://api.worldoftanks.ru/wot/encyclopedia/vehicles/?application_id=$this->application_id");

        $file = fopen($_SERVER['DOCUMENT_ROOT'].$this->tanksDatabaseFile, 'w');
        fwrite($file, $response);
    }

    /**
     * Reads from file and decodes tanks database
     */
    private function getTanksDatabase() {
        $filename = $_SERVER['DOCUMENT_ROOT'].$this->tanksDatabaseFile;

        $file = fopen( $filename, 'r');
        $tanksDatabaseJson = fread($file, filesize($filename));
        $tanksDatabase = json_decode($tanksDatabaseJson);
        $tanksDatabase = $tanksDatabase->data;

        return $tanksDatabase;
    }

    private function getExpectedValues() {
        $filename = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."expected_tank_values.dat";
        $file = fopen( $filename, 'r');
        $expected_tank_values = fread($file, filesize($filename));
        return unserialize($expected_tank_values);
    }




    function getData($nickname = null)
    {
        // looking for user id by nickname
        $user_id = $this->getUserId($nickname);

        $response = $this->getDataFromAPI(
            "https://api.worldoftanks.ru/wot/account/info/?application_id=$this->application_id&account_id=$user_id");

        $response = $response->data;

        $response->user_id = $user_id;

        // if player is in a clan get clan info and assign it to the response
        if ($response->$user_id->clan_id != null) {
            $response->clan_info = $this->getClanInfo($response->$user_id->clan_id);
        }

        // get player's tanks statistics
        $response->tanks = $this->getTanksInfo($user_id);

        // get tanks database
        $response->tanksDatabase = $this->getTanksDatabase();

        // calculate wn8 for the whole account and add it to the response
        $userStatistics = new UserStatistics($response->tanks);
        $response->WN8 = $userStatistics->getWN8();
        $response->WN8color = Statistics::getColorByWN8($response->WN8);


        // calculate wn8 for user's tanks and add it to the response
        foreach ($response->tanks as &$tank) {
            $tankStatistics = new TankStatistics($tank);
            $tank->WN8 = $tankStatistics->getWN8();
        }


//        $this->saveTanksDatabase();
        return $response;
    }
}