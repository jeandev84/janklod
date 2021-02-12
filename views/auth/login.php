<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--    <link rel="stylesheet" href="/assets/bootstrap/fonts/font-awesome.min.css">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= app_name() ?></title>
</head>
<body>

<?php include('partials/nav.php'); ?>
<div class="container mt-5">
    <h1>Вход</h1>
    <form action="/auth/user" method="POST" enctype="multipart/form-data">
       <div class="row">
           <div class="col-md-6">
               <div class="form-group">
                   <label for="">Логин</label>
                   <input type="email" name="email" class="form-control">
               </div>
               <div class="form-group">
                   <label for="">Пароль</label>
                   <input type="password" name="password" class="form-control">
               </div>
               <input type="hidden" name="_token" value="qwerty123456A">
               <button type="submit" class="btn btn-primary">Войти</button>
           </div>
       </div>
    </form>
</div>
<footer>
    <div class="container">
        <!--        <a href="https://github.com/jeandev84/janklod" class="nav-link" target="_blank">-->
        <!--            Github <i class="fa fa-github"></i>-->
        <!--        </a>-->
    </div>
</footer>
<!-- scripts -->
<script src="/assets/js/bootstrap.min.js" type="application/javascript"></script>
</body>
</html>