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
    <h1>Контакты</h1>
    <hr>
    <form action="/contact" method="POST" enctype="multipart/form-data">
       <div class="row">
          <div class="col-4">
              <div class="form-group">
                  <label for="">Ф.И.О</label>
                  <input type="text" name="fullname" class="form-control">
              </div>
          </div>
           <div class="col-4">
               <div class="form-group">
                   <label for="">Электронная почта</label>
                   <input type="email" name="email" class="form-control">
               </div>
           </div>
           <div class="col-4">
               <div class="form-group">
                   <label for="">Адресс</label>
                   <input type="text" name="address" class="form-control">
               </div>
           </div>
       </div>
        <div class="row">
           <div class="col-12">
               <div class="form-group">
                   <label for="comment">Комментария: </label>
                   <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
               </div>
           </div>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
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