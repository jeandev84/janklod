<form action="go.php" method="post" enctype="multipart/form-data">
    <!-- Форма будет отправлять введенные пользователем данные скрипту go.php методом POST -->
<!--    <img src='captcha.php' id='capcha-image'>-->
    <img src='captcha.png' id='capcha-image'>
    <!-- Сама капча -->
    <a href="javascript:void(0);" onclick="document.getElementById('capcha-image').src='captcha.php?rid=' + Math.random();">Обновить капчу</a>
    <!-- Ссылка на обновление капчи. Запрашиваем у captcha.php случайное изображение.  -->
    <span>Введите капчу:</span>
    <input type="text" name="code">
    <input type="submit" name="go" value="Продолжить">
    <!-- Отправляем данные скрипту-обработчику go.php -->
</form>