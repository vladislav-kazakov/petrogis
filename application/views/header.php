<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= lang("gis_petroglyphs"); ?></title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"-->
    <link rel="stylesheet" type="text/css"
          href="/assets/css/screen.css"/>
    <!-- Custom styles for this template -->
    <link href="/assets/css/style.css?v2" rel="stylesheet">
    <!-- Optional theme -->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"-->

    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <!-- fancyBox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>


<div class="fluid-container">
    <div class="row">
        <header class="pageheader col-xs-12 ">
            <nav class="navbar">
                <div class="row">
                    <div class="navbar-header col-xs-12 col-sm-2">
                        <div class="page-logo">
                            <a href="https://www.ugent.be/en" class="link" title="Home Ghent University">
                                <img class="th-en"
                                     src="https://www.ugent.be/++theme++ugent/static/images/logo_ugent_en.svg"
                                     alt="Ghent University">
                            </a>
                        </div>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse col-sm-10" role="navigation">
                        <div class="row menu">
                            <div class="col-xs-12">
                                <div class="bg-primary spacer">
                                    <div class="row">
                                        <div class="col-xs-12">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row menu">
                            <div class="col-xs-12 col-md-4 col-sm-4">
                                <ul class="nav-primary nav navbar-nav main-top-nav">
                                    <li class="<?php  if ($menu == 'map'): ?>active<?php  endif ?>"><a
                                                href="<?= base_url() . lang("lang") ?>map"><span><?= lang("menu_map"); ?></span></a>
                                    </li>
                                    <li class="<?php  if ($menu == 'petroglyph'): ?>active<?php  endif ?>"><a
                                                href="<?= base_url() . lang("lang"); ?>petroglyph"><?= lang("menu_petroglyphs"); ?></a>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <?php  if ($logged_in): ?>
                                    <form class="navbar-form navbar-right"
                                          action="<?= base_url() . lang("lang") ?>logout" method="post">
                                        <p class="navbar-text ">
                                            <?= lang("hello"); ?>, <?= $username ?>!
                                        </p>
                                        <button type="submit" class="btn btn-success"><?= lang("logout"); ?></button>
                                    </form>
                                <?php  else: ?>
                                    <form class="navbar-form navbar-right"
                                          action="<?= base_url() . lang("lang") ?>login" method="post">
                                        <div class="form-group">
                                            <input type="text" name="email" placeholder="Email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Password"
                                                   class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-success"><?= lang("login"); ?></button>
                                    </form>
                                <?php  endif ?>
                            </div>
                        </div>
                    </div>
                </div>

            </nav>

            <div class="row branding-wrapper">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 branding-container header_title faculty-2">
                    <a href="/">
                        <h1>AMSP: Altai Mountains Survey Project</h1>
                    </a>
                </div>
            </div>

        </header>
    </div>
</div>
<div class="container">

