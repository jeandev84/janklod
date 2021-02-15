<!DOCTYPE html>
<meta http-equiv=content-type content="text/html; charset=UTF-8">
<?php

// http://captcha.ru/captchas/multiwave/
// https://habr.com/ru/post/120615/

require __DIR__ . '/../../../../vendor/autoload.php';


// Устанавливаем переменную img_dir, которая примет значение пути к папке со шрифтами и (если потребуется) изображениями
// define ( 'DOCUMENT_ROOT', dirname ( __FILE__ ) );
// define("img_dir", DOCUMENT_ROOT."/captcha/img/"); // Если скрипт отказывается работать, то скорее всего ваш сервер не поддерживает $HTTP_SERVER_VARS. В таком случае, закомментируйте эту строчку и раскомментируйте следующую.
// define("img_dir", "/captcha/img/");

$captcha = new \Jan\Service\Captcha\Core\Captcha(
    dirname(__FILE__)."/captcha/img/"
);

// Подключаем генератор текста
$codeCaptcha = $captcha->generateCode();


// Используем сессию (если нужно - раскомментируйте строчки тут и в go.php)
// session_start();
// $_SESSION['captcha']=$captcha;
// session_destroy();

// Вносим в куки хэш капчи. Куки будет жить 120 секунд.
$cookie = md5($captcha);
$cookieTime = time()+120; // Можно указать любое другое время
setcookie("captcha", $cookie, $cookieTime);


// Выводим изображение
$captcha->imgCode($codeCaptcha);
$captcha->setCaptchaHash($_COOKIE['captcha']);


// LOGIC
// Обрабатываем полученный код
if (isset($_POST['go'])) // Немного бессмысленная, но все же защита: проверяем, как обращаются к обработчику.
{
    // Если код не введен (в POST-запросе поле 'code' пустое)...
    if ($_POST['code'] == '')
    {
        exit("Ошибка: введите капчу!"); //...то возвращаем ошибку
    }
    // Если код введен правильно (функция вернула TRUE), то...
    if ($captcha->checkCode($_POST['code'], $cookie))
    {
        echo "Ты правильно ввел капчу. Возьми с полки тортик, он твой."; // Поздравляем с этим пользователя
    }
    // Если код введен неверно...
    else
    {
        exit("Ошибка: капча введена неверно!"); //...то возвращаем ошибку
    }
}
// Если к нам обращаются напрямую, то дело дрянь...
else
{
    exit("Access denied"); //..., возвращаем ошибку
}