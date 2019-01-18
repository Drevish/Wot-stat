<?php

/**
 * Class Route
 *
 * Router-class for requesting page detection
 * Links models and controllers classes
 * Creates instances of page controllers and calls their methods
 */
class Route {

    static function start() {
        // controller and default action
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // getting controller name
        if ( !empty($routes[1]) ) {
            $controller_name = $routes[1];
        }

        // getting action name
        if ( !empty($routes[2]) ) {
            $action_name = $routes[2];
        }

        // adding prefixes
        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;

        // including file with model class (model can be absent)
        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;
        if(file_exists($model_path)) {
            include "application/models/".$model_file;
        }

        // including file with controller class
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;
        if(file_exists($controller_path)) {
            include "application/controllers/".$controller_file;
        } else {
            Route::ErrorPage404();
        }

        // controller creating
        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action)) {
            // calling controller action
            $controller->$action();
        }
        else {
            Route::ErrorPage404();
        }

    }

    static function ErrorPage404() {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}