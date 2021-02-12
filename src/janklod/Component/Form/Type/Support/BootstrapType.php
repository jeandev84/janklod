<?php
namespace Jan\Component\Form\Type\Support;


/**
 * Class BootstrapType
 * @package Jan\Component\Form\Type\Support
*/
abstract class BootstrapType extends InputType
{

      /**
       * @return string
      */
      public function buildHtml(): string
      {
          $html = '<div class="form-group">';
          $html .= parent::buildHtml();
          $html .= '</di>';
          return $html;
      }
}