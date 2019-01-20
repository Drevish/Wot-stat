<!DOCTYPE>
<html lang="en">
    <head>
        <title>Wot statistics</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon -->
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">

        <!-- Template style -->
        <link rel="stylesheet" href="/css/style.css">
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
                            <a href="/user">Statistics</a>
                        </li>
                        <li class="disabled"><a href="#">TOP</a></li>
                        <li class="disabled"><a href="#">Information</a></li>
                    </ul>

                    <div class="form-wrapper navbar-right">
                        <?php include "application/views/search_user_form.php"; ?>
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

    <!-- JQuery -->
    <script src="/js/jquery-3.3.1.min.js"></script>

    <!-- Popper.js -->
    <script src="/js/popper.min.js"></script>

    <!-- Bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
</html>