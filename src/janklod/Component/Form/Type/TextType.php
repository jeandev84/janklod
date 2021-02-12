<?php
namespace Jan\Component\Form\Type;



use Jan\Component\Form\Type\Support\InputType;


/**
 * Class TextType
 * @package Jan\Component\Form\Type
*/
class TextType extends InputType
{

    /**
     * @return mixed
    */
    public function getType(): string
    {
         return 'text';
    }
}