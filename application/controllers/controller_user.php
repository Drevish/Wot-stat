<?php

class Controller_User extends Controller {

    function action_index()
    {
        $this->view->generate('user_view.php', 'template_view.php');
    }

    function action_search()
    {
        $query = explode('/', $_SERVER['REQUEST_URI']);
        $nickname = (empty($query[3])) ? '' : $query[3];

        // nickname's too short
        if (strlen($nickname) < 3) {
            $this->view->generate('too_short_nickname_view.php', 'template_view.php', $nickname);
            return;
        }

        // invalid symbols
        preg_match('/[^a-zA-Z0-9_]/', $nickname, $invalid);
        if (count($invalid) > 0) {
            $this->view->generate('invalid_nickname_view.php', 'template_view.php', $nickname);
            return;
        }

        $this->model = new Model_User();

        try {
            $data = $this->model->getData($nickname);
        }
        catch (AccountNotFoundException $exception) {
            $this->view->generate('account_not_found_view.php', 'template_view.php', $nickname);
            return;
        }
        catch (FailedRequestException $exception) {
            $this->view->generate('failed_request_view.php', 'template_view.php');
            return;
        }

        $this->view->generate('account_view.php', 'template_view.php', $data);
    }
}