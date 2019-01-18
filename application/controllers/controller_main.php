<?php

class Controller_Main extends Controller {

    function action_index() {
        $query = $_SERVER['REQUEST_URI'];
        $data = array(
            'nickname' => $query
        );
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

}
