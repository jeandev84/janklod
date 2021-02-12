<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- TODO helper renderCss() -->
    <?= asset('assets/css/app.css') ?>
    <?= asset('assets/css/bootstrap.min.css') ?>
    <!-- <link rel="stylesheet" href="/assets/css/bootstrap.min.css"> -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--    <link rel="stylesheet" href="/assets/bootstrap/fonts/font-awesome.min.css">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= app_name() ?></title>
</head>
<body>

<?php include('partials/nav.php'); ?>
<div class="container mt-5">
    <h1>Главная</h1>
    <hr>
    <p>You are ready for bulding your <code>web site ...</code></p>
</div>

<footer>
    <div class="container">
        <!--        <a href="https://github.com/jeandev84/janklod" class="nav-link" target="_blank">-->
        <!--            Github <i class="fa fa-github"></i>-->
        <!--        </a>-->
    </div>
</footer>
<!-- scripts -->
<!-- TODO helper renderJs() -->
<script src="/assets/js/bootstrap.min.js" type="application/javascript"></script>
</body>
</html>