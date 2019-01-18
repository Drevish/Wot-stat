<?php

class View {

    // public $template_view = 'template_view.php';

    /**
     * @param $content_view view that is unique for every page and shows content
     * @param $template_view template view for all website or for it's part
     * @param null $data array that contains data for controller and gets filled in a model
     */
    function generate($content_view, $template_view, $data = null) {

        // extracting array elements to the variables
        if (is_array($data)) {
            extract($data);
        }

        // dynamical template including
        include 'application/views/'.$template_view;
    }

}