<?php
namespace Jan\Component\Templating;


/**
 * Class ViewExtension
 *
 * @package Jan\Component\Templating
*/
class ViewExtension
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
    public static function map($template)
    {
        $content = file_get_contents($template);
        return str_replace(self::getTagKeys(), self::getTagValues(), $content);
    }


    /**
     * @param $tags
     * @return array
    */
    public static function getTagKeys($tags = null): array
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
    public static function getTagValues($tags = null): array
    {
        if($tags) {
            self::$tags = $tags;
        }
        return array_values($tags);
    }

}