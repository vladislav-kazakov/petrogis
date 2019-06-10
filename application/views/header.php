<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= lang("gis_petroglyphs"); ?></title>

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <!-- fancyBox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script>

    <?php
    if (!empty($page)) {
        switch ($page) {
            case 'e_double':
                echo '<link rel="stylesheet" href="' . base_url() . 'assets/css/edouble.css" />';
                break;
        }
    }
    ?>

</head>
<body>
8888
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= base_url() ?><?= lang("lang"); ?>"><?= lang("gis_petroglyphs"); ?></a>
        </div>
        <div id="navbar">
            <ul class="nav navbar-nav">
                <li class="<?php if ($menu == 'map'): ?>active<?php endif ?>"><a href="<?= base_url() . lang("lang") ?>map"><?= lang("menu_map"); ?></a></li>
                <li class="<?php if ($menu == 'petroglyph'): ?>active<?php endif ?>"><a href="<?= base_url() . lang("lang"); ?>petroglyph"><?= lang("menu_petroglyphs"); ?></a></li>
                <!--li class="<?php if ($menu == 'contact'): ?>active<?php endif ?>"><a href="#contact">Contact</a></li>
                <li class="<?php if ($menu == 'signup'): ?>active<?php endif ?>"><a href="#signup">Sign up</a></li-->
            </ul>

            <div class="navbar-right">
                <p class="navbar-text">
                    <a class="navbar-link active" href="<?= $this->config->config['canonical_route'] ?>">ru</a> |
                    <a class="navbar-link" href="/en<?= $this->config->config['canonical_route'] ?>">en</a>
                </p>

                <?php if ($logged_in): ?>
                    <p class="navbar-text">
                        <?= lang("hello"); ?>, <?= $username ?>!
                    </p>
                    <form class="navbar-form navbar-right" action="<?= base_url() . lang("lang") ?>logout"
                          method="post">
                        <button type="submit" class="btn btn-success"><?= lang("logout"); ?></button>
                    </form>
                <?php else: ?>
                    <form class="navbar-form navbar-right" action="<?= base_url() . lang("lang") ?>login" method="post">
                        <div class="form-group">
                            <input type="text" name="email" placeholder="Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success"><?= lang("login"); ?></button>
                    </form>
                <?php endif ?>
            </div>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

