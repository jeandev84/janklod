<?php
namespace Jan\Component\Templating\Contract;


/**
 * Interface ViewInterface
 * @package Jan\Component\Templating\Contract
*/
interface ViewInterface extends RenderInterface
{
     /**
      * @param $template
      * @param array $variables
      * @return mixed
     */
     public function render($template, $variables = []);
}