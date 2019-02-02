<!DOCTYPE>
<html lang="en">
    <head>
        <title>
            <?php
                if(isset($data->user_id)) {
                    $id = $data->user_id;
                    echo $data->$id->nickname . "'s statistics";
                } else
                    if(isset($data->motto)) {
                    echo "Clan [$data->tag]";
                }
                else echo 'Wot statistics'; ?>
            </title>

        <meta charset="utf-8">
<!--        <meta name="viewport" content="width=device-width, initial-scale=1">-->

        <meta name="description" content="Wot-stat is a system of a quick and simple view of the full information about any World of Tanks player. Just simply insert the player's nickname in a search field and system will give you all the available information about account or clan you are looking for. ">

        <!-- Favicon -->
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">

        <!-- Template style -->
        <link rel="stylesheet" href="/css/style.css">



        <!-- JQuery -->
        <script src="/js/jquery-3.3.1.min.js"></script>

        <!-- Popper.js -->
        <script src="/js/popper.min.js"></script>

        <!-- Bootstrap -->
        <script src="/js/bootstrap.min.js"></script>

    </head>

    <body>

        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <a href="/" class="navbar-left"><img class="navbar-brand" src="/images/favicon.ico"></a>
                        <a class="navbar-brand" href="/">WOT-STAT</a>
                    </div>

                    <ul class="nav navbar-nav">
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/' ||
                            $_SERVER['REQUEST_URI'] == '/main' ||
                            $_SERVER['REQUEST_URI'] == '/main/index') echo "active"?>">
                            <a href="/">Home</a>
                        </li>
                        <li class="<?php if(substr($_SERVER['REQUEST_URI'], 0, 5) == '/user') echo "active"?>">
                            <a href="/user">User</a>
                        </li>
                        <li class="<?php if(substr($_SERVER['REQUEST_URI'], 0, 5) == '/clan') echo "active"?>">
                        <a href="/clan">Clan</a>
                        </li>
                        <li class="disabled"><a href="#">TOP</a></li>
                        <li class="disabled"><a href="#">Information</a></li>
                    </ul>

                    <div class="form-wrapper navbar-right">
                        <?php
                        if(substr($_SERVER['REQUEST_URI'], 0, 5) == '/user') {
                            include "application/views/search_user_form.php";
                        } else if(substr($_SERVER['REQUEST_URI'], 0, 5) == '/clan') {
                            include "application/views/search_clan_form.php";
                        } else {
                            include "application/views/search_form.php";
                        }
                        ?>
                    </div>

                </div>
            </nav>
        </header>

        <div id="content">
            <?php include 'application/views/'.$content_view; ?>
        </div>


        <hr>
        <footer>
            <div class="container text-center">
                <div class="row">
                    <div>Wot-stat © 2018 <a target="_blank" href="http://drevish.com/">Drevish</a></div>
                    <div><a target="_blank" href="https://worldoftanks.ru/">World of Tanks</a> fan service</div>
                </div>
            </div>
        </footer>

    </body>
</html>