<?php
namespace Jan\Component\Templating;


/**
 * Class Asset
 * @package Jan\Component\Templating
*/
class Asset
{

     const CSS_BLANK = '<link href="%s" rel="stylesheet">';
     const JS_BLANK  = '<script src="%s" type="application/javascript"></script>';


     /**
      * @var array
     */
     private $css = [];



     /**
      * @var array
     */
     private $js = [];


     /**
      * @var string
     */
     private $baseUrl;


     /**
      * Asset constructor.
      * @param string $baseUrl
     */
     public function __construct(string $baseUrl = '')
     {
          if($baseUrl) {
              $this->setBaseUrl($baseUrl);
          }
     }



     /**
      * @param $baseUrl
     */
     public function setBaseUrl($baseUrl)
     {
          $this->baseUrl = rtrim($baseUrl, '\\/');
     }


     /**
      * Add css link
      *
      * @param string $link
     */
     public function css(string $link)
     {
          $this->css[] = $link;
     }


     /**
      * @param array $styles
     */
     public function addStylesheets(array $styles)
     {
         $this->css = array_merge($this->css, $styles);
     }


     /**
      * @param array $scripts
     */
     public function addScripts(array $scripts)
     {
        $this->js = array_merge($this->js, $scripts);
     }


     /**
      * Get css data
      *
      * @return array
     */
     public function getStyleSheets(): array
     {
          return $this->css;
     }


     /**
       * Add js link
       *
       * @param string $js
     */
     public function js(string $js)
     {
          $this->js[] = $js;
     }


     /**
      * Get css data
      *
      * @return array
     */
     public function getScripts(): array
     {
         return $this->js;
     }


     /**
      * Render css format html
      *
      * @return string
     */
     public function renderCss(): string
     {
         return $this->printHtml($this->css, self::CSS_BLANK);
     }


     /**
      * @param $link
      * @return string
     */
     public function renderOnceCss($link)
     {
         return sprintf(self::CSS_BLANK, $this->generateUrl($link));
     }


    /**
     * @param $script
     * @return string
    */
    public function renderOnceJs($script)
    {
        return sprintf(self::JS_BLANK, $this->generateUrl($script));
    }


    /**
     * Render js format html
     *
     * @return string
    */
    public function renderJs(): string
    {
        return $this->printHtml($this->js, self::JS_BLANK);
    }


    /**
     * Print html format
     *
     * @param array $resourceFiles
     * @param string $blankTemplate
     * @return string
    */
    protected function printHtml(array $resourceFiles, string $blankTemplate): string
    {
        $html = [];

        foreach ($resourceFiles as $filename)
        {
             $html[] = sprintf($blankTemplate, $this->generateUrl($filename));
        }

        return join("\n", $html);
    }


    /**
     * @param $filename
     * @return string|string[]
    */
    public function generateUrl($filename)
    {
        return $this->baseUrl . '/'. trim($filename, '\/');
    }


    /**
     * @return string
    */
    public function __toString(): string
    {
        return '';
    }
}