<?php
namespace Jan\Component\Templating;


/**
 * Class Template
 *
 * @package Jan\Component\Templating
*/
class Template
{

    /**
     * @var string[]
    */
    protected static $tags = [
        "{%" => "<?php ",
        "{{" => "<?= ",
        "%}" => " ?>",
        "}}" => " ?>",
    ];


    /**
     * @param $template
     * @return string|string[]
    */
    public static function replace($template)
    {
        $content = file_get_contents($template);
        return str_replace(self::getTagKeys(), self::getTagValues(), $content);
    }


    /**
     * @param $tags
     * @return array
    */
    protected static function getTagKeys($tags = null): array
    {
        if($tags) {
           self::$tags = $tags;
        }
        return array_keys($tags);
    }


    /**
     * @param $tags
     * @return array
    */
    protected static function getTagValues($tags = null): array
    {
        if($tags) {
            self::$tags = $tags;
        }
        return array_values($tags);
    }

}