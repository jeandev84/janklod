<?php
namespace Jan\Component\Templating;


use Jan\Component\Templating\Contract\ViewInterface;
use Jan\Component\Templating\Exception\ViewException;



/**
 * Class View
 * @package Jan\Component\Templating
*/
class View implements ViewInterface
{


      /**
       * @var string
      */
      protected $resource;


      /**
       * @var string
      */
      protected $template;



      /**
       * @var array
      */
      protected $variables = [];




      /**
       * View constructor.
       *
       * @param string $resource
      */
      public function __construct(string $resource = '')
      {
           if($resource) {
               $this->resource($resource);
           }
      }


      /**
        * @param string $resource
        * @return $this
      */
      public function resource(string $resource): View
      {
          $this->resource = rtrim($resource, '\\/');

          return $this;
      }


      /**
       * Set variables
       *
       * @param $variables
       * @return $this
      */
      public function setVariables(array $variables): View
      {
           $this->variables = array_merge($this->variables, $variables);

           return $this;
      }


      /**
       * @param $template
       * @return $this
      */
      public function setTemplate($template): View
      {
          $this->template = $template;

          return $this;
      }



      /**
       * Render view template and optional data
       *
       * @return false|string
       * @throws ViewException
      */
      public function renderHtml()
      {
           $template = $this->resourceTemplate($this->template);

           if(! file_exists($template))
           {
              throw new ViewException(sprintf('view file %s does not exist!', $template));
           }

           extract($this->variables, EXTR_SKIP);

           ob_start();
           require_once($template);
           return ob_get_clean();
      }



      /**
       * Render html template with availables variables
       *
       *  @param string $template
       *  @param array $variables
       *  @return false|string
       *  @throws ViewException
     */
     public function render($template, $variables = [])
     {
           return $this->setTemplate($template)
                       ->setVariables($variables)
                       ->renderHtml();
     }



     /**
      * @param string $template
      * @return string
     */
     public function resourceTemplate(string $template)
     {
         return $this->resource . DIRECTORY_SEPARATOR . $this->resolveTemplatePath($template);
     }


     /**
      * @param $template
      * @return string|string[]
     */
     protected function resolveTemplatePath($template)
     {
         return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, ltrim($template, '\\/'));
     }
}