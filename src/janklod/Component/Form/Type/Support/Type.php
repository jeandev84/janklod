<?php
namespace Jan\Component\Form\Type\Support;


use Jan\Component\Form\Type\Traits\FormTrait;


/**
 * Class AbstracType
 * @package Jan\Component\Form\Type\Support
*/
abstract class Type
{

     use FormTrait;

     /**
      * @var string
     */
     protected $child;


     /**
      * @var array
     */
     protected $options;


     /**
       * AbstractType constructor.
       * @param string $child
       * @param array $options
     */
     public function __construct(string $child, array $options)
     {
          $this->child   = $child;
          $this->options = $options;
     }


     /**
      * @param $key
      * @param null $default
      * @return mixed|null
     */
     public function getOption($key, $default = null)
     {
        return $this->options[$key] ?? $default;
     }


     /**
      * @param $key
      * @param $value
      * @return Type
     */
     public function setOption($key, $value): Type
     {
         $this->options[$key] = $value;

         return $this;
     }


      /**
       * @param array $options
       * @return $this
     */
     public function setOptions(array $options): Type
     {
         $this->options = array_merge($this->options, $options);

         return $this;
     }


     /**
      * @param $key
      * @return bool
     */
     public function hasOption($key): bool
     {
         return isset($this->options[$key]);
     }


     /**
      * @return string
     */
     public function getAttributes(): string
     {
         $attrs = $this->getOption('attr', []);

         return $this->buildAttributes($attrs);
      }


      /**
       * @return string
      */
      public function buildLabel(): string
      {
          $html = '';

          if($label = $this->getOption('label'))
          {
              $html .= '<label for="id">'. $this->getLabel() .'</label>';
          }

          return $html;
      }


      /**
       * @return mixed|string
      */
      public function getLabel(): string
      {
           return $this->getOption('label', ucfirst($this->child));
      }


      /**
       * @return string
      */
      public function getType(): string
      {
        // TODO implements in child class if you need
      }



      abstract public function buildHtml();
}