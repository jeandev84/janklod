# FORM
```
<?php
namespace Jan\Component\Form;


use Jan\Component\Form\Contract\FormInterface;
use Jan\Component\Form\Type\Support\AbstractType;




/**
 * Class Form
 * @package Jan\Component\Form
*/
class Form implements FormInterface
{

      /**
       * @var array
      */
      protected $types = [];


      /**
       * @var bool
      */
      // protected $started = false;



      /**
       * Form constructor.
      */
      public function __construct()
      {
          // $this->createType(FormStartType::class);
      }

//
//      /**
//        * @param array $options
//        * @return Form
//      */
//      public function open(array $options = []): Form
//      {
//            $attrs = [];
//
//            if(! $this->started)
//            {
//                $attrs = [
//                  'method' => 'GET',
//                  'action' => '/',
//                  'attr'   => $options
//                ];
//
//                $this->types[] = new FormStartType('', $attrs);
//                $this->started = true;
//            }
//
//            return $this;
//      }

//
//      /**
//       * close form
//      */
//      public function close()
//      {
//           if($this->started)
//           {
//               $this->types[] = "</form>";
//
//               $this->started = false;
//           }
//      }


       /**
        * @param string $child
        * @param string|null $type
        * @param array $options
        * @return $this
       */
       public function add(string $child, string $type = null, array $options = []): Form
       {
            if($type = $this->createType($type, $child, $options))
            {
                 $this->types[] = $type;
            }

            return $this;
       }


      /**
       * @return array
      */
      public function getTypes(): array
      {
          return $this->types;
      }


      /**
       * Create a view form
      */
      public function createView(): string
      {
          $html = [];

         foreach ($this->getTypes() as $formType)
         {
             $html[] = $formType->buildHtml();
         }

         return join("\n", $html);
      }


      /**
       * @param string|null $type
       * @param string $child
       * @param array $options
       * @return AbstractType|null
      */
      protected function createType(?string $type, string $child = '', array $options = []): ?AbstractType
      {
          if(is_null($type))
          {
              return null;
          }

          $type = new $type($child, $options);

          return $type instanceof AbstractType ? $type : null;
      }
}
```