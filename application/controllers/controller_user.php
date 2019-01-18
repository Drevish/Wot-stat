<?php

class Controller_User extends Controller {

    function action_index()
    {
        $this->view->generate('user_view.php', 'template_view.php');
    }

    function action_search()
    {
        $query = explode('/', $_SERVER['REQUEST_URI']);
        $nickname = (empty(query[3])) ? '' : $query[3];

        $this->model = new Model_User();

        $data = $this->model->getData($nickname);

        $this->view->generate('search_view.php', 'template_view.php', $data);
    }
}