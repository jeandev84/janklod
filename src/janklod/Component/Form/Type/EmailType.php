<?php
namespace Jan\Component\Form\Type;


use Jan\Component\Form\Type\Support\InputType;


/**
 * Class EmailType
 * @package Jan\Component\Form\Type
*/
class EmailType extends InputType
{


    /**
     * @return string
    */
    public function getType(): string
    {
        return 'email';
    }
}