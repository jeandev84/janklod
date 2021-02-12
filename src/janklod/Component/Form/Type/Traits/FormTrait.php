<?php
namespace Jan\Component\Form\Type\Traits;


use Jan\Component\Form\Type\Support\Type;
use Jan\Component\Form\Type\TextType;

/**
 * Trait FormTrait
 * @package Jan\Component\Form\Type\Traits
*/
trait FormTrait
{

     /**
      * @param array $attrs
      * @return string
     */
     public function buildAttributes(array $attrs): string
     {
         $str = '';

         foreach ($attrs as $key => $value)
         {
             if(is_string($value))
             {
                 $str .= sprintf(' %s="%s"', $key, $value);
             }
         }

         return $str;
     }




    /**
     * @param string|null $type
     * @param string $child
     * @param array $options
     * @return Type|null
    */
    protected function resolveFieldType(?string $type, string $child, array $options = []): ?Type
    {
        if(is_null($type))
        {
            return new TextType($child, $options);
        }

        $type = new $type($child, $options);

        return $type instanceof Type ? $type : null;
    }
}