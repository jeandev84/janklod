<?php
namespace Jan\Component\Service\Captcha;


/**
 * Class Captcha
 *
 * @package Jan\Component\Service\Captcha
*/
class Captcha
{

    // Задаем символы, используемые в капче. Разделитель использовать не надо.
     const CHARS = 'abdefhknrstyz23456789';


     /**
      * @var string
     */
     protected $imageDir;


     /**
      * берем из куки значение MD5 хэша, занесенного туда в captcha.php
      * @var string
     */
     protected $captchaHash;


     /**
      * Captcha constructor.
      * @param string|null $imageDir
     */
     public function __construct(string $imageDir = null)
     {
          if($imageDir)
          {
              $this->setImageDirectory($imageDir);
          }
     }


     /**
      * @param $captchaHash
      * @return $this
     */
     public function setCaptchaHash($captchaHash): Captcha
     {
         $this->captchaHash = $captchaHash;

         return $this;
     }



     /**
      * @param $imageDir
      * @return $this
     */
     public function setImageDirectory($imageDir): Captcha
     {
         $this->imageDir = $imageDir;

         return $this;
     }



     /**
       * @return string
     */
     public function generateCode(): string
     {
         // Задаем длину капчи, в нашем случае - от 4 до 7
         $length = rand(4, 7);

         // Узнаем, сколько у нас задано символов
         $numChars = strlen(self::CHARS);
         $str = '';

         // Генерируем код
         for ($i = 0; $i < $length; $i++) {
             $str .= substr(self::CHARS, rand(1, $numChars) - 1, 1);
         }

         // Перемешиваем, на всякий случай
         $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
         srand ((float)microtime()*1000000);
         shuffle ($array_mix);

         // Возвращаем полученный код
         return implode("", $array_mix);
     }


    /**
     * Пишем функцию генерации изображения
     * @param $code // $code - код нашей капчи, который мы укажем при вызове функции
    */
    function imgCode($code)
    {
        // Отправляем браузеру Header'ы
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Content-Type:image/png");
        // Количество линий. Обратите внимание, что они накладываться будут дважды (за текстом и на текст). Поставим рандомное значение, от 3 до 7.
        $linenum = rand(3, 7);
        // Задаем фоны для капчи. Можете нарисовать свой и загрузить его в папку /img. Рекомендуемый размер - 150х70. Фонов может быть сколько угодно
        $img_arr = array(
            "1.png"
        );
        // Шрифты для капчи. Задавать можно сколько угодно, они будут выбираться случайно
        $font_arr = array();
        $font_arr[0]["fname"] = "DroidSans.ttf";	// Имя шрифта. Я выбрал Droid Sans, он тонкий, плохо выделяется среди линий.
        $font_arr[0]["size"] = rand(20, 30);	    // Размер в pt
        // Генерируем "подстилку" для капчи со случайным фоном
        $n = rand(0,sizeof($font_arr)-1);
        $img_fn = $img_arr[rand(0, sizeof($img_arr)-1)];
        $im = imagecreatefrompng ($this->imageDir . $img_fn);
        // Рисуем линии на подстилке
        for ($i=0; $i<$linenum; $i++)
        {
            $color = imagecolorallocate($im, rand(0, 150), rand(0, 100), rand(0, 150)); // Случайный цвет c изображения
            imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
        }
        $color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200)); // Опять случайный цвет. Уже для текста.

        // Накладываем текст капчи
        $x = rand(0, 35);
        for($i = 0; $i < strlen($code); $i++) {
            $x+=15;
            $letter=substr($code, $i, 1);
            imagettftext ($im, $font_arr[$n]["size"], rand(2, 4), $x, rand(50, 55), $color, $this->imageDir.$font_arr[$n]["fname"], $letter);
        }

        // Опять линии, уже сверху текста
        for ($i=0; $i<$linenum; $i++)
        {
            $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
            imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
        }
        // Возвращаем получившееся изображение
        ImagePNG($im);
        ImageDestroy($im);
    }


    /**
     * Пишем функцию проверки введенного кода
     *
     * @param $code
     * @param $cookie
     * @return bool
    */
    public function checkCode($code, $cookie): bool
    {

            // АЛГОРИТМ ПРОВЕРКИ
            $code = trim($code); // На всякий случай убираем пробелы
            $code = md5($code); // НЕ ЗАБУДЬТЕ ЕГО ИЗМЕНИТЬ!

            // Работа с сессией, если нужно - раскомментируйте тут и в captcha.php, удалите строчки, где используются куки
            //session_start();
            //$cap = $_SESSION['captcha'];
            //$cap = md5($cap);
            //session_destroy();

            if ($code == $this->captchaHash){return TRUE;}else{return FALSE;} // если все хорошо - возвращаем TRUE (если нет - false)
    }


    /**
     * @param $width
     * @param $height
     * @param $img
     * @param $img2
    */
    public function generate($width, $height, $img, $img2)
    {
        // случайные параметры (можно поэкспериментировать с коэффициентами):
        // частоты
        $rand1 = mt_rand(700000, 1000000) / 15000000;
        $rand2 = mt_rand(700000, 1000000) / 15000000;
        $rand3 = mt_rand(700000, 1000000) / 15000000;
        $rand4 = mt_rand(700000, 1000000) / 15000000;
        // фазы
        $rand5 = mt_rand(0, 3141592) / 1000000;
        $rand6 = mt_rand(0, 3141592) / 1000000;
        $rand7 = mt_rand(0, 3141592) / 1000000;
        $rand8 = mt_rand(0, 3141592) / 1000000;
        // амплитуды
        $rand9 = mt_rand(400, 600) / 100;
        $rand10 = mt_rand(400, 600) / 100;

        for($x = 0; $x < $width; $x++){
            for($y = 0; $y < $height; $y++){
                // координаты пикселя-первообраза.
                $sx = $x + ( sin($x * $rand1 + $rand5) + sin($y * $rand3 + $rand6) ) * $rand9;
                $sy = $y + ( sin($x * $rand2 + $rand7) + sin($y * $rand4 + $rand8) ) * $rand10;

                // первообраз за пределами изображения
                if($sx < 0 || $sy < 0 || $sx >= $width - 1 || $sy >= $height - 1){
                    $color = 255;
                    $color_x = 255;
                    $color_y = 255;
                    $color_xy = 255;
                }else{ // цвета основного пикселя и его 3-х соседей для лучшего антиалиасинга
                    $color = (imagecolorat($img, $sx, $sy) >> 16) & 0xFF;
                    $color_x = (imagecolorat($img, $sx + 1, $sy) >> 16) & 0xFF;
                    $color_y = (imagecolorat($img, $sx, $sy + 1) >> 16) & 0xFF;
                    $color_xy = (imagecolorat($img, $sx + 1, $sy + 1) >> 16) & 0xFF;
                }

                // сглаживаем только точки, цвета соседей которых отличается
                if($color == $color_x && $color == $color_y && $color == $color_xy){
                    $newcolor=$color;
                }else{
                    $frsx = $sx - floor($sx); //отклонение координат первообраза от целого
                    $frsy = $sy - floor($sy);
                    $frsx1 = 1 - $frsx;
                    $frsy1 = 1 - $frsy;

                    // вычисление цвета нового пикселя как пропорции от цвета основного пикселя и его соседей
                    $newcolor = floor( $color    * $frsx1 * $frsy1 +
                        $color_x  * $frsx  * $frsy1 +
                        $color_y  * $frsx1 * $frsy  +
                        $color_xy * $frsx  * $frsy );
                }
                imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newcolor, $newcolor, $newcolor));
            }
        }
    }
}