<?php

class Controller_Clan extends Controller {

    function action_index()
    {
        $this->view->generate('clan_view.php', 'template_view.php');
    }

    /**
     * used by getting info from query /clan/getShortUserInfo/user_id where user_id is user's id
     * returns some data about player in json format
     * fields: nickname, wg, battles, victories
     */
    function action_getShortUserInfo() {
        $query = explode('/', $_SERVER['REQUEST_URI']);
        $user_id = (empty($query[3])) ? '' : $query[3];

        $this->model = new Model_Clan();

        try {
            $data = $this->model->getShortUserInfo($user_id);
        }
        catch (Exception $exception) {
            echo null;
        }

        // echo instead of view generating because we simply have to print json string
        echo $data;
    }

    function action_search()
    {
        $query = explode('/', $_SERVER['REQUEST_URI']);
        $clantag = (empty($query[3])) ? '' : $query[3];

        // nickname's too short
        if (strlen($clantag) < 2) {
            $this->view->generate('too_short_clantag_view.php', 'template_view.php', $clantag);
            return;
        }

        // invalid symbols
        preg_match('/[^a-zA-Z0-9_-]/', $clantag, $invalid);
        if (count($invalid) > 0) {
            $this->view->generate('invalid_clantag_view.php', 'template_view.php', $clantag);
            return;
        }

        $this->model = new Model_Clan();

        try {
            $data = $this->model->getData($clantag);
        }
        catch (ClanNotFoundException $exception) {
            $this->view->generate('clan_not_found_view.php', 'template_view.php', $clantag);
            return;
        }
        catch (FailedRequestException $exception) {
            $this->view->generate('failed_request_view.php', 'template_view.php');
            return;
        }

        $this->view->generate('clan_search_view.php', 'template_view.php', $data);
    }
}