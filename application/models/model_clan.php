<?php

require_once __ROOT__.'/statistics/Statistics.php';
require_once __ROOT__.'/statistics/UserStatistics.php';

class Model_Clan extends Model {

    /** Gets clan id from wot api using clantag as a search field
     * @param $clantag clan's tag
     * @return string clan id
     * @throws ClanNotFoundException
     * @throws FailedRequestException
     */
    private function getClanId($clantag) {
        $response = $this->getDataFromAPI(
            "https://api.worldoftanks.ru/wgn/clans/list/?" .
            "application_id=$this->application_id&limit=1&search=[$clantag]&fields=clan_id");

        // no account with such nickname or with nickname which starts with this letters
        if (count($response->data) == 0) {
            throw new ClanNotFoundException($clantag);
        }

        $clan_id = $response->data[0]->clan_id;

        return $clan_id;
    }

    private function getClanData($clan_id) {
        $response = $this->getDataFromAPI(
            "https://api.worldoftanks.ru/wgn/clans/info/?application_id=$this->application_id" .
            "&clan_id=$clan_id&fields=description_html%2C+tag%2C+motto%2C+created_at%2C+emblems.x195%2C+" .
            "members.role_i18n%2C+members.joined_at%2C+members.account_id%2C+color%2C+name%2C+clan_id");

        $response = $response->data->$clan_id;

        return $response;
    }

    public function getData($clantag = null)
    {
        $clan_id = $this->getClanId($clantag);

        $clan_data = $this->getClanData($clan_id);

        return $clan_data;
    }

    public function getShortUserInfo($user_id = null) {
        $response = $this->getDataFromAPI(
            "https://api.worldoftanks.ru/wot/account/info/?application_id=$this->application_id" .
            "&account_id=$user_id&fields=nickname%2C+global_rating%2C+statistics.all.battles%2C+statistics.all.wins");

        $response = $response->data->$user_id;


        $userStatisticsJSON = $this->getDataFromAPI(
            "https://api.worldoftanks.ru/wot/tanks/stats/?application_id=$this->application_id&account_id=$user_id" .
            "&fields=tank_id%2C+all.battles%2C+all.frags%2C+all.damage_dealt%2C+all.spotted%2C+all.wins%2C+all.dropped_capture_points");
        $userStatistics = new UserStatistics($userStatisticsJSON->data->$user_id);


        $WN8 = $userStatistics->getWN8();

        $data = [
          'nickname' => $response->nickname,
            'wg' => number_format($response->global_rating, '0', '', ' '),
            'WGcolor' => Statistics::getColorByWG($response->global_rating),
            'battles' => number_format($response->statistics->all->battles, '0', '', ' '),
            'victories' => number_format($response->statistics->all->wins / $response->statistics->all->battles * 100, '2'),
            'winrateColor' => Statistics::getColorByWinrate($response->statistics->all->wins / $response->statistics->all->battles * 100),
            'WN8' => $WN8,
            'WN8color' => Statistics::getColorByWN8($WN8)
        ];

        return json_encode($data);
    }
}