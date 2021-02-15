<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--    <link rel="stylesheet" href="/assets/bootstrap/fonts/font-awesome.min.css">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= app_name() ?></title>
</head>
<body>

<?php include('partials/nav.php'); ?>
<div class="container mt-5">
    <h1>Регистрация</h1>
    <hr>
    <form action="/user/sign-up" method="POST" enctype="multipart/form-data">
       <div class="row">
           <div class="col-4">
               <div class="form-group">
                   <label for="surname">Фамилия</label>
                   <input type="text" name="surname" class="form-control" id="surname">
               </div>
           </div>
           <div class="col-4">
               <div class="form-group">
                   <label for="name">Имя</label>
                   <input type="text" name="name" class="form-control" id="name">
               </div>
           </div>
           <div class="col-4">
               <div class="form-group">
                   <label for="patronymic">Отчество</label>
                   <input type="text" name="patronymic" class="form-control" id="patronymic">
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-6">
               <div class="form-group">
                   <label for="region">Электронная почта</label>
                   <input type="email" name="email" class="form-control" id="email">
               </div>
           </div>
           <div class="col-6">
               <div class="form-group">
                   <label for="region">Регион</label>
                   <select name="region" id="region" class="form-control">
                       <option value="moscow">Москва</option>
                       <option value="petersburg">Санкт-Петербург</option>
                       <option value="kurgan">Курган</option>
                       <option value="yekaterinburg">Екатеринбург</option>
                   </select>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-6">
               <div class="form-group">
                   <label for="password">Пароль</label>
                   <input type="password" name="password" class="form-control" id="password">
               </div>
           </div>
           <div class="col-6">
               <div class="form-group">
                   <label for="confirm_password">Подтверждение пароля</label>
                   <input type="password" name="confirm_password" class="form-control" id="confirm_password">
               </div>
           </div>
       </div>
        <div class="form-group">
            <label for="" style="margin-right: 10px;">Какие у тебя Хобби ?</label>
            <input type="checkbox" class="form-group" name="hobbies[]" value="sport" style="cursor: pointer;"> Спорт
            <input type="checkbox" class="form-group" name="hobbies[]" value="music" style="cursor: pointer;"> Музыки
            <input type="checkbox" class="form-group" name="hobbies[]" value="dance" style="cursor: pointer;"> Танцы
            <input type="checkbox" class="form-group" name="hobbies[]" value="museum" style="cursor: pointer;"> Музей
        </div>

        <div class="form-group">
            <label for="">Поле:</label>
            <input type="radio" name="sex" id="male" value="male"> Мужской
            <input type="radio" name="sex" id="female" value="female"> Женский
        </div>
        <div class="form-group">
            <!--<input type="radio" name="agree" id="agree" style="cursor: pointer;">-->
            <input type="checkbox" name="agree" id="agree" style="cursor: pointer;">
            <label for="agree">Соглашение об обработке персональных данных</label>
        </div>
        <!--
        <div class="form-group">
            <label for="">Загрузить Файл: (Фото)
                <input type="file" name="brochure[]" multiple="multiple" class="form-control">
            </label>
        </div>
        -->
        <input type="hidden" name="_token" value="qwerty123456A">
        <!--
        <input type="hidden" name="_method" value="PUT">
        -->
        <button type="submit" class="btn btn-primary">Сохранить</button>
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