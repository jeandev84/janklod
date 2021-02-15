<?php
namespace Jan\Component\Form\Type;


use Jan\Component\Form\Type\Support\InputType;


/**
 * Class HiddenType
 * @package Jan\Component\Form\Type
*/
class HiddenType extends InputType
{


    /**
     * @return string
    */
    public function getType(): string
    {
        return 'hidden';
    }
}